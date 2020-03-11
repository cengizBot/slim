<?php


namespace Model;

use Exception;
use Model\Token;
use \Firebase\JWT\JWT;


class UserManager extends Token {


    public function setPayload($data){

        array_push($this->payload, $data);

    }

    public function getPayload(){

        return $this->payload;
    }

    public function getKey(){
        return $this->key;
    }

    public function getTokenEncode(){
        return $this->token_encode;
    }


    public function Encode(){
         // return playload update
         $payload = $this->getPayload();

         // key
         $key = $this->key;

         // encode the jwt
         $this->token_encode = JWT::encode($payload, $key);

    }

    public function Decrypt($token){
        
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