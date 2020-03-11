<?php

namespace App\Config;

use Model\UserManager;
use Psr\Http\Message\ResponseInterface;

// use ContainerRouter;

class RouterApp {


    protected $container = null;
    // token will use for get if user is logged or not and if token is valid or not by cookie in App
    protected $user_manager;

    public function __construct($container)
    {
        $this->container = $container;
        $this->user_manager = new UserManager();
    }

    protected function render(ResponseInterface $response, $file,$args = null){
      
        $this->container->view->render($response, $file,['data' => $args]);

    }

}



