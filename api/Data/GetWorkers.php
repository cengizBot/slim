<?php

use Psr\Container\ContainerInterface;
use API\ManagerApi;


require './ManagerApi.php';

// check if is ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{    
    
    if(isset($_COOKIE['token'])){

        $manager = new ManagerApi();
        
        $check = $manager->DecryptToken($_COOKIE['token']);

        if($check){

        
            $datas = $manager->getEmployes();

            echo json_encode(['datas' => $datas ]);

        }else{

            echo json_encode(['datas' => "Not found" ]);
        }

        
    }else{

        echo json_encode(['datas' => "Not found" ]);
    }
 
}else{

    echo json_encode(['datas' => "Not found Ajax request" ]);
}







