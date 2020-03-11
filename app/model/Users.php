<?php


namespace Model;

use DateTime;
use Model\Token;
use Psr\Container\ContainerInterface;

class Users{

    private $container;
    private $date;
    private $email;
    private $role;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->date = new DateTime();
    }

    public function get(){

        $datas = $this->container->db->prepare('SELECT * FROM users');
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

    public function createUser($email,$password){

        $date = date('Y-m-d H:i:s');

        $options = [
            'cost' => 12,
        ];

        $check_email = $this->checkEmail($email);

        if(!$check_email){
            // email exist
            return false;
        }

        $has_password = password_hash($password,PASSWORD_BCRYPT, $options);

        $email = strip_tags($email);
        $password = strip_tags($password);
        $role = 'user';

        $stmt = $this->container->db->prepare("INSERT INTO users (email, password,role,date_create) VALUES (:email, :password,:role, :date_create)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $has_password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':date_create', $date);
        $stmt->execute();


        //else return true email not exist
        return true;

    }

    public function getEmail(){

        return $this->email;

    }

    public function getRole(){

        return $this->role;

    }

    public function Connexion($email,$password){


        
        $email = htmlspecialchars(strip_tags($email));
        $password = htmlspecialchars(strip_tags($password));

        $this->email = $email;
        $this->password = $password;



        $users = $this->get();

        foreach ($users as $user ) {
            
            if($user['email'] === $email && password_verify($password, $user['password'])){
                // email exist return false for inscription
                $this->email = $email;
                $this->role = $user['role'];
                return true;
             
            }

        }

        return false;


    }


}