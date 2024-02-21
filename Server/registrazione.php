<?php
function registrazione(){
    session_start();
    $nome = $_POST['Nome'];
    $cognome = $_POST['Cognome'];
    $mail = $_POST['Email'];
    $password =$_POST['Password'];
    require_once("credenziali.php");
    $conn = new mysqli($host, $username, $password, $db_nome);

    if($conn == false) die("Errore nella connessione con il database ".mysqli_connect_error());

    $sql = "SELECT Email FROM Utente";

    $result = $conn -> query($sql);

    if($result !== false){
        $i = 0;
        while($i < $result -> num_rows){
            $row = $result -> fetch_row();
            if($mail === $row[0]){
                echo "Mail gia esistente";
                exit();
            }
            $i++;
        }
        
        $password = md5($password);
        $str = $mail . $password;
        $Hash = md5($str);
        
        $sql = "INSERT INTO Utente (Id, Nome, Cognome, Email, Password, Hash) VALUES (NULL,'".$nome."', '".$cognome."', '".$mail."', '".$password."', '".$Hash."')";
        echo "INSERT INTO Utente (Id, Nome, Cognome, Email, Password, Hash) VALUES (NULL,'".$nome."', '".$cognome."', '".$mail."', '".$password."', '".$Hash."')";

        if($conn -> query($sql) == true) {
            echo "Inserimento andato a buon fine";
            $conn -> close();
            return true;
        }
        else {
            $conn -> close();
            die("Errore nell'inserimento ".mysqli_error($conn));
        }
    }
    else {
        $conn -> close();
        die("Errore nella query ".mysqli_errno($conn));
    }
}