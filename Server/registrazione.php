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
                echo "Mail gia esistente";
                exit();
            }
            $i++;
        }
        $password = md5($_POST['Password']);
        $Hash = md5( ($_POST['Mail']+$_POST['Password']));
        $sql = "INSERT INTO Utente (Id, Nome, Cognome, Email, Password, Hash) VALUES (null,'".$_POST["Nome"]."', '".$_POST["Cognome"]."', '".$_POST["Email"]."', '".$password."', '".$Hash."')";
        if($conn -> query($sql)) {
            echo "Inserimento andato a buon fine";
        }
        else die("Errore nell'inserimento ".mysqli_errno($conn));

        $conn -> close();
    }
