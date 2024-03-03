<?php
function registrazione(){
    session_start();
    require_once("credenziali.php");
    $nome = $_SESSION['Nome'];
    $cognome = $_SESSION['Cognome'];
    $mail = $_SESSION['Email'];
    $password =$_POST['Password'];
    
    $conn = new mysqli($host, $username, $password, $db_nome);

    if($conn == false) die("Errore nella connessione con il database ".mysqli_connect_error());

    $sql = "SELECT Email FROM Utente";

    $result = $conn -> query($sql);

    if($result !== false){
        while($row = $result -> fetch_assoc()){
            if($mail === $row['Email']){
                //se l'email esiste gia' viene mostrato un alert al client
                return false;
            }
        }
        
        $password = md5($password);
        $str = $mail . $password;
        $Hash = md5($str);
        
        $sql = "INSERT INTO Utente (Id, Nome, Cognome, Email, Password, Hash) VALUES (NULL,'".$nome."', '".$cognome."', '".$mail."', '".$password."', '".$Hash."')";
        echo "INSERT INTO Utente (Id, Nome, Cognome, Email, Password, Hash) VALUES (NULL,'".$nome."', '".$cognome."', '".$mail."', '".$password."', '".$Hash."')";

        //informazioni salvate correttamente nel db, lo comunichiamo al client e interrompiamo l'esecuzione
        if($conn -> query($sql)) {
            $conn -> close();
            return true;
        }
        //query non andata a buon fine, lo comunichiamo al client e interrompiamo l'esecuzione
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