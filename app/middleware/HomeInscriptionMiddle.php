<?php

namespace Middleware\Form;

use Model\Users;
use Middleware\Form\Middleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Volnix\CSRF\CSRF;

class FormInscriptionSubmitHome extends Middleware {

 

    public function __invoke($request, $response, $next)
    {

        
        if(CSRF::validate($_POST)){
            
            // csrf token valide next
                
            $_SESSION['form_error'] = [];
            $email = $request->getParam('email');
            $password = $request->getParam('password');
            $samepassword = $request->getParam('samepassword');

            if($email === ""){

                $error_email = [ "input" => "email", "error" => "empty" ];
                array_push($_SESSION['form_error'],$error_email);

            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

                    $error_email = [ "input" => "email", "error" => "Email not valid" ];
                    array_push($_SESSION['form_error'],$error_email);
        
                }
            }

            if($password === ""){

                $error_password = [ "input" => "password", "error" => "empty" ];
                array_push($_SESSION['form_error'],$error_password);

            }else{
                if(strlen($password) < 5 ){

                    $error_password = [ "input" => "password", "error" => "5 Minimum characters" ];
                    array_push($_SESSION['form_error'],$error_password);
                }
            }
    
            if($samepassword === ""){

                $error_samepassword = [ "input" => "samepassword", "error" => "empty" ];
                array_push($_SESSION['form_error'],$error_samepassword);

            }else{
                if(strlen($samepassword) < 5 ){

                    $error_samepassword = [ "input" => "samepassword", "error" => "5 Minimum characters" ];
                    array_push($_SESSION['form_error'],$error_samepassword);
                }
            }

            if($samepassword != $password){
                $error_equalpass = [ "input" => "Passwords", "error" => "Passwords are not equal" ];
                array_push($_SESSION['form_error'],$error_equalpass);
            }


            $error = count($_SESSION['form_error']);

            // 0 error in form go to inscription
            if($error === 0 ){
                //check user if email exist
                $new_user = $this->user->createUser($email,$password);
                
                if(!$new_user){
                    //email exist false inscription
                    $error_checkemail = [ "input" => "Email", "error" => "Email already registered"];
                    array_push($_SESSION['form_error'],$error_checkemail);

                }else{
                        //email not exist true inscription
                        $error_checkemail = [ "success" => "Success", "msg" => "Account register"];
                        array_push($_SESSION['form_error'],$error_checkemail);
                }
            }
            
            return $next($request, $response);

        }else{
            return $response->withRedirect('/');
        }
        
    }


}