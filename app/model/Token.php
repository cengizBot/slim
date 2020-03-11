<?php


namespace Model;

use Exception;
use \Firebase\JWT\JWT;


class Token {

    protected $key = "supersecretkeyyoushouldnotcommittogithub";
    protected $payload = array(
        "iss" => "http://localhost:8080/",
        "aud" => "http://localhost:8080/",
        "iat" => 1356999524,
        "nbf" => 1357000000
    );

    protected $token_encode;

    
    protected  function setPayload($data){

        array_push($this->payload, $data);

    }

    protected  function getPayload(){

        return $this->payload;
    }

    protected  function getKey(){
        return $this->key;
    }

    protected  function getTokenEncode(){
        return $this->token_encode;
    }


    protected  function Encode(){
         // return playload update
         $payload = $this->getPayload();

         // key
         $key = $this->key;

         // encode the jwt
         $this->token_encode = JWT::encode($payload, $key);

    }

    protected function Decrypt($token){
        
        try{
            $decrypt = JWT::decode($token,$this->key,array('HS256'));
            $k = json_decode(json_encode($decrypt), true);

            //return k['0'] because contains data user
            return $k['0'];

        }catch(Exception $e){
  
            return false;
           
        }
     

    }

    



}