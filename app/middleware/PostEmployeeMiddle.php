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
    private $employee;


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
                
                }

                if(strlen($firstname) === 0){

                    $error_firstname = [ "input" => "firstname", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_firstname);

                }else{
                
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
                
                }

                if(strlen($fonction) === 0){

                    $error_fonction = [ "input" => "fonction", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_fonction);

                }else{
                
                }

                if(strlen($years) === 0){

                    $error_years = [ "input" => "name", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$error_years);

                }else{
                
                }

                if(strlen($enter_date) === 0){

                    $enter_date = [ "input" => "Date d'entrée", "error" => "empty" ];
                    array_push($_SESSION['form_error'],$enter_date);

                }else{
                
                }

                $error = count($_SESSION['form_error']);

                // 0 error in form go to inscription
                if($error === 0 ){

                    $this->employee = new Employee($name,$firstname,$email,$fonction,$years,$city,$this->container);
                    $this->employee->postEmployee();
         
                }else{
                    // return error form
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