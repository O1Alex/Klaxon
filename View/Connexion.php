<?php

session_start(); //demarrage de la session
require "../Controller/UserController.php";

$userController = new UserController();

$error='';
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    if($userController->Connexion($_POST["email"], $_POST["password"])){
        header('Location:header.php');
        exit;
    } 
    else{
        $error="Email ou mot de passe incorrect";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <?php
        if ($error){?>
        <p style="color:red"><?php $error ?> </p>
        <?php }; ?>

    <form method="POST">
        <div>
            <label>Email</label>
            <input type="email" name="email"></input>
        </div>
        <div>
            <label>Mot de passe</label>
            <input type="password" name="password"></input>
        </div>

        <br>

        <button type="submit">Se connecter</button>

    </form>
    
</body>
</html>
