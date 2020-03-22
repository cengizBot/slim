<?php

namespace Middleware\Form;


use Psr\Container\ContainerInterface;
use Middleware\Form\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;
use Model\UserManager;
use Volnix\CSRF\CSRF;

class FormConnexionSubmitHome extends Middleware {

   
    public function __invoke($request, $response, $next)
    {

        if(CSRF::validate($_POST)){
            
        // csrf token valide next
            
        $_SESSION['form_error'] = [];

        $email = $request->getParam('email');
        $password = $request->getParam('password');

        // return bool if user (email,password) exist or not
        // true exist , false not exist or ( wrong )
        $user_conn = $this->user->Connexion($email,$password);

        if($user_conn){

            // create array for given to playload token class
            // include data of user
            $data_user = [
                    "email" => $this->user->getEmail(),
                    "role" => $this->user->getRole()                
            ];


            // set playload for token 
            $this->user_manager->setPayload($data_user);

            //encode the token
            $this->user_manager->Encode();

            $jwt = $this->user_manager->getTokenEncode();
            
            // set cookie
            setcookie("token", $jwt,time()+3600);
            // get in header the token for access page restric
            $request->withAddedHeader('token',$_COOKIE["jwt"]);

            return $next($request, $response);

        }else{

            //if user wrong go to '/' page
            $error_email = [ "input" => "Error", "error" => "Wong password or email" ];
            array_push($_SESSION['form_error'],$error_email);
            // the cookie created will be retrieved by the js if it exists and will allow the login form to be refreshed in the event of user error
            // home_forme.js 
            setcookie("INTCONN", "false");
            return $response->withRedirect('/');

        }
      

        }else{
            // csrf token valide next
            return $response->withRedirect('/');
        }
  

 
        
    }


}