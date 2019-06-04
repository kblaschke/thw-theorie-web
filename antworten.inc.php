<?php

/*
 *  Copyright (C) 2001 Kai Blaschke <webmaster@thw-theorie.de>
 *
 *  The included 'THW Thema' templates, logos and the Q&A catalog are protected
 *  by copyright laws, and must not be used without the written permission
 *  of the
 *
 *  Bundesanstalt Technisches Hilfswerk
 *  Provinzialstra�e 93
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

  Aufl�sungen zu allen Fragen

*/


$tpl->addVars('navAntworten', 'current');

$katalog = -1;
if (isset($_REQUEST['katalog'])) {
    $katalog = intval($_REQUEST['katalog']);
}

$abschnitte = getTopics();
foreach ($abschnitte as $nr => $description) {
    $tpl->addVars(Array(
            'abschnittNr' => $nr,
            'abschnittName' => htmlspecialchars($description),
            'navAntwortenAbschnitt' => ($katalog == $nr) ? 'current':''
    ));
    
    $tpl->parseBlock('page-body', 'NavAntworten', 'Sublinks', TRUE);
}

if (isset($_SESSION['zufallsfragen']) || isset($_SESSION['bogen'])) {
	if (isset($_GET['clear']) && intval($_GET['clear']) == '1') {
        unset($_SESSION['bogen']);
        unset($_SESSION['zufallsfragen']);
        unset($_SESSION['frage_nr']);
        unset($_SESSION['fragen_cnt']);
        unset($_SESSION['zufallstats']);
        unset($_SESSION['bogen']);
	}
	else {
		$tpl->addTemplates(Array('content' => 'aufloesung-error'));
		return;
    }
}

if ($katalog > 0) {
    $selectedNr = NULL;
    $selectedDescription = NULL;

    $stmt = $GLOBALS['db']->prepare('SELECT `Nr`,`Beschreibung` FROM `abschnitte` WHERE `Nr` = ? AND `Jahr` = ?');
    $stmt->bind_param('ii', $katalog, $_SESSION['jahr']);
    $stmt->execute();
    $stmt->bind_result($selectedNr, $selectedDescription);
    $stmt->fetch();

    addBreadcrumb($_REQUEST['show'].'&katalog=' . $selectedNr, $selectedDescription);

    $tpl->addTemplates(Array(
            'content' => 'aufloesung-antworten'
    ));

    $tpl->addVars(Array(
            'abschnittNr' => $selectedNr,
            'abschnittName' => htmlspecialchars($selectedDescription)
    ));

    $stmt->close();

    $stmt = $GLOBALS['db']->prepare('SELECT * FROM `fragen` WHERE `Abschnitt` = ? AND `Jahr` = ? ORDER BY Abschnitt,Nr ASC');
    $stmt->bind_param('ii', $katalog, $_SESSION['jahr']);
    $stmt->execute();
    $questions = $stmt->get_result();

    $I = 1;

    while ($question = $questions->fetch_array(MYSQLI_ASSOC)) {
   	    ShowAnswer($question);
        $tpl->parseBlock('content', 'Antworten', 'Row', TRUE, TRUE);
       	if ($I%10==0) {
            $tpl->parseBlock('content', 'Antworten', 'Topline', TRUE);
        }
   	    $I++;
    }
    $questions->close();
    $stmt->close();
}
else {

    $tpl->addTemplates('content', 'aufloesung-abschnitte');

    $stmt = $GLOBALS['db']->prepare('SELECT `Nr`,`Beschreibung` FROM `abschnitte` WHERE `Jahr` = ? ORDER BY Nr ASC');
    $stmt->bind_param('i', $_SESSION['jahr']);
    $stmt->execute();
    $stmt->bind_result($nr, $description);

    while ($stmt->fetch()) {
        $tpl->addVars(Array(
                'abschnittNr' => $nr,
                'abschnittName' => $description
        ));
        
        $tpl->parseBlock('content', 'Abschnitte', 'Row', TRUE);
    }

}
?>
