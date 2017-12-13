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

/**
 * Holt eine Einzelne Frage aus der DB
 *
 * @param $id Die Frage-ID
 *
 * @return array Die Frage
 */
function getQuestionById($id) {
    $stmt = $GLOBALS['db']->prepare('SELECT * FROM fragen WHERE ID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $question = $result->fetch_array(MYSQLI_ASSOC);

    return $question;
}

/**
 * Holt eine Liste aller Abschnitte im aktuellen Jahr
 *
 * @return array
 */
function getTopics() {
    $stmt = $GLOBALS['db']->prepare('SELECT `Nr`,`Beschreibung` FROM `abschnitte` WHERE `Jahr` = ? ORDER BY `Nr` ASC');
    $stmt->bind_param('i', $_SESSION['jahr']);
    $stmt->execute();
    $stmt->bind_result($nr, $description);

    $topics = array();
    while ($stmt->fetch()) {
        $topics[$nr] = $description;
    }
    $stmt->close();

    return $topics;
}

/******************************************************************************
 *
 * Kopfzeile mit Informationen über Fragennummer und Lernabschnitt
 *
/******************************************************************************/

function questionHeader($id, $nr, $questionCount)
{
    $section = getSingleResult('SELECT Abschnitt FROM fragen WHERE ID=? AND Jahr=?',
        array('ii', $id, $_SESSION['jahr']));

    $sectionName = getSingleResult('SELECT Beschreibung FROM abschnitte WHERE Nr=? AND Jahr=?',
        array('ii', $section, $_SESSION['jahr']));

    $GLOBALS['tpl']->addVars(Array(
            'aktuelleFrage' => $nr,
            'fragenCnt'     => $questionCount,
            'abschnittNr'   => $section,
            'abschnitt'     => $sectionName
    ));

    $GLOBALS['tpl']->parseBlock('content', 'Kopf', 'Content');
}

/******************************************************************************
 *
 * Eine einzelne Frage mit Kopfzeile ausgeben
 *
/******************************************************************************/

function SingleQuestion($id, $Nr, $questionCount)
{
    questionHeader($id, $Nr, $questionCount);
    showQuestion($id);
}

/******************************************************************************
 *
 *  Fragengenerator
 *  Erzeugt eine Tabelle mit Frage, Antworten und Formularinformationen
 *  zur übergebenen Fragen-ID
 *
/******************************************************************************/

function showQuestion($id)
{
    // Frage aus DB holen
    $stmt = $GLOBALS['db']->prepare('SELECT * FROM fragen WHERE ID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $question = $result->fetch_array(MYSQLI_ASSOC);

    $GLOBALS['tpl']->addVars(Array(
            'frageID'     => $id,
            'frageNr'     => $question['Nr'],
            'abschnittNr' => $question['Abschnitt'],
            'frageText'   => $question['Frage'],
            'Antwort1'    => $question['Antwort1'],
            'Antwort2'    => $question['Antwort2'],
            'Antwort3'    => $question['Antwort3']
    ));
    
    if ($question['Antwort3'] == '') {
        $GLOBALS['tpl']->addVars('rowCnt', '2');
        $GLOBALS['tpl']->delBlockHandle('content', 'ThreeRows');
    }
    else {
        $GLOBALS['tpl']->addVars('rowCnt', '3');
        $GLOBALS['tpl']->parseBlock('content', 'ThreeRows', 'Row', TRUE);
    }

    $result->close();
    $stmt->close();
}

/******************************************************************************
 *
 *  Auswertung
 *  Erzeugt eine Tabelle mit Frage, Antworten und Markiert richtige/falsche
 *  Antworten farblich (grün=richtig, rot=falsch)
 *
/******************************************************************************/

function Answer($id, $answer, $showStatus = TRUE)
{
    // Frage aus DB holen
    $question = getQuestionById($id);
    
    // Einzelne Antworten aus Flag in Array splitten
    $solution = array( 1 => ( $question['Loesung'] & 0x1),
                      2 => (($question['Loesung'] & 0x2) >> 1),
                      3 => (($question['Loesung'] & 0x4) >> 2));

    $correct = (($solution[1] == (isset($answer[$id][1]) ? $answer[$id][1] : 0))
             && ($solution[2] == (isset($answer[$id][2]) ? $answer[$id][2] : 0))
             && ($solution[3] == (isset($answer[$id][3]) ? $answer[$id][3] : 0)));
             
    // Aufräumen
    $GLOBALS['tpl']->delHandle('antwortStatus');
    $GLOBALS['tpl']->delHandle('antwort1Loesung');
    $GLOBALS['tpl']->delHandle('antwort2Loesung');
    $GLOBALS['tpl']->delHandle('antwort3Loesung');
    
    $GLOBALS['tpl']->delBlockHandle('content', 'A1L');
    $GLOBALS['tpl']->delBlockHandle('content', 'A2L');
    $GLOBALS['tpl']->delBlockHandle('content', 'A3L');
    
    if ($showStatus) {
        if ($correct)
            $GLOBALS['tpl']->parseBlock('content', 'Status', 'Richtig');
        else
            $GLOBALS['tpl']->parseBlock('content', 'Status', 'Falsch');
    } else {
        if ($correct)
            $GLOBALS['tpl']->parseBlock('content', 'BogenStatus', 'Richtig');
        else
            $GLOBALS['tpl']->parseBlock('content', 'BogenStatus', 'Falsch');    
    }

    $GLOBALS['tpl']->addVars(Array(
            'abschnittNr'    => $question['Abschnitt'],
            'frageNr'        => $question['Nr'],
            'frageText'      => $question['Frage'],
            'antwort1Status' => $solution[1] ? 'korrekt' : 'falsch',
            'antwort2Status' => $solution[2] ? 'korrekt' : 'falsch',
            'antwort3Status' => $solution[3] ? 'korrekt' : 'falsch',
            'Antwort1'       => $question['Antwort1'],
            'Antwort2'       => $question['Antwort2'],
            'Antwort3'       => $question['Antwort3']
    ));
    
    if ($question['Antwort3'] == '') {
        $GLOBALS['tpl']->addVars('rowCnt', '2');
        $GLOBALS['tpl']->delBlockHandle('content', 'ThreeRows');
    }
    else {
        $GLOBALS['tpl']->addVars('rowCnt', '3');
        $GLOBALS['tpl']->parseBlock('content', 'ThreeRows', 'Row');
    }
    
    if (isset($answer[$id][1]) && $answer[$id][1] === '1') $GLOBALS['tpl']->parseBlock('content', 'A1L', 'Haken');
    if (isset($answer[$id][2]) && $answer[$id][2] === '1') $GLOBALS['tpl']->parseBlock('content', 'A2L', 'Haken');
    if (isset($answer[$id][3]) && $answer[$id][3] === '1') $GLOBALS['tpl']->parseBlock('content', 'A3L', 'Haken');
    
    // Anhängen per default
    $GLOBALS['tpl']->parse('content', 'antwort', TRUE, TRUE);

    return $correct;

}

/******************************************************************************
 *
 *  Antwort
 *  Zeigt die Frage und die zugehörigen korrekten Antworten an
 *  Antworten sind farblich gekennzeichnet (grün=richtig, rot=falsch)
 *
/******************************************************************************/

function addBreadcrumb($params, $title)
{
    $GLOBALS['tpl']->addVars(Array(
            'page' => htmlspecialchars($params),
            'pageTitle' => htmlspecialchars($title)
    ));
    $GLOBALS['tpl']->parseBlock('page-body', 'Breadcrumb', 'Link', TRUE);
}

function ShowAnswer(&$frage)
{

    
    // Einzelne Antworten aus Flag in Array splitten
    $loesung = array( 1 => ( $frage['Loesung'] & 0x1), 
                      2 => (($frage['Loesung'] & 0x2) >> 1), 
                      3 => (($frage['Loesung'] & 0x4) >> 2));

    // Aufräumen
    $GLOBALS['tpl']->delHandle('antwortStatus');
    $GLOBALS['tpl']->delHandle('antwort1Loesung');
    $GLOBALS['tpl']->delHandle('antwort2Loesung');
    $GLOBALS['tpl']->delHandle('antwort3Loesung');
    
    $GLOBALS['tpl']->addVars(Array(
            'abschnittNr'    => $frage['Abschnitt'],
            'frageNr'        => $frage['Nr'],
            'frageText'      => $frage['Frage'],
            'antwort1Status' => $loesung[1]?'korrekt':'falsch',
            'antwort2Status' => $loesung[2]?'korrekt':'falsch',
            'antwort3Status' => $loesung[3]?'korrekt':'falsch',
            'Antwort1'       => $frage['Antwort1'],
            'Antwort2'       => $frage['Antwort2'],
            'Antwort3'       => $frage['Antwort3']
    ));

    $GLOBALS['tpl']->delBlockHandle('content', 'A1L');
    $GLOBALS['tpl']->delBlockHandle('content', 'A2L');
    $GLOBALS['tpl']->delBlockHandle('content', 'A3L');

    if ($loesung[1]) $GLOBALS['tpl']->parseBlock('content', 'A1L', 'Haken');
    if ($loesung[2]) $GLOBALS['tpl']->parseBlock('content', 'A2L', 'Haken');
    if ($loesung[3]) $GLOBALS['tpl']->parseBlock('content', 'A3L', 'Haken');
    
    if ($frage['Antwort3'] == '') {
        $GLOBALS['tpl']->addVars('rowCnt', '2');
        $GLOBALS['tpl']->delBlockHandle('content', 'ThreeRows');
    }
    else {
        $GLOBALS['tpl']->addVars('rowCnt', '3');
        $GLOBALS['tpl']->parseBlock('content', 'ThreeRows', 'Row');
    }
}

?>
