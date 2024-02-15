<?php
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