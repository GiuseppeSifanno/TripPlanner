<?php 
    $params['lat'] = $_POST['lat'];
    $params['lon'] = $_POST['lon'];
    $params['display_name'] = $_POST['display_name'];
    
    //$params = "1";
    
    if(doPost($params)) return true;
    else {
        ob_start();
        echo "Non è stato possibile contattare il server. Reindirizzamente tra 5 secondi";
        header("refresh:5; url=/TripPlanner/areaPrivata/creaViaggio.php");
        ob_end_flush();
    }

    function doPost($params){
        
        //return false;
        
        $url = 'Da inserire';
        
        $ch = curl_init(); 
        // Set cURL options 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        
        // Execute cURL session 
        if($response = curl_exec($ch)){
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // Close cURL session 
            curl_close($ch);
            if($response == 200) return true;
            else if($response >= 400 || $response <= 500) return false;
        } 
    }