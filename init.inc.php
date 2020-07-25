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

header('Content-Type: text/html; charset=utf-8');

$GLOBALS['tpl'] = new Template('./templates/');
$tpl =& $GLOBALS['tpl'];

$tpl->addTemplates(Array(
        'page-body' => 'page-body',
        'top-line' => 'top-line'
));

session_start();

if (isset($_REQUEST['resetstats']) && intval($_REQUEST['resetstats']) == '1') {
    unset($_SESSION['stats']);
}

if (!isset($_SESSION['stats'])) {
    
    $_SESSION['stats'] = array('Fragen_Bisher'        => '0',
                               'Fragen_Richtig'       => '0',
                               'Fragen_Falsch'        => '0',
                               'Boegen_Bisher'        => '0',
                               'Boegen_Bestanden'     => '0',
                               'Boegen_Durchgefallen' => '0' );
}

if (isset($_REQUEST['jahr'])) {
    $_SESSION['jahr'] = intval($_REQUEST['jahr']);
} elseif (!isset($_SESSION['jahr'])) {
    $_SESSION['jahr'] = 2020;
}

srand(microtime()*(double)10000);

if ((isset($_COOKIE['stylesheet']) && $_COOKIE['stylesheet'] == 'barrierefrei')
    || isset($_POST['barrierefrei'])
    || (isset($_GET['style']) && $_GET['style'] == 'rg')) {
    $tpl->addVars('extraStyleSheet', '<link href="rg-styles.css" rel="stylesheet" type="text/css" />');
} else {

}

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $protocol = 'https';
    // HSTS Policy aktivieren
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains;');
} else {
    $protocol = 'http';
}

$tpl->addVars(Array(
    // Globale Variablen
    'scriptName'    => $_SERVER['SCRIPT_NAME'],
    'catalogYear'   => $_SESSION['jahr'],
    'baseUrl'    => $protocol . '://thw-theorie.de/'
));


$tpl->parse('topLine', 'top-line');

?>