<?php 
session_start();

function tarkistaSyote($nimi, $sahkoposti){
    $nimi = htmlspecialchars(trim($nimi));
    $sahkoposti = htmlspecialchars((trim($sahkoposti)));

    if(strlen($nimi) > 100) return "nimi pitkä :(";
    if(!preg_match("/^[a-zA-ZäöåÄÖÅ\s-]+$/u",$nimi)) return"Virheellinen nimi";
}

$tulos = tarkistaSyote($_POST['nimi'], $_POST['sahkoposti']);

?>