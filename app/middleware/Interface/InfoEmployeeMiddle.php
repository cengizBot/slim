<?php

namespace Middleware\Interfaces;

use Psr\Container\ContainerInterface;
use Middleware\Form\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;


class InfoEmployee extends Middleware {

   
    public function __invoke($request, $response, $next)
    {
        
        // get params id in url get in array
        $id = $request->getAttribute('routeInfo')[2];

        // creat string for array params id
        $id = implode($id);
        
        // check find id of employee in DB , exist or not
        $employee = $this->employee->getById($id);
        
        if(!$employee){
            // false 
            return $response->withRedirect('/interface');
        }
        
        $_SESSION['employee_data'] = $employee[0]['id'];
        return $next($request,$response);

    }


}
