<?php

require "../Controller/UserController";

$userController=new UserController();
$userController->Deconnexion();
header('Location:Connexion.php');
exit;

?>