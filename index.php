<?php

session_start();

use API\ManagerApi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Config\Configuration as Conf;
use ContainerRouter\testing;
use Model\Employee;
use Model\Users;
use Slim\Views\Twig;
use Model\Token;
use Model\UserManager;
use Volnix\CSRF\CSRF;


require './vendor/autoload.php';

//config return info database 
$config = require './app/config/config.php';

$container = new \Slim\Container;
$app = new \Slim\App($container);


require './env/env.php';

require './app/model/Users.php';
require './app/model/Token.php';
require './app/model/UserManager.php';
require './app/model/Employee.php';

//get router of app
require_once './app/config/Routeur.php';
require_once './app/controller/PageRouteur.php';

//////// Middleware
// parent Middleware
require_once './app/middleware/Middleware.php';
// connexion Middleware
require_once './app/middleware/HomeConnexionMiddle.php';
// inscription Middleware
require_once './app/middleware/HomeInscriptionMiddle.php';
// post new employee Middleware
require_once './app/middleware/PostEmployeeMiddle.php';

// ---------- Middleware Interface ---------- // 
require_once './app/middleware/Interface/InfoEmployeeMiddle.php';
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

// require container for initialization
require_once './app/config/container.php';

$user = new Users($container);
$token_user = new UserManager();




// auth path
$app->add(new Tuupola\Middleware\JwtAuthentication ([
    "path" => "/interface", /* or ["/api", "/admin"] */
    "header" => "X-Token",
    "attribute" => "jwt",
    "secret" => "supersecretkeyyoushouldnotcommittogithub",
    "algorithm" => ["HS256", "HS384"],
    "error" => function ($response, $arguments) use ($app) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return  $response->withStatus(302)->withHeader('Location', 'http://localhost:8080/');
    }
]));


// route 
$app->get('/', \App\Config\RouterView::class . ':home');
//inscription
$app->post('/inscription', \App\Config\RouterView::class . ':homeInscription')->add(new \Middleware\Form\FormInscriptionSubmitHome($container));
//connexion
$app->post('/connexion', \App\Config\RouterView::class . ':homeConnexion')->add(new \Middleware\Form\FormConnexionSubmitHome($container));

//RH create employee
$app->post('/addEmployee' , \App\Config\RouterView::class . ':addEmployee')->add(new \Middleware\Form\FormEmployeeSubmitInterface($container));

//RH info employee
$app->get('/employe/{id}' , \App\Config\RouterView::class . ':infoEmployee')->add(new \Middleware\Interfaces\InfoEmployee($container));


$app->get('/test/{name}', \App\Config\RouterView::class . ':test');
$app->get('/interface', \App\Config\RouterView::class . ':interface');

$app->run();


