<?php 
    /*$params['lat'] = $_POST['lat'];
    $params['lon'] = $_POST['lon'];
    $params['display_name'] = $_POST['display_name'];
    $params['hash'] = $_POST['hash'];
    $params['nomeViaggio'] = $_POST['nomeViaggio'];
    */
    $params['lat'] = 1029;
    $params['lon'] = 1049;
    $params['display_name'] = "ciaop";
    $params['nomeViaggio'] = "pippo";
    $params['hash'] = getHash();
    
    if($params['hash']) return "<script>alert('Impossibile creare il viaggio');</script>";

    if(doPost($params)) echo "<script>alert('Viaggio creato con seccesso');</script>";
    else {
        ob_start();
        echo "Non è stato possibile contattare il server. Reindirizzamente tra 5 secondi";
        header("refresh:5; url=/TripPlanner/areaPrivata/creaViaggio.php");
        ob_end_flush();
    }

    function doPost($params){
        
        $url = 'https://script.google.com/macros/s/AKfycbxpDDXHL7XT2ATD9RVjGm4Izu2jsXulkHl0UkieC9gM5DmMfYWE_ULpcbOA3QM2GzhhpQ/exec';
        
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
            else return false;
        }
    }

    function getHash(){
        session_start();
        include_once "/TripPlanner/Server/credenziali.php";

        $conn = new mysqli($host, $username, $password, $db_nome);

        if($conn == false) return "Errore nella connessione. Codice: ".mysqli_connect_error();

        $mail = $conn -> real_escape_string($_SESSION['Email']);

        $sql = "SELECT Hash FROM Utente WHERE Email = '$mail';";
        if($hash = $conn -> query($sql)) return $hash;
        else return false;
    }