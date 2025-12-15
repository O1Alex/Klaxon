<?php
require '../config/database.php';
require '../Model/Trajet.php';

class TrajetController{

    //Liste des trajets
    public function getAllTrajet(){
        $sql="SELECT * FROM trajet";
        $db=Config::Connexion();

        try {
            $query=$db->prepare($sql);
            $query->execute();
            $agence=$query->fetchAll();
            return $agence;

        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }

    //Suppression trajet
    public function deleteTrajet($id){
         $sql="DELETE FROM trajet WHERE id=:id";
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

    //Trajets disponible par ordre croissant et si place disponible
    public function getDisponibleTrajet(){
        $sql="SELECT t.*,
        a1.city_name as start_city,
        a2.city_name as end_city
        FROM trajet t
        JOIN agence a1 ON t.start_agency_id=a1.id
        JOIN agence a2 ON t.end_agency_id=a2.id
        WHERE t.available_seat>0
        AND t.departure_date>NOW()
        ORDER BY t.departure_date ASC";
        $db=Config::Connexion();

        try {
            $query=$db->prepare($sql);
            $query->execute();
            $trajet=$query->fetchAll();
            return $trajet;

        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }
    
    //Récupérer détails du trajet
    public function getDetailsTrajet($id){
        $sql="SELECT t.*,
        a1.city_name as start_city,
        a2.city_name as end_city,
        u.first_name,
        u.last_name,
        u.email,
        u.phone
        FROM trajet t
        JOIN agence a1. ON t.start_agency_id=a1.id
        JOIN agence a2. ON t.end_agency_id=a2.id
        JOIN user u ON t.personn_contac_id=u.id,
        WHERE t.id=:id";

        $db=Config::Connexion();

        try {
            $query=$db->prepare($sql);
            $query->execute([
                'id'=>$id
            ]);
            $trajet=$query->fetch();            
            return $trajet;

        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }

    //Création d'un trajet
    public function createTrajet($trajet){     
        $errors=$this->validateTrajet($trajet);
        if(!empty($errors)){
            return ['succes'=>false, 'errors'=>$errors];
        }

        $sql="INSERT INTO trajet ( start_agency-id, end_agency_id, departure_date, 
        arrival_date, total_seat, available_seat, person_contact_id ) 
        VALUES (:start_agency-id, :end_agency_id, :departure_date, :arrival_date, 
        :total_seat, :available_seat,:person_contact_id)"; 
        $db=Config::Connexion();

        try {
            $query=$db->prepare($sql);
            $query->execute([
                'start_agency_id'=>$trajet->getStartAgencyId(),
                'end_agency_id'=>$trajet->getEndAgencyId(),
                'departure_date'=>$trajet->getDepartureDate(),
                'arrival_date'=>$trajet->getArrivalDate(),
                'total_seat'=>$trajet->getTotalSeat(),
                'available_seat'=>$trajet->getAvailableSeat(),
                'person_contact_id'=>$trajet->getPersonContactId()
            ]);
            return['success'=>true, 'errors'=>'Trajet créé avec succès'];
        
        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }
    }

    
        //Valider le trajet
        public function validateTrajet($trajet){
            $errors=[];
            if ($trajet->getStartAgencyId()==$trajet->getEngAgencyId()){
                $errors[]="L'agence de départ ne eut pas être le même que l'agence d'arrivée";
            }

            if (strtotime($trajet->getDepartureDate())>=strtotime($trajet->getArrivalDate())){
                $errors[]="Il est impossible d'arriver avant d'être parti";
            }

            if ($trajet->getAvailableSeat()>$trajet->getTotalSeat()){
                $errors[]="Il est impossible d'avoir plus de place libre que de place totale";
            }
            
            if ($trajet->getTotalSeat()<0){
                $errors[]="Le nombre de places ne peut pas être négatif";
            }
        
        return $errors;
        }

    //Modification d'un trajet
    public function updateTrajet($trajet,$id){
   
        //Validation
        $errors=$this->validateTrajet($trajet);
        if(!empty($errors)){
            return ['success'=>false,'errors'=>$errors];
        }

        $sql="UPDATE trajets SET    start_agency_id=:start_agency_id,
                                    end_agency_id=:end_agency_id,
                                    departure_date=:departure_date,
                                    arrival_date=:arrival_date,
                                    total_seats=:total_seats,
                                    available_seats=:available_seats,
                                    person_contact_id=:person_contact_id
            WHERE id=:id";
        $db=Config::Connexion();

        try{
            $query=$db->prepare($sql);
            $query->execute([
            'id'=>$id,
            'start_agency_id'=>$trajet->getStartAgencyId(),
            'end_agency_id'=>$trajet->getEndAgencyId(),
            'departure_date'=>$trajet->getDepartureDate(),
            'arrival_date'=>$trajet->getArrivalDate(),
            'total_seats'=>$trajet->getTotalSeats(),
            'available_seats'=>$trajet->getAvailableSeats(),
            'person_contact_id'=>$trajet->getPersonContactId() 
            ]);

            return ['success'=>true,'message'=>'Le trajet a été modifé avec succés'];

        } catch(PDOException $e){
        echo "Erreur".$e->getMessage();
        }
    }

    //Verification utilisateur = auteur du trajet
    public function isAuthor($idUser,$idTrajet){
        $sql="SELECT COUNT(*) FROM trajets 
        WHERE id=:idTrajet AND person_contact_id=:idUser";
        $db=Config::Connexion();
    
        try{
            $query=$db->prepare($sql);
            $query->execute([
                'idTrajet'=>$idTrajet,
                'idUser'=>$idUser

            ]);
        return $query->fetchColumn()>0;

        } catch(PDOException $e){
        echo "Erreur".$e->getMessage();
        }
    }

    //Modification du trajet de l'utilisateur
    public function updateUserTrajet($trajet,$idUser,$idTrajet){
        if(!$this->isAuthor($idUser,$idTrajet)){
            return ["success"=>false,'errors'=>["Vous n'etes pas l'auteur du trajet"]];
        }else{
        return $this->updateTrajet($trajet,$idTrajet);
        }
    }

    //Suppression du trajet de l'utilisateur
    public function deleteUserTrajet($trajetId,$UserId){
        if(!$this->isAuthor($trajetId,$UserId)){
            return ["success"=>false,'errors'=>["Vous n'etes pas l'auteur du trajet"]];
        }else{
        $this->deleteTrajet($trajetId);
        return['success'=>true, 'message'=>['Traet supprimé avec succès']];}
    }



// //Instance
// $trajetController = new TrajetController();
// $trajet= new Trajet();

// //Appel de fonction:

// //Afficher les trajets
// $liste=$trajetController->getAllTrajet();
// print_r($liste);

// //Supprimer trajet
// $trajetController->deleteTrajet(iddelagencesouhaité);

// //Trajets disponible par ordre croissant 
// $liste=$trajetController->getDisponibleTrajet();
// print_r($liste);

// //Détails du trajet
// $details=$trajetController->getDetailsTrajet(id);
// print_r($details);

// //Création d'un trajet
// $trajet->setStartAgencyId();
// $trajet->setEndAgencyId();
// $trajet->setDepartureDate();
// $trajet->setArrivalDate();
// $trajet->setTotalSeat();
// $trajet->setAvailableSeat();
// $trajet->setPersonContactId();
// $result=$trajetController->createTrajet($trajet);
// if($result['success']){
//     echo 'Trajet créé avec succèes'
// }
// else{
//     echo"Erreur";
//     foreach ($result['errors'] as $error){
//         echo $error;
//     }
// }

// //Modification d'un trajet
// $trajet->setStartAgencyId();
// $trajet->setEndAgencyId();
// $trajet->setDepartureDate();
// $trajet->setArrivalDate();
// $trajet->setTotalSeat();
// $trajet->setAvailableSeat();
// $trajet->setPersonContactId();
// $result=$trajetController->updateTrajet($trajet, numeroidsouhaité);
// if($result['success']){
//     echo 'Trajet modifié avec succèes'
// }
// else{
//     echo"Erreur";
//     foreach ($result['errors'] as $error){
//         echo $error;
//     }
// }

// //Verification utilisateur = auteur du trajet
// $author=$trajetController->isAuthor($idUser,$idTrajet);
// echo $author?"Oui":"Non";


// //Modification du trajet de l'utilisateur
// $result2=$trajetController->updateUserTrajet($trajet,idusersouhaité,idtrajetsouhaité);
//     if($result2['success']){
//         echo 'Trajet modifé';

//     }else{
//         echo "Erreur";
//         foreach($result2['errors'] as $error){
//             echo $error;
//         }
//     }


// }

// //Suppression du trajet de l'utilisateur
// $result3=$trajetController->deleteTrajet($trajetId,$UserId);
// if($result3['success']){
//     echo "Trajet supprimé"
// }
// else{
//     echo "Erreur"
//     foreach($result3 ['errors'] as $error){
//         echo $error;
//     }
}
?>