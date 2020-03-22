<?php


namespace Middleware\Form;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Volnix\CSRF\CSRF;
use Model\Employee;
use Middleware\Form\Middleware;

class FormEmployeeSubmitInterface extends Middleware {

    CONST string_r =  "/^[a-zA-Z]*$/";
    CONST email_r = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
    CONST int_r = "/^[0-9]*$/";
    CONST stringSpace_r =  "/^[a-zA-Z ]*$/";
    CONST date_r = "/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/";
  

    public function __invoke($request, $response, $next)
    {
        //if csrf valide 
        if(CSRF::validate($_POST)){
            //if token valide

            $check = $this->user_manager->Decrypt($_COOKIE['token']);

            //token success
            if($check){

                $_SESSION['form_error'] = [];

                $name = $request->getParam('name');
                $firstname = $request->getParam('firstname');
                $email = $request->getParam('email');
                $fonction = $request->getParam('fonction');
                $years = $request->getParam('years');
                $city = $request->getParam('ville');
                $enter_date = $request->getParam('enter_date');

                if(strlen($name) === 0){

                    $error_name = [ "input" => "name", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_name);

                }else{

                    if(!preg_match(self::string_r,$name)){
                        $error_name = [ "input" => "name", "error" => "Champ incorrect" ];
                        array_push($_SESSION['form_error'],$error_name);
                    }
                
                }

                if(strlen($firstname) === 0){

                    $error_firstname = [ "input" => "firstname", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_firstname);

                }else{
                    if(!preg_match(self::string_r,$firstname)){
                        $error_firstname = [ "input" => "firstname", "error" => "Champ incorrect" ];
                        array_push($_SESSION['form_error'],$error_firstname);
                    }
                }

                if(strlen($email) === 0){

                    $error_email = [ "input" => "email", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_email);

                }else{
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

                        $error_email = [ "input" => "email", "error" => "Email not valid" ];
                        array_push($_SESSION['form_error'],$error_email);
            
                    }
                }

                if(strlen($city) === 0){

                    $error_city = [ "input" => "city", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_city);

                }else{
                    if(!preg_match(self::stringSpace_r,$city)){
                        $error_city = [ "input" => "city", "error" => "Champ incorrect" ];
                        array_push($_SESSION['form_error'],$error_city);
                    }
                }

                if(strlen($fonction) === 0){

                    $error_fonction = [ "input" => "fonction", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_fonction);

                }else{
                    if(!preg_match(self::stringSpace_r,$fonction)){
                        $error_fonction = [ "input" => "fonction", "error" => "Champ incorrect" ];
                        array_push($_SESSION['form_error'],$error_fonction);
                    }
                }

                if(strlen($years) === 0){

                    $error_years = [ "input" => "Age", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_years);

                }else{
                    if(!preg_match(self::int_r,$years)){
                        $error_years = [ "input" => "years", "error" => "Champ incorrect" ];
                        array_push($_SESSION['form_error'],$error_years);
                    }else{
                        if($years < 18 || $years > 65 ){
                            $error_years = [ "input" => "years", "error" => "Erreur champ incorrect (18 - 65 ans Min / Max)" ];
                            array_push($_SESSION['form_error'],$error_years);
                       
                        }
                    }
                }

                if(strlen($enter_date) === 0){

                    $enter_date = [ "input" => "Date d'entrée", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$enter_date);

                }else{
                    if(!preg_match(self::date_r,$enter_date)){
                        $error_enter_date = [ "input" => "enter_date", "error" => "Champ incorrect" ];
                        array_push($_SESSION['form_error'],$error_enter_date);
                    }else{
                        //must correspond to the current year
                        //get years
                        $formatDay = date("Y", strtotime($enter_date));
                        //current years
                        $current = date("Y");  

                        if($formatDay != $current){
                            $error_enter_date = [ "input" => "Date d'entrée", "error" => "Erreur l'année doit correspondre à l'année en cours" ];
                            array_push($_SESSION['form_error'],$error_enter_date);
                        }

                    }
                }

                $error = count($_SESSION['form_error']);

                // 0 error in form go to inscription
                if($error === 0 ){
           
                    $post = $this->employee->postEmployee($name,$firstname,$email,$fonction,$years,$city,$enter_date);

                    if(!$post){
                        // email already save
                        // return error not save employee
                        $error_post = [ "input" => "Email", "error" => "Email dejâ enregistré" ];
                        array_push($_SESSION['form_error'],$error_post);
                    }else{
                        $success_post = [ "success" => "Success", "msg" => "Enregistrement réussi" ];
                        array_push($_SESSION['form_error'],$success_post);
                    }
         
                }

                return $next($request, $response);


            }else{
                // return error token 
            }


        }else{
           
            // return error csrf
        }

        return $response->withRedirect('/interface');

    }

}