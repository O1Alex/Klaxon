<?php
require '../Config/database.php'

class UserController{

    //Liste des utilisateurs avec certaines données
    public function getUser(){
        $sql="SELECT id, firt_name, last_name, email, phone, role FROM user";
        $db=Config::Connexion();

        try {
            $query=$db->prepare($sql);
            $query->execute();
            $user=$query->fetchAll();       
            return $user;

        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }

    //Connexion
    public function Connexion($email,$password){
        $sql="SELECT * FROM users WHERE email=:email AND password=:password";
        $db=Config::Connexion();

        try{
            $query=$db->prepare($sql);
            $query->execute([
                'email'=>$email,
                'password'=>$password
            ]);
            $user=$query->fetch();

            if($user){
                session_start();
                $_SESSION['user_id']=$user['id'];
                $_SESSION['user_name']=$user['first_name'].$user['last_name'];
                $_SESSION['user_password']=$user['password'];
                $_SESSION['user_role']=$user['role'];
                $_SESSION['user_email']=$user['email'];

                return true;
            }
            return false;

        }catch(PDOException $e){
                echo "Erreur".$e->getMessage();
        }
    }

    public function Deconnexion(){
        session_start();
        session_destroy();
        return true;
    }


// //Instance
// $userController= new UserController();

// //Appel de fonctions:

// //Afficher utilisateurs
// $liste=$userController->getUser();
// print_r($liste);

// //Connexion
// $result=$userController->Connexion('emailutilisateur','mpd');
//     if($result){
//         echo "Connecté";
//     }
//     else{
//         echo "Echec";
//     }

// //Deconnexion
// $deconnexion=$userController->Deconnexion();
//     if($deconnexion){
//         echo "déconnecter";
//     }
//     else {
//         echo "Echec";
//     }

// //Affichage nom de l'utilisateur
// if(isset($_SESSION['user_id'])){
//     echo $_SESSION['user_name'];
// }

}
?>