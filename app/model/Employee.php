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
    private $date_enter;

    public function __construct($name,$firstname,$email,$fonction,$years,$city,ContainerInterface $container)
    {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->fonction = $fonction;
        $this->years = $years;
        $this->city = $city;
        $this->container = $container;
    }

    public function postEmployee(){

        try{

            $this->name = strip_tags($this->name);
            $this->firstname = strip_tags($this->firstname);
            $this->email = strip_tags($this->email);
            $this->fonction = strip_tags($this->fonction);
            $this->years = strip_tags($this->years);
            $this->city = strip_tags($this->city);
       

            $date = new \DateTime('2000-01-01');
            $this->date_enter = $date->format('Y-m-d H:i:s');

            $stmt = $this->container->db->prepare("INSERT INTO employes (name,firstname,email,fonction,years,city,date_entrer) VALUES (:name,:firstname,:email,:fonction,:years,:city,:date_entrer )");
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':fonction', $this->fonction);
            $stmt->bindParam(':years', $this->years);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':date_entrer', $this->date_enter);
            $stmt->execute();

        }catch(\Exception  $e){

            var_dump($e->getMessage());
            die();

        }
     


    }


}