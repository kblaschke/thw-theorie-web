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

    require_once 'db.php';
    require_once 'class.template.inc.php';
    require_once 'functions.inc.php';
    require_once 'init.inc.php';

    if (!isset($_REQUEST['show'])) {
        $_REQUEST['show'] = 'home';
    }

    switch ($_REQUEST['show']) {
        case 'fragen':
            addBreadcrumb($_REQUEST['show'], 'Zufallsfragen beantworten');
            include ('zufallsfragen.inc.php');
            break;
            
        case 'bogen':
            addBreadcrumb($_REQUEST['show'], 'Prüfungsbogen üben');
            include ('pruefbogen.inc.php');
            break;
            
        case 'loesung':
            addBreadcrumb($_REQUEST['show'], 'Antworten anzeigen');
            include ('antworten.inc.php');
            break;
            
        case 'ordnung':
            addBreadcrumb($_REQUEST['show'], 'Prüfungsordnung');
            $tpl->addVars('navOrdnung', 'current');
            $tpl->addTemplates(Array('content' => 'ordnung'));
            break;
        
        case 'stats':
            $tpl->addVars(Array(
                // Statistik Zufallsfragen
                'fragenBisher'  =>   $_SESSION['stats']['Fragen_Bisher'],
                'fragenRichtig' =>   $_SESSION['stats']['Fragen_Richtig'],
                'fragenFalsch'  =>   $_SESSION['stats']['Fragen_Falsch'],
                'fragenQuote'   => (($_SESSION['stats']['Fragen_Bisher']>0)?(preg_replace('/\./is', ',', number_format($_SESSION['stats']['Fragen_Richtig']/$_SESSION['stats']['Fragen_Bisher']*100,2))):('0')) . '%',
                
                // Statistik Prüfungsbögen
                'boegenBisher'  =>   $_SESSION['stats']['Boegen_Bisher'],
                'boegenRichtig' =>   $_SESSION['stats']['Boegen_Bestanden'],
                'boegenFalsch'  =>   $_SESSION['stats']['Boegen_Durchgefallen'],
                'boegenQuote'   => (($_SESSION['stats']['Boegen_Bisher']>0)?(preg_replace('/\./is', ',', number_format($_SESSION['stats']['Boegen_Bestanden']/$_SESSION['stats']['Boegen_Bisher']*100,2))):('0')) . '%'
            ));
            addBreadcrumb($_REQUEST['show'], 'Statistiken');
            $tpl->addVars('navStats', 'current');
            $tpl->addTemplates(Array('content' => 'stats'));
            break;

        case "barrierefreiheit":
            addBreadcrumb($_REQUEST["show"], "Barrierefreiheit");
            include "barrierefreiheit.inc.php";
            break;

        case 'impressum':
            addBreadcrumb($_REQUEST['show'], 'Impressum');
            $tpl->addTemplates(Array('content' => 'impressum'));
            break;
        
        case 'datenschutz':
            addBreadcrumb($_REQUEST['show'], 'Datenschutzhinweis');
            $tpl->addTemplates(Array('content' => 'datenschutz'));
            break;

        case "downloads":
            addBreadcrumb($_REQUEST["show"], "Offline-Version");
            $tpl->addVars("navOffline", "current");
            $tpl->addTemplates(Array("content" => "offline"));
            break;

        default:
            $title = '';
            include('home.inc.php');
    }    

    $tpl->parse('pageContent', 'content');
    $tpl->printParse('pageMain', 'page-body');

?>