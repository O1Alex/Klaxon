<?php
require_once '../config/database.php';
require '../Model/Agence.php';

class AgenceController{

    //Liste de toutes les agences
    public function getAllAgences(){
        $sql="SELECT * FROM agences";
        $db=Config::Connexion();
        try{
            $query=$db->prepare($sql);
            $query->execute();
            $agences=$query->fetchAll();
        return $agences;

        }catch(PDOException $e){
            echo "Erreur".$e->getMessage();
        }

    }

    //Créer une agence
    public function createAgence($agence){
        $sql="INSERT INTO agences(id,city_name) VALUES (null,:city_name)";
        $db=Config::Connexion();
        try{
            $query=$db->prepare($sql);
            $query->bindValue('city_name',$agence->getCityName());
            $query->execute();
        }
        catch(PDOException $e){
            echo "Erreur".$e->getMessage();
        }

    }

    //Modifier une agence
    public function updateAgence($agence,$id){
        $sql="UPDATE agences SET city_name=:city_name WHERE id=:id";
        $db=Config::Connexion();
        try{
            $query=$db->prepare($sql);
            $query->execute([
                'id'=>$id,
                'city_name'=>$agence->getCityName()
        ]);
        return $query->rowCount();//optionnelle

        }catch(PDOException $e){
            echo "Erreur".$e->getMessage();
        }


    }

    //Supprimer une agence
    public function deleteAgence($id){
        $sql="DELETE FROM agences WHERE id=:id";
        $db=Config::Connexion();
        try{
            $query=$db->prepare($sql);
            $query->execute([
                'id'=>$id,
            ]);

        }catch(PDOException $e){
            echo "Erreur".$e->getMessage();
        }
    }

}




// $agenceController= new AgenceController();
// $agence= new Agence();

// //Affcher les agences
// $liste=$agenceController->getAllAgences();
// print_r($liste);

// $agence= new Agence();

// //Créer une agence
// $agence->setCityName('nomdelavilleàcréer');
// $agenceController->createAgence($agence);

// //Modifier une agence
// $agence->setCityName('nouveau nom de ville');
// $agenceController->updateAgence($agence, numeroid);

// //Supprimmer une agence
// $agenceController->deleteAgence(numeroid);

?>


