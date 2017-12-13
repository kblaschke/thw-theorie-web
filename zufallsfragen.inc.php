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
* Fragen in zufälliger Reihenfolge üben
* 
*/

$tpl->parseBlock('page-body', 'NavZufall', 'Sublinks');
$tpl->addVars('navZufall', 'current');

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'neu') {
    // Fragenkatalog löschen
    unset($_SESSION['zufallsfragen']);
}

if (isset($_SESSION['zufallsfragen'])) {
    // Fragenkatalog schon vorhanden. Zu nächster unbeantworteter Frage
    // bzw. Antwort der letzten Frage springen
    // Wenn keine Fragen mehr im Katalog vorhanden sind,
    // Statistik anzeigen.
        
    if (count($_SESSION['zufallsfragen'])==0) {
        // Alle Fragen beantwortet, Ergebnis zeigen
        $tpl->addVars(Array(
                'anzFragen'          => $_SESSION['fragen_cnt'],
                'fragenRichtig'      => $_SESSION['zufallstats']['Richtig'],
                'fragenRichtigQuote' => sprintf('%.2f %%', $_SESSION['zufallstats']['Richtig'] / $_SESSION['fragen_cnt'] * 100),
                'fragenFalsch'       => $_SESSION['zufallstats']['Falsch'],
                'fragenFalschQuote'  => sprintf('%.2f %%', $_SESSION['zufallstats']['Falsch'] / $_SESSION['fragen_cnt'] * 100),
        ));    
        
        $tpl->addTemplates('content', 'zufallsfragen-ende');
        

        
        if (($_SESSION['zufallstats']['Richtig'] / $_SESSION['fragen_cnt']) >= 0.8) {
            $tpl->parseBlock('content', 'Bestanden', 'Ja');
        } else {                
            $tpl->parseBlock('content', 'Bestanden', 'Nein');
        }
        
        // Sessiondaten löschen
        unset($_SESSION['zufallsfragen']);
        unset($_SESSION['frage_nr']);
        unset($_SESSION['fragen_cnt']);
        unset($_SESSION['zufallstats']);
        unset($_SESSION['bogen']);
        
        return;
        
    }
    
       
    if (!isset($_REQUEST['frage_id']) || $_REQUEST['frage_id'][0] <> $_SESSION['zufallsfragen'][0]) {
        $tpl->addTemplates(Array('content' => 'zufallsfragen-frage'));
        
        // Frage stellen
        SingleQuestion($_SESSION['zufallsfragen'][0], $_SESSION['frage_nr'], $_SESSION['fragen_cnt']);
    
        return;        
    }
    
    $tpl->addTemplates(Array('content' => 'zufallsfragen-aufloesung'));
    
    // Antwort auswerten
    
    questionHeader($_REQUEST['frage_id'][0], $_SESSION['frage_nr'], $_SESSION['fragen_cnt'], $_SESSION['jahr']);
    $korrekt = Answer($_REQUEST['frage_id'][0], $_REQUEST['antwort']);
    
    // Statistik anpassen
    if ($korrekt) {
        $_SESSION['zufallstats']['Richtig']++;
        $_SESSION['stats']['Fragen_Richtig']++;
        $stmt = $GLOBALS['db']->prepare('UPDATE statistik SET fragen=fragen+1,richtig=richtig+1');
	$stmt->execute();
    } else {
        $_SESSION['zufallstats']['Falsch']++;
        $_SESSION['stats']['Fragen_Falsch']++;
        $stmt = $GLOBALS['db']->prepare('UPDATE statistik SET fragen=fragen+1,falsch=falsch+1');
	$stmt->execute();
    }
    
    $tpl->addVars(Array(
            'submitText'    => ($_SESSION['frage_nr']==$_SESSION['fragen_cnt'])?'Gesamtstatistik':'N&auml;chste Frage',
            'aktuelleFrage' => $_SESSION['frage_nr'],
            'fragenRichtig' => $_SESSION['zufallstats']['Richtig'],
            'fragenFalsch'  => $_SESSION['zufallstats']['Falsch'],
            'fragenQuote'   => sprintf('%0.2f', $_SESSION['zufallstats']['Falsch']/$_SESSION['frage_nr']*100) . '%'                  
    )); 
    
    // Frage entfernen
    array_shift($_SESSION['zufallsfragen']);

    $_SESSION['frage_nr']++;
    $_SESSION['stats']['Fragen_Bisher']++;
        
    return;
}

// Neuen Fragenkatalog erstellen
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'start') {

    $topicCount = getSingleResult('SELECT COUNT(*) AS Cnt FROM abschnitte WHERE Jahr = ?',
        array('i', $_SESSION['jahr']));

    // Gewählte Abschnitte in Query einsetzen
    $selectedTopics = array();
    for ($topic = 1; $topic <= $topicCount; $topic++){
        if (isset($_REQUEST['abschnitt'][$topic]) && $_REQUEST['abschnitt'][$topic] == '1') {
            array_push($selectedTopics, $topic);
        }
    }

    if (count($selectedTopics) == 0)
    {
        // Kein Themenabschnitt gewählt
        $tpl->addTemplates(Array('content' => 'zufallsfragen-error'));

        return;
    }

    // Sessiondaten löschen
    unset($_SESSION['zufallsfragen']);
    unset($_SESSION['frage_nr']);
    unset($_SESSION['fragen_cnt']);
    unset($_SESSION['zufallstats']);
    unset($_SESSION['bogen']);

    // Sessions-Variablen initialisieren
    $_SESSION['zufallsfragen'] = array();
    $_SESSION['frage_nr'] = 1;
    $_SESSION['zufallstats'] = array('Richtig' => '0', 'Falsch' => '0');

    $tpl->addTemplates(Array('content' => 'zufallsfragen-frage'));

    // Fragen holen
    $inClauseParams = implode(',', array_fill(0, count($selectedTopics), '?'));
    $inClauseTypes = str_repeat('i', count($selectedTopics));
    $params = array_merge(array('i'.$inClauseTypes, $_SESSION['jahr']), $selectedTopics);

    $stmt = $GLOBALS['db']->prepare('SELECT ID FROM fragen WHERE Jahr = ? AND Abschnitt IN (' . $inClauseParams . ')');
    callBindParamArray($stmt, $params);
    $stmt->execute();
    $stmt->bind_result($id);

    // Fragen in Array übertragen
    while ($stmt->fetch()) {
        array_push($_SESSION['zufallsfragen'], $id);
    }
    $stmt->close();

    // Fragen zufällig mischen
    shuffle($_SESSION['zufallsfragen']);

    // Nur gewählte Anzahl Fragen zulassen
    if ($_REQUEST['fragen'] > 0 && $_REQUEST['fragen'] < count($_SESSION['zufallsfragen'])) {
        $_SESSION['zufallsfragen'] = array_slice($_SESSION['zufallsfragen'], 0, $_REQUEST['fragen']);
    }

    // Anzahl in Session speichern
    $_SESSION['fragen_cnt'] = count($_SESSION['zufallsfragen']);

    // Erste Frage stellen
    SingleQuestion($_SESSION['zufallsfragen'][0], $_SESSION['frage_nr'], $_SESSION['fragen_cnt']);

    return;

}

// Startseite mit Abschnittsauswahl
$tpl->addVars('navZufallNeu', 'current');
$abschnitte = getTopics();
$topicCount = getSingleResult('SELECT COUNT(*) AS Cnt FROM abschnitte WHERE Jahr = ?',
    array('i', $_SESSION['jahr']));
$maxFragen = getSingleResult('SELECT COUNT(*) AS Cnt FROM fragen WHERE Jahr = ?',
    array('i', $_SESSION['jahr']));

$tpl->addVars(Array(
        'abschnitteAnz' => $topicCount,
        'maxFragen'     => $maxFragen
));

$tpl->addTemplates('content', 'zufallsfragen-start');

foreach ($abschnitte as $nr => $description) {
    $tpl->addVars(Array(
            'abschnittNr'   => $nr,
            'abschnittDesc' => htmlspecialchars($description)
    ));
    
    $tpl->parseBlock('content', 'Abschnitte', 'Row', TRUE);
}
