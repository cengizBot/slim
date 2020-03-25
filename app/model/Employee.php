<?php

namespace Model;
use Psr\Container\ContainerInterface;

class Employee {

    private $container;
    private $name;
    private $firstname;
    private $email;
    private $fonction;
    private $years;
    private $city;
    private $enter_date;

    CONST int_r = "/^[0-9]*$/";

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(){

        $datas = $this->container->db->prepare('SELECT * FROM employes');
        $datas->execute();
        $result = $datas->fetchAll();
 
        return $result;

    }

    public function getById($id){

        $id = htmlentities(strip_tags($id));

        // not int return false
        if(!preg_match(self::int_r,$id)){
            return false;
        }

        $datas = $this->container->db->prepare('SELECT * FROM employes,fiche WHERE fiche.id_employee = employes.id AND employes.id = :id  ');
        $datas->bindParam(':id', $id);
        $datas->execute();
        $result = $datas->fetchAll();

        if($result){
           
            return $result;
        }
        // else return false
        return false;
 
    }

    public function getbyEmail($email){

        
        $datas = $this->container->db->prepare('SELECT * FROM employes WHERE email = :email');
        $datas->bindParam(':email', $email);
        $datas->execute();
        $result = $datas->fetchAll();
        
        if($result){
           
            return $result;
        }
        // else return false
        return false;
 
    }

    public function checkEmail($email){

        $users = $this->get();

        foreach ($users as $user ) {
            
            if($user['email'] === $email){
                // email exist return false for inscription

                return false;
            }

        }
        return true;
    
    }

    public function postEmployee($name,$firstname,$email,$fonction,$years,$city,$enter_date){

        try{

            $this->name = strip_tags($name);
            $this->firstname = strip_tags($firstname);
            $this->email = strip_tags($email);
            $this->fonction = strip_tags($fonction);
            $this->years = strip_tags($years);
            $this->city = strip_tags($city);
            $this->enter_date = strip_tags($enter_date);

            $check_email = $this->checkEmail($this->email);

            if(!$check_email){
                // email exist
                return false;
            }
    
            // $date = new \DateTime('2000-01-01');
            // $this->date_enter = $date->format('Y-m-d H:i:s');

            $stmt = $this->container->db->prepare("INSERT INTO employes (name,firstname,email,fonction,years,city,date_entrer) VALUES (:name,:firstname,:email,:fonction,:years,:city,:date_entrer )");
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':fonction', $this->fonction);
            $stmt->bindParam(':years', $this->years);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':date_entrer', $this->enter_date);
            $stmt->execute();

            // add automat... table fiche random data in
            $get = $this->getbyEmail($this->email);
            $id = $get[0]['id'];

            $heures_cumul = random_int(50,590);
            $absences = random_int(1,10);
            $salaire = random_int(1500,3785);

            $h_matin =  strval(random_int(5,8));
            $h_aprem =  strval(random_int(15,20));

            $heur_travail = $h_matin . " - " . $h_aprem;

            $query = $this->container->db->prepare("INSERT INTO fiche (id_employee,heures_cumul,absences,salaire,horaire) VALUES (:id_employee,:heures_cumul,:absences,:salaire,:horaire)");
            $query->bindParam(':id_employee', $id);
            $query->bindParam(':heures_cumul', $heures_cumul);
            $query->bindParam(':absences', $absences);
            $query->bindParam(':salaire', $salaire);
            $query->bindParam(':horaire', $heur_travail);
            $query->execute();


            return true;

        }catch(\Exception  $e){

            var_dump($e->getMessage());
            die();

        }

    }

    
}