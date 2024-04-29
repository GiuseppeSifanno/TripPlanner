<?php
    function Accedi(){
        session_start();
        require_once "credenziali.php";

        $mail = strtolower(stripslashes($_SESSION['Email']));
        $psw = stripslashes($_POST['Password']);

        $conn = new mysqli($host, $username, $password, $db_nome);

        if($conn == false) return "Errore nella connessione. Codice: ".mysqli_connect_error();

        $mail = $conn -> real_escape_string($mail);

		$sql = "SELECT Email, Password FROM ".$db_nome.".Utente WHERE Email = '$mail'";

        $result = $conn -> query($sql);

        //la mail non è presente nel db quindi è disponibile
        if($result -> num_rows == 1){
            $pswHash = md5($psw);
            $row = $result -> fetch_assoc();
            
            if($pswHash == $row['Password']){
                $conn -> close();
                $_SESSION['consenti'] = true;
                return true;
            } 
            else{
                $_SESSION['consenti'] = false;
                $conn -> close();
                return "Password non corretta, riprova";
            } 
        }
        else return "L'email non esiste. Controlla che sia corretta oppure <a href='/TripPlanner/register.php' class='alert-link'>registrati</a>";
    }