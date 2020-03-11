<?php

session_start();

//create new worker with form in interface template
use API\ManagerApi;
use Volnix\CSRF\CSRF;

require './ManagerApi.php';


    //check token auth
    if(isset($_COOKIE['token'])){

        $manager = new ManagerApi();
        
        $check = $manager->DecryptToken($_COOKIE['token']);

        if($check){
                $k = CSRF::validate($_POST);

                if(CSRF::validate($_POST)){
                    echo json_encode(['datas' => "success" ]);
                }else{
                    echo json_encode(['datas' => $k ]);
                }

        }else{

            echo json_encode(['datas' => "Erreur Token" ]);
        }
    }else{
        echo json_encode(['datas' => "Cookie Token not found" ]);
    }

   


