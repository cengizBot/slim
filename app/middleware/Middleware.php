<?php

namespace Middleware\Form;

use Model\Users;
use Model\UserManager;
use Model\Employee;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Middleware {

    protected $container;
    protected $user;
    protected $user_manager;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->user = new Users($this->container);
        $this->user_manager = new UserManager();
        
    }



}