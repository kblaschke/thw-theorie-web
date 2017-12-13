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

function getStats() {
    $stmt = $GLOBALS['db']->prepare('SELECT fragen,richtig,falsch,boegen,bestanden,durchgefallen FROM statistik');
    $stmt->execute();
    $stmt->bind_result(
        $fragen,
        $richtig,
        $falsch,
        $boegen,
        $bestanden,
        $durchgefallen
    );

    $stmt->fetch();

    $GLOBALS['tpl']->addVars(Array(
        'statsFragen'        => sprintf('%0.d', $fragen),
        'statsFragenRichtig' => sprintf('%0.d (%0.2f %%)', $richtig, ($fragen > 0 ? $richtig / $fragen * 100 : 0)),
        'statsFragenFalsch'  => sprintf('%0.d (%0.2f %%)', $falsch,  ($fragen > 0 ? $falsch  / $fragen * 100 : 0)),
        'statsBoegen'        => sprintf('%0.d', $boegen),
        'statsBoegenRichtig' => sprintf('%0.d (%0.2f %%)', $bestanden,     ($boegen > 0 ? $bestanden     / $boegen * 100 : 0)),
        'statsBoegenFalsch'  => sprintf('%0.d (%0.2f %%)', $durchgefallen, ($boegen > 0 ? $durchgefallen / $boegen * 100 : 0))
    ));


}

getStats();
$GLOBALS['tpl']->addTemplates(Array(
    'content' => 'home'
));
?>