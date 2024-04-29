<!DOCTYPE html>
    <html lang="it">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Trip Planner</title>

            <link rel="stylesheet" href="/TripPlanner/Style/stile.css" type="text/css">

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
            <?php 
                session_start();
                if($_SESSION['consenti'] == false){
                    echo "<script>alert('Accesso non consentito')</script>";
                    header('refresh:5; url=/TripPlanner/index.php');
                };
            ?>
        </head>
        <body>
            <?php
                //se non sono presenti viaggi allora si visualizzerà una pagina differente altrimenti
                //verranno generate le card
                if($viaggi = hasViaggi()) {
                    include_once "navbar.html";
                    creaCardViaggi($viaggi); 
                }
                else include 'noViaggi.php';
                function hasViaggi(){
                    session_start();
                    include_once "/TripPlanner/Server/credenziali.php";
                    $conn = new mysqli($host, $username, $password, $db_nome);
                    if($conn == false) return "Errore nella connessione. Codice: ".mysqli_connect_error();
                    $mail = $conn -> real_escape_string($_SESSION['Email']);
                    $sql = "SELECT Hash FROM Utente WHERE Email = '$mail';";
                    if($hash = $conn -> query($sql)) {
                        if( ($viaggi = json_decode(doGet($hash), true)) != null) return $viaggi;
                        else return false; 
                    }
                    else return false;
                }
                //verifichiamo l'esistenza di viaggi creati precedentamente dall'utente
                //nel caso in cui esistono ci vengono restituiti così da poter creare la pagina
                function doGet($hash){
                    $url = 'da riempire' .'?'. http_build_query($hash);;
                    
                    $ch = curl_init(); 
                    // Set cURL options 
                    curl_setopt($ch, CURLOPT_URL, $url); 
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                    
                    $response = curl_exec($ch);
                    // Execute cURL session 
                    if(($code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) == 200){
                        // Close cURL session 
                        curl_close($ch);
                        return $response;
                    }
                    else return false;
                }
                function creaCardViaggi($viaggi){
                    $i = 0;
                    do{
                        //recuperiamo il viaggio i-esimo  in lista
                        $viaggio = $viaggi[$i];

                        //recuperiamo il nome del i-esimo viaggio
                        $nomeViaggio = $viaggio['nomeViaggio'];
                        
                        //recuperiamo le tappe del i-esimo viaggio contenute in un array numerico
                        $tappe = $viaggio['tappe'];
                        
                        $nTappe = 0;
                        while ($nTappe < count($tappe)){
                            ///recupero le tappe una dopo l'altra
                            $tappa = $tappe[$nTappe];
                            
                            //...stile card

                            $nTappe++;
                        }

                        $i++;
                    }while($i < count($viaggi));   
                }
            ?>
        
        

            <script>
                /*
                var viaggi = document.getElementById("cardGroup");
                function cercaTappa(){
                    //chiamata all'api
                    var testo = document.getElementById("search");
                    if(testo.value !== ""){
                        const xhttp = new XMLHttpRequest();
                        xhttp.readyState = function() {
                            if(this.readyState == 4 && this.status == 200){
                                var json = JSON.parse(xhttp.responseText);
                                aggiungiTappa(json);
                            }
                        }
                        //inserire il puntamento all'api appscript
                        xhttp.open('GET', "?tappa="+testo.value);
                        xhttp.send();
                    }
                }
                function aggiungiTappa(json){
                    json = JSON.parse(JSON.stringify(json));
                    var id = viaggi.childElementCount++;
                    var display_name = json[0].display_name;
                    var lat = json[0].lat;
                    var lon = json[0].lon; 
                    var cardTappa = document.createElement("div");
                    cardTappa.classList.add("card text-left");
                    cardTappa.innerHTML = "<div class='col' id='"+id+"'><div class='card text-left' id='card'><div class='card-body'><h4 class='card-title' name='display_name[]'>"+display_name+"</h4><input type='hidden' name='lat[]' value='"+lat+"'><input type='hidden' name='lon[]' value='"+lon+"'></div><div class='p-3' id='comandi'><button type='button' class='btn btn-outline p-2' id='btn-delete' onclick='cancella(i)'><img src='../Icone/trash.svg' alt='Elimina' role='button'></button></div></div></div>";
                    //aggiunge la tappa nel contenitore 
                    viaggi.appendChild(cardTappa);
                }
                function cancella(idTappa){
                    if(confirm("Sicuro di voler eliminare questa tappa?")) viaggi.removeChild(document.getElementById(idTappa));
                    else return;
                    if(viaggi.hasChildNodes())document.getElementById("CreaViaggio").classList.add("active");
                    else document.getElementById("btn-crea").classList.add("disabled");
                }
                */
            </script>
        </body>
    </html>