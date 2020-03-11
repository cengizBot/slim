<?php

namespace App\Config;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Slim\Router;

class RouterView extends RouterApp {
    

    protected $table;
    private $csrf_token = \Volnix\CSRF\CSRF::TOKEN_NAME;
    private $csrf_getToken = "";


    public function home(RequestInterface $request,Response $response, array $args) {

        // add attr $csrf_getToken to getToken csrf
        $this->csrf_getToken = \Volnix\CSRF\CSRF::getToken();

       
        //variable to get data about user if logged, pass into template
        $userData = "";
        // isset cookie token and decrypt it, if decrypt success user logged else user corrupt or not logged
        if(isset($_COOKIE['token'])){

            $token_user = $_COOKIE['token'];

            $t = $this->user_manager->Decrypt($token_user);
            
            if($t){

               $userData = $t;
                
            }else{
                //delete the cookie token if exist
                setcookie('jwt', '', time() - 3600);
            }

        }

        if(!isset($_SESSION['form_error'])){
            $_SESSION['form_error'] = "";
                        
        }

        // render template and give data !         
        $this->render($response, '/pages/home.twig', [ 'data' => [ "error" => $_SESSION['form_error'],'user' => $userData , 'csrf' => $this->csrf_token , 'getCsrf' => $this->csrf_getToken ] ]);
        $_SESSION['form_error'] = "";
    }

    public function homeInscription(RequestInterface $request,Response $response){

        // check the method
        // $method = $request->getMethod();
        // $method = strtolower($method);
        

        // if($method === 'post'){
                        
        //     return $response->withRedirect('/');
        // }

        return $response->withRedirect('/');

    }

    public function addEmployee(RequestInterface $request,Response $response){

        return $response->withRedirect('/interface');
      
    }

    public function homeConnexion(RequestInterface $request,Response $response){
        // if user conn success redirect to interface
        //else automatically redirect to home
        return $response->withRedirect('/interface');
    }

    public function interface(RequestInterface $request,Response $response){
        
         //variable to get data about user if logged, pass into template
         $userData = "";
         // isset cookie token and decrypt it, if decrypt success user logged else user corrupt or not logged
         if(isset($_COOKIE['token'])){
 
             $token_user = $_COOKIE['token'];
 
             $t = $this->user_manager->Decrypt($token_user);
             $this->csrf_getToken = \Volnix\CSRF\CSRF::getToken();
             
             if($t){
 
                $userData = $t;
                if(!isset($_SESSION['form_error'])){
                    $_SESSION['form_error'] = "";
                
                }

                // if user is logged and decrypt token success render templates
                $this->render($response, '/pages/interface.twig', ["data" =>  [ "error" => $_SESSION['form_error'],'user' => $userData ,'csrf' => $this->csrf_token , 'getCsrf' => $this->csrf_getToken ] ]);
                return $_SESSION['form_error'] = "";
                

             }else{
                 //else decrypt failed return "/"
                 $response->withRedirect('/');
                 //delete the cookie token if exist
                 setcookie('jwt', '', time() - 3600);
             }
 
         }else{
             
         }

         // no cookie token return "/"
         return $response->withRedirect('/');
 

    }





   public function test(RequestInterface $request,Response $response, array $args){

    
       return $this->render($response, '/pages/test.twig');

   }


    
}



