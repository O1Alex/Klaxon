<?php
session_start();

require "../Controller/TrajetController.php";

$trajetController= new TrajetController();
$trajetController->getDisponibleTrajet();

//Modal


?>