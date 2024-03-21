<?php
    function Registra(){
        session_start();
        require_once "credenziali.php";

        //protezione da SQL injection con formattazione dei dati

        //nome e cognome hanno solamente la prima lettera maiuscola, le altre tutte minuscole
        $nome = ucfirst(strtolower(stripslashes($_SESSION['Nome'])));
        $cognome = ucfirst(strtolower(stripslashes($_SESSION['Cognome'])));

        $mail = strtolower(stripslashes($_SESSION['Email']));
        $psw = stripslashes($_POST['Password']);
        
        $conn = new mysqli($host, $username, $password, $db_nome);

        if($conn == false) return "Errore nella connessione. Codice: ".mysqli_connect_error();

        $mail = $conn -> real_escape_string($mail);

        $sql = "SELECT Email FROM Utente WHERE Email = '$mail'";
        $result = $conn -> query($sql);

        //la mail non è presente nel db quindi è disponibile
        if($result -> num_rows == 0){
            //calcoliamo l'hash della mail unita alla password
            $str = $mail . $psw;
            $Hash = md5($str);

            //calcoliamo l'hash della password
            $psw = md5($psw);

            $sql = "INSERT INTO ".$db_nome.".Utente (Nome, Cognome, Email, Password, Hash) VALUES ('$nome', '$cognome', '$mail', '$psw', '$Hash')";

            //informazioni salvate correttamente nel db, lo comunichiamo al client e interrompiamo l'esecuzione
            if($conn -> query($sql)) {
                $conn -> close();
                $_SESSION['SID'] = session_id();
                if(doPost($Hash)) return true;
                else return "Non è stato possibile portare a termine l'operazione di registrazione. Riprova!";
            }
            //query non andata a buon fine, lo comunichiamo al client e interrompiamo l'esecuzione
            else {
                $conn -> close();
                
                //messaggio visualizzato nell'alert
                return "Non è stato possibile effettuare la registrazione, riprova\nErrore: ".mysqli_error($conn);
            }
        }
        else if($result -> num_rows == 1) {
            //c'è già un'altra mail uguale presente nel db
            $conn -> close();
            return "Email già presente nel sistema. Prova ad effettuare il <a href='/TripPlanner/login.php' class='alert-link'>login</a>";
        }
    }

    function doPost($Hash){

        $url = 'https://script.google.com/macros/s/AKfycbzeydAcngR0EbZJRocsJnlM3tSCCcfDjOF_D6eBIQ4g-P5YAmj9F0vl7i2Q98Ch07JsNw/exec';
        
        $ch = curl_init(); 
        // Set cURL options 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Hash); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        
        // Execute cURL session 
        if($response = curl_exec($ch)){
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // Close cURL session 
            curl_close($ch);
            if($response == 200) return true;
            else if($response == 500) return false;
        } 
    }