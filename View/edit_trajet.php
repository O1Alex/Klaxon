<?php

require "../Controller/TrajetController.php";
require "../Controller/AgenceController.php";
require_once "../Model/Trajet.php";

session_start();

//vérifier si l'utilisateur est connecté 
if(!isset($_SESSION['user_id'])){
    header('Location:Connexion.php');
    exit();
}

$trajetController=new TrajetController();

$trajetId=$_GET['id'];
$trajetDetails=$trajetController->getDetailsTrajet($trajetId);

//verifier si le trajet existe
if(!$trajetDetails){
    header('Location:index.php');
    exit();
}

//verifier que l'utilisateur est bien l'auteur du trajet 
if(!$trajetController->isAuthor($_SESSION['user_id'],$trajetId) && $_SESSION['user_role']!='admin'){
    header('Location:index.php');
    exit();
}


$agenceController=new AgenceController();
$agences=$agenceController->getAllAgences();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $trajet=new Trajet();
    $trajet->setStartAgencyId($_POST['start_agency_id']);
    $trajet->setEndAgencyId($_POST['end_agency_id']);
    $trajet->setDepartureDate($_POST['departure_date']);
    $trajet->setArrivalDate($_POST['arrival_date']);
    $trajet->setTotalSeats($_POST['total_seat']);
    $trajet->setAvailableSeats($_POST['available_seat']);
    $trajet->setPersonContactId($_SESSION['user_id']);
    
    
   $result= $trajetController->updateUserTrajet($trajet,$_SESSION['user_id'],$trajetId);

    if($result['success']){
        header('Location:index.php?updated=1');
        exit();

    }
    else{
     $errors=$result['errors']   ;
    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du trajet</title>
</head>
<body>
    <?php include 'header.php'?>
    
    <br>
    <br>
    <h2>Modifier Trajet</h2>
    <?php if(isset($errors)){?>
    <?php foreach ($errors as $error){?>
        <?php echo $error ?>
        <?php }} ?>

    <form method="POST">
        <label>Agence de départ</label>
        <select name="start_agency_id" required>
            <?php foreach($agences as $agence){?>
                <option value="<?php echo $agence['id']?>"
                <?php echo ($agence['id'] == $trajetDetails['start_agency_id']) ? 'selected' : '';?>>
                <?php echo $agence['city_name']?>
                </option>
            <?php }?>
        </select>
        
        <br>
        <label>Agence d'arrivé</label>
        <select name="end_agency_id" required>
            <?php foreach($agences as $agence){?>
                <option value="<?php echo $agence['id']?>"
                <?php echo ($agence['id'] == $trajetDetails['end_agency_id']) ?'selected' : '';?>>
                <?php echo $agence['city_name']?>
                </option>
            <?php }?>         
        </select>
        
        <br>
        <label> Date et heure de départ </label>
        <input type="datetime-local" name="departure_date" value="<?php echo date('Y-m-d\TH:i',strtotime($trajetDetails['departure_date']))?>" required>

        <br>
        <label> Date et heure d'arrivé </label>
        <input type="datetime-local" name="arrival_date" value="<?php echo date('Y-m-d\TH:i',strtotime($trajetDetails['arrival_date']))?>" required>

        <br>
        <label>Nombre total de places</label>
        <input type="number" name="total_seat" min="1" value="<?php echo $trajetDetails['total_seat']?>" required>

        <br>
        <label>Nombre de places disponibles</label>
        <input type="number" name="available_seat" min="0" value="<?php echo $trajetDetails['available_seat']?>" required>

        <br>
        <button type="submit"> Enregistrer les modifications</button>
        <a href="index.php"><button type="reset">Annuler </button></a>
    </from>
</body>
</html>