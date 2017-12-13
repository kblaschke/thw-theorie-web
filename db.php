<?php

/*
 *  Copyright (C) 2001 Kai Blaschke <webmaster@thw-theorie.de>
 *
 *  The included "THW Thema" templates, logos and the Q&A catalog are protected
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

$GLOBALS['db'] = new mysqli("localhost", "DBUSER", "DBPASSWD", "DBDATABASE");

if ($GLOBALS['db']->connect_error) {
    header("HTTP/1.0 500 Internal Server Error");
    readfile('templates/db-error.html');
  	die();
}

function callBindParamArray($stmt, $bindArguments = null) {
    if ($bindArguments === null) {
        return;
    }

    $args = array();
    foreach($bindArguments as $k => &$arg){
        $args[$k] = &$arg;
    }

    call_user_func_array(array($stmt, "bind_param"), $args);
}

function getSingleResult($query, $bindArguments = null) {
    $stmt = $GLOBALS['db']->prepare($query);
    callBindParamArray($stmt, $bindArguments);
    $stmt->execute();
    $stmt->bind_result($retVal);
    $stmt->fetch();
    $stmt->close();

    return $retVal;
}