<?php
session_start();
require "../Controller/TrajetController.php";

$trajetController=new TrajetController();
$trajetId=$_POST['id_trajet'];
$result=$trajetController->deleteUserTrajet($trajetId,$_SESSION['user_id']);

if($result['success']){
    header('Location:index.php?deleted=1');
} else{
         header('Location:index.php?error=delete'); 
    }
exit();

?>