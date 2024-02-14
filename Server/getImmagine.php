<?php
    // $q = $_REQUEST;
    // if($q == '') return http_response_code(400);
    
    // switch ($q) {
    //     case "img": {
            
    //         if(empty($path)) return http_response_code(500);
    //         else echo rand(0, count($path));
    //         break;
    //     }
    //     default:
    //         # code...
    //         break;
    // }
    echo GetFoto();
    function GetFoto(){
        $handler = opendir("../Sfondi");
        $i=0;
        $foto = array();
        if($handler !== false){
            while(($file = readdir($handler))){
                if($file !== "." && $file !== ".."){
                    array_push($foto, $file);
                } 
            }
        }
        closedir($handler);
        return $foto[rand(0, count($foto)-1)];
    }