<?php
require '../config/database.php';
require '../Model/Agence.php';

class AgenceController {

    //Liste des agences
    public function getAllAgences(){
        $sql="SELECT * FROM agence";//requete bdd
        $db=Config::Connexion();//connexion bdd

        try {
            $query=$db->prepare($sql);
            $query->execute();
            $agence=$query->fetchAll();
            return $agence;

        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }

    //Créer une agence
    public function createAgence($agence){ //cette m"thode signifie que l'on va ajouter une ligne dans la base de donnée et donc une instance, d'ou le faite qu'il y ai $agence dans kles parenthèses).
        $sql="INSERT INTO agence(id, city_name) VALUES (null, :city_name)"; //: pour dire que la valeur peux changer
        $db=Config::Connexion();

        try {
            $query=$db->prepare($sql);
            $query->bindValue('city_name', $agence->getCityName); //liaison entre attribut et porpriété dans le SQL
            $query->execute([$cityName]);
        
        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }

    //Modifier une agence
    public function updateAgence($agence, $id){
        $sql="UPDATE agence SET city_name=:city_name WHERE id=:id";
        $db=Config::Connexion();
        
        try {
            $query=$db->prepare($sql);
            $query-> execute([
                'id'=> $id,
                'city_name'=> $agence->getCityName
            ]);

        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }

    //Supprimer une agence
    public function deleteAgence($id){
         $sql="DELETE agence WHERE id=:id";
         $db=Config::Connexion();
        
         try {
            $query=$db->prepare($sql);
            $query-> execute([
                'id'=> $id,
            ]);

        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }

    }

}




$agenceController= new AgenceController();
$agence= new Agence();

//Affcher les agences
$liste=$agenceController->getAllAgences();
print_r($liste);

$agence= new Agence();

//Créer une agence
$agence->setCityName('nomdelavilleàcréer');
$agenceController->createAgence($agence);

//Modifier une agence
$agence->setCityName('nouveau nom de ville');
$agenceController->updateAgence($agence, numeroid);

//Supprimmer une agence
$agenceController->deleteAgence(numeroid);

?>


