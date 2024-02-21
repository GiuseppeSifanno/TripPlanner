<?php
    require_once("credenziali.php");
    $conn = new mysqli($host, $username, $password, $db_nome);

    if($conn == false) die("Errore nella connessione con il database ".mysqli_connect_error());

    $mail = $_POST['Email'];

    $sql = "SELECT Email, Password FROM Utente WHERE Email = '$mail'";
    echo "SELECT Email, Password FROM Utente WHERE Email = '$mail'";

    $result = $conn -> query($sql);

    if($result == false) die("Email non registrata");
    else {
        if($result -> fetch_column(1) === md5($_POST['Password']) ) {
            //accesso consentito, indirizzamento alla sua area privata
        }
        else {
            //accesso non consentito, deve reinserire la password
        }
    }; 