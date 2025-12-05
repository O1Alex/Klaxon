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
         $sql="DELETE trajet WHERE id=:id";
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
        JOIN agence a1. ON t.start_agency_id=a1.id
        JOIN agence a2. ON t.end_agency_id=a2.id
        WHERE t.available_seat>0
        WHERE t.departure_date>Now()
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
                'start_agency-id'=>$trajet->getStartAgencyId(),
                'end_agency_id'=>$trajet->getEndAgencyId(),
                'departure_date'=>$trajet->getDepartureDate(),
                'arrival_date'=>$trajet->getArrivalDate(),
                'total_seat'=>$trajet->getTotalSeat(),
                'available_seat'=>$trajet->getAvailableSeat(),
                'person_contact_id'=>$trajet->getPersonContactId()
            ]);
        
        } catch (PDOException $e) {
            echo "Erreur".$e->getMessage();
        }

    
        //Valider le trajet
        public function validateTrajet($trajet){
            $errors=[];
            if ($trajet->getStartAgencyId()==$trajet->getEngAgencyId()){
                $errors[]="L'agence de départ ne eut pas être le même que l'agence d'arrivée"};

            if (strtotime($trajet->getDepartureDate())>=strtotime($trajet->getArrivalDate())){
                $errors[]="Il est impossible d'arriver avant d'être parti"};

            if ($trajet->getAvailableSeat()>$trajet->getTotalSeat()){
                $errors[]="Il est impossible d'avoir plus de place libre que de place totale"};
            
            if ($trajet->getTotalSeat()<0){
                $errors[]="Le nombre de places ne peut pas être négatif"};
        
        return $errors;
        }

    }

        
    //Modification trajet
    public function updateTrajet($trajet, $id){
        $sql = "UPDATE trajets SET 
                    start_agency_id = :start_agency_id,
                    end_agency_id = :end_agency_id,
                    departure_date = :departure_date,
                    arrival_date = :arrival_date,
                    total_seat = :total_seat,
                    available_seat = :available_seat,
                    person_contact_id = :person_contact_id
                WHERE id = :id";

        $db = Config::Connexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                'start_agency_id' => $trajet->getStartAgencyId(),
                'end_agency_id' => $trajet->getEndAgencyId(),
                'departure_date' => $trajet->getDepartureDate(),
                'arrival_date' => $trajet->getArrivalDate(),
                'total_seat' => $trajet->getTotalSeat(),
                'available_seat' => $trajet->getAvailableSeat(),
                'person_contact_id' => $trajet->getPersonContactId()
            ]);
            
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }



//Instance
$trajetController = new TrajetController();
$trajet= new Trajet();

//Afficher les trajets
$liste=$trajetController->getAllTrajet();
print_r($liste);

//Supprimer trajet
$trajetController->deleteAgence(iddelagencesouhaité);

//Trajets disponible par ordre croissant 
$liste=$trajetController->getDisponibleTrajet();
print_r($liste);

//Détails du trajet
$details=$trajetController->getDetailsTrajet(id);
print_r($details);

//Création d'un trajet
$trajet->setStartAgencyId();
$trajet->setEndAgencyId();
$trajet->setDepartureDate();
$trajet->setArrivalDate();
$trajet->setTotalSeat();
$trajet->setAvailableSeat();
$trajet->setPersonContactId();
$trajetController->createTrajet($trajet);
}

//Modification d'un trajet
$trajet->setStartAgencyId();
$trajet->setEndAgencyId();
$trajet->setDepartureDate();
$trajet->setArrivalDate();
$trajet->setTotalSeat();
$trajet->setAvailableSeat();
$trajet->setPersonContactId();
$trajetController->updateTrajet($trajet, numeroidsouhaité);

?>