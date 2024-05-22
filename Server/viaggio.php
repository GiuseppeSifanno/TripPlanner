<?php 
    $params['lat'] = $_POST['lat'];
    $params['lon'] = $_POST['lon'];
    $params['display_name'] = $_POST['display_name'];
    $params['hash'] = getHash();
    $params['nomeViaggio'] = $_POST['nomeViaggio'];

    //if($params['hash'] == false) die("<script>alert('Impossibile creare il viaggio');</script>");

    if(doPost($params)){
        header("refresh:5; url=/TripPlanner/areaPrivata/creaViaggio.php");
        echo "<script>alert('Viaggio creato con seccesso');</script>";
    } 
    else {
        ob_start();
        echo "Non è stato possibile contattare il server. Reindirizzamente tra 5 secondi";
        header("refresh:5; url=/TripPlanner/areaPrivata/creaViaggio.php");
        ob_end_flush();
    }

    function doPost($params){
        
        $url = 'https://script.google.com/macros/s/AKfycbx8xDBsOeoCTWt09tnOZA1yOuhtQjuDOhHQcMW_hJtgdrLggaVfZ2uFwCIFeROGaAlSmQ/exec';
        
        $ch = curl_init(); 

        // Set cURL options 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params)); 
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        
        // Execute cURL session 
        if($response = curl_exec($ch)){
            //echo $response;
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // Close cURL session 
            curl_close($ch);
            if($response == 200) return true;
            else return false;
        }
    }

    function getHash(){
        session_start();
        include "./credenziali.php";

        $conn = new mysqli($host, $username, $password, $db_nome);

        if($conn == false) return "Errore nella connessione. Codice: ".mysqli_connect_error();

        $sql = "SELECT Hash FROM Utente WHERE Email = '".$_SESSION['Email']."'";

        $result = $conn -> query($sql);
        $row = $result -> fetch_assoc();
        $hash = $row['Hash'];
        
        return $hash;
    }

    