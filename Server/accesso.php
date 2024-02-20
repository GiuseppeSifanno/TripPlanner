<?php 
    require_once("credenziali.php");
    $conn = new mysqli($host, $username, $password, $db_nome);

    if($conn == false) die("Errore nella connessione con il database ".mysqli_connect_error());

    $mail = $_POST['Email'];

    $sql = "SELECT Email FROM Utente";

    $result = $conn -> query($sql);

    if($result -> num_rows >= 0){
        $row = $result -> fetch_array();
        $i = 0;
        while($i < count($row)){
            if($mail == $row[$i]){
                //accesso
            }
            $i++;
        }
    }