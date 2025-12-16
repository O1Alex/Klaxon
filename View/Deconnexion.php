<?php

require_once "../Controller/UserController.php";


$userController=new UserController();
$userController->Deconnexion();
header('Location:Connexion.php');
exit;

?>