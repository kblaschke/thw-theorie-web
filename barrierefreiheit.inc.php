<?php


if (isset($_POST['normal'])) {
    setcookie("stylesheet", "normal", time()+60*60*24*365);
    $tpl->addVars('extraStyleSheet', '');
}

if (isset($_POST['barrierefrei'])) {
    setcookie("stylesheet", "barrierefrei", time()+60*60*24*365);
}

$tpl->addTemplates(Array("content" => "barrierefreiheit"));

?>