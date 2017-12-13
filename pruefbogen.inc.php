<?php

/*
 *  Copyright (C) 2001 Kai Blaschke <webmaster@thw-theorie.de>
 *
 *  The included 'THW Thema' templates, logos and the Q&A catalog are protected
 *  by copyright laws, and must not be used without the written permission
 *  of the
 *
 *  Bundesanstalt Technisches Hilfswerk
 *  Provinzialstraße 93
 *  D-53127 Bonn
 *  Germany
 *  E-Mail: redaktion@thw.de
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */
 
/*
* 
* Vollständiger Prüfungsbogen mit zufälligen Fragen
* 
*/

$tpl->parseBlock('page-body', 'NavBogen', 'Sublinks');
$tpl->addVars('navBogen', 'current');

if (isset($_REQUEST['create']) && $_REQUEST['create'] == '1') {
    // Neuen Bogen erstellen    
    unset($_SESSION['bogen']);
    
    // Werte initialisieren
    $_SESSION['bogen']['StartTime'] = time();
    $_SESSION['bogen']['Fragen'] = Array();
    
    // Anz. Abschnitte und Fragen aus der DB holen
    $sectionCount = getSingleResult('SELECT COUNT(*) FROM abschnitte WHERE Jahr = ?', array('i', $_SESSION['jahr']));

    $stmt = $GLOBALS['db']->prepare('SELECT ID, Abschnitt FROM fragen WHERE Jahr = ? ORDER BY Abschnitt, Nr ASC');
    $stmt->bind_param('i', $_SESSION['jahr']);
    $stmt->execute();
    $stmt->bind_result($questionId, $questionSection);

    // Fragen in Array übertragen
    while ($stmt->fetch()) {
       $fragen[$questionId] = $questionSection;
    }
    $stmt->close();
    
    // Gesamtanzahl Fragen
    $count_ab = array_count_values($fragen);

    // Eine Frage pro Themengebiet aus der DB holen
    for ($i = 1; $i <= $sectionCount; $i++) {
        $nr = rand(1, $count_ab[$i]);
        $id = getSingleResult('SELECT ID FROM fragen WHERE Nr = ? AND Abschnitt = ? AND Jahr = ?',
            array('iii', $nr, $i, $_SESSION['jahr']));

        array_push($_SESSION['bogen']['Fragen'], (int)$id);
        
        // Frage entfernen
        unset($fragen[$id]);
    }
    
    // Restliche Fragen zufällig auffüllen
    // Dazu verbliebene Keys von $fragen als Values in neues Array $fragen2 kopieren,
    // da shuffle() die Keys verwirft!
    $fragen2 = Array();
    foreach ($fragen As $key => $value) {
        array_push($fragen2, $key);
    }
    shuffle($fragen2);
    for ($i = 0; $i < 40 - $sectionCount; $i++) {
        array_push($_SESSION['bogen']['Fragen'], array_shift($fragen2));
    }
    
    // Fragen erneut mischen
    shuffle($_SESSION['bogen']['Fragen']);

}

if (isset($_SESSION['bogen'])) {
    if (isset($_POST['antwort'])) {
        // Fragen beantwortet
        $richtig    = 0;
        $falsch     = 0;
        $fragen_cnt = count($_SESSION['bogen']['Fragen']);
        $zeit       = time()-$_SESSION['bogen']['StartTime'];
        
        for ($i = 0; $i < $fragen_cnt; $i++) {
            $id = $_SESSION['bogen']['Fragen'][$i];
            $solutionBitmask = getSingleResult('SELECT `Loesung` FROM `fragen` WHERE `ID` = ?',
                array('i', $id));
            
            $loesung = array( 1 => ( $solutionBitmask & 0x1),
                              2 => (($solutionBitmask & 0x2) >> 1),
                              3 => (($solutionBitmask & 0x4) >> 2));

            if (isset($_POST['antwort'][$id])) {
                $korrekt = (($loesung[1] == (isset($_POST['antwort'][$id][1]) ? $_POST['antwort'][$id][1] : 0))
                         && ($loesung[2] == (isset($_POST['antwort'][$id][2]) ? $_POST['antwort'][$id][2] : 0))
                         && ($loesung[3] == (isset($_POST['antwort'][$id][3]) ? $_POST['antwort'][$id][3] : 0)));
            } else{
                $korrekt = false;
            }
            
            if ($korrekt) {
                $_SESSION["stats"]['Fragen_Richtig']++;
                $richtig++;
            } else {
                $_SESSION["stats"]['Fragen_Falsch']++;
                $falsch++;
            }
            $_SESSION["stats"]['Fragen_Bisher']++;
        }

        $_SESSION["stats"]['Boegen_Bisher']++;
        
        if (($richtig / $fragen_cnt) >= 0.8)
            $_SESSION["stats"]['Boegen_Bestanden']++;
        else
            $_SESSION["stats"]['Boegen_Durchgefallen']++;

        $GLOBALS['db']->query('UPDATE statistik SET fragen=fragen+' . $fragen_cnt
                   .',richtig=richtig+' . $richtig
                   .',falsch=falsch+' . $falsch
                   .',boegen=boegen+1'
                   .',bestanden=bestanden+' . (($richtig / $fragen_cnt) >= 0.8?1:0)
                   .',durchgefallen=durchgefallen+' . (($richtig / $fragen_cnt) < 0.8?1:0));

        $tpl->addTemplates('content', 'bogen-ende');
        
        $tpl->addVars(Array(
                'anzFragen'          => count($_SESSION['bogen']['Fragen']),
                'zeit'               => sprintf('%02d:%02d\'%02d', $zeit / 3600, ($zeit/60)%60, $zeit%60),
                'fragenRichtig'      => $richtig,
                'fragenRichtigQuote' => sprintf('%.2f %%', $richtig / $fragen_cnt * 100),
                'fragenFalsch'       => $falsch,
                'fragenFalschQuote'  => sprintf('%.2f %%', $falsch / $fragen_cnt * 100)
        ));
        
        if (($richtig / $fragen_cnt) >= 0.8)
            $tpl->parseBlock('content', 'Bestanden', 'Ja');
        else
            $tpl->parseBlock('content', 'Bestanden', 'Nein');

        for ($i=0; $i<count($_SESSION['bogen']['Fragen']); $i++) {
            if ($i>0 && $i%10==0) {
                // 'Nach oben'-Zeile an Handle anhängen
                $tpl->parseBlock('content', 'Aufloesung', 'Topline', TRUE);
            }
            Answer($_SESSION['bogen']['Fragen'][$i], $_POST['antwort'], FALSE);
            $tpl->parseBlock('content', 'Aufloesung', 'Antwort', TRUE, TRUE);
        }
        
        unset($_SESSION['bogen']);
    }
    else {
        // Fragen anzeigen
        $tpl->addTemplates(Array(
                'content' => 'bogen-fragen'                    
        ));

        $tpl->addVars(Array(
                'zeit' => date('G:i', $_SESSION['bogen']['StartTime'])
        ));
        
        for ($i=0; $i<count($_SESSION['bogen']['Fragen']); $i++) {
            if ($i>0 && $i%10==0) {
                $tpl->parseBlock('content', 'Bogen', 'Topline', TRUE);
            }

            // Frage aus DB holen
            $question = getQuestionById($_SESSION['bogen']['Fragen'][$i]);
            
            $tpl->addVars(Array(
                    'frageIndex'  => $i + 1,
                    'frageID'     => $question['ID'],
                    'frageNr'     => $question['Nr'],
                    'abschnittNr' => $question['Abschnitt'],
                    'frageText'   => $question['Frage'],
                    'Antwort1'    => $question['Antwort1'],
                    'Antwort2'    => $question['Antwort2'],
                    'Antwort3'    => $question['Antwort3']
            ));
            
            if ($question['Antwort3'] == '') {
                $tpl->addVars('rowCnt', '2');
                $tpl->delBlockHandle('content', 'ThreeRows');
            }
            else {
                $tpl->addVars('rowCnt', '3');
                $tpl->parseBlock('content', 'ThreeRows', 'Row');
            }
            
            $tpl->parseBlock('content', 'Bogen', 'Frage', TRUE, TRUE);
        }

    }
}
else {
    $tpl->addVars('navBogenNeu', 'current');
    $tpl->addTemplates(Array('content' => 'bogen-start'));
}
