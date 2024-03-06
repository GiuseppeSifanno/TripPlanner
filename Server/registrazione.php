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
                //reindirizzamento alla pagina privata dell'utente (nome da rivedere)
                return true;
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