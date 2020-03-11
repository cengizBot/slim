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

    public function __construct($name,$firstname,$email,$fonction,$years,$city,$enter_date,ContainerInterface $container)
    {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->fonction = $fonction;
        $this->years = $years;
        $this->city = $city;
        $this->enter_date = $enter_date;
        $this->container = $container;
    }

    public function get(){

        $datas = $this->container->db->prepare('SELECT * FROM employes');
        $datas->execute();
        $result = $datas->fetchAll();
 
        return $result;

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

    public function postEmployee(){

        try{

            $this->name = strip_tags($this->name);
            $this->firstname = strip_tags($this->firstname);
            $this->email = strip_tags($this->email);
            $this->fonction = strip_tags($this->fonction);
            $this->years = strip_tags($this->years);
            $this->city = strip_tags($this->city);
            $this->enter_date = strip_tags($this->enter_date);

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

            return true;

        }catch(\Exception  $e){

            // return msg error
            // var_dump($e->getMessage());
            // die();

        }
     


    }


}