<?php

namespace API;
use Middleware\Form\Middleware;
use Psr\Container\ContainerInterface;
use \Firebase\JWT\JWT;

// autolaod
require '../../vendor/autoload.php';
//token class
require '../../app/model/Token.php';


use Model\Token;


class ManagerApi extends Token {

    private $dsn = 'mysql:dbname=slim;host=localhost';
    private $user = 'root';
    private $password = '';
    private $pdo;

    public function __construct()
    {
        $this->PDO();
        
    }

    private function PDO(){

        if($this->pdo === null){
            $dbh = new \PDO($this->dsn,$this->user,$this->password);
            $this->pdo = $dbh;
        }

        return $this->pdo;        

    }

    public function get(){

        $datas = $this->pdo->prepare('SELECT * FROM users');
        $datas->execute();
        $result = $datas->fetchAll();
 
        return $result;

    }

    public function getEmployes(){

        $datas = $this->pdo->prepare('SELECT * FROM employes');
        $datas->execute();
        $result = $datas->fetchAll();
 
        return $result;

    }

    public function DecryptToken($token){

        return $this->Decrypt($token);

    }

    public function search($string){
        
        $string = strip_tags($string);

        $datas = $this->pdo->prepare("SELECT * FROM employes WHERE name LIKE :string ");
        $datas->execute([":string" => '%'.$string.'%']);
        $datas->execute();
        
        if($datas){
            $results = $datas->fetchAll();
            return $results;
        }else{
            return false;
        }


    }

    



}