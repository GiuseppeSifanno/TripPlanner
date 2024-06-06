<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Trip Planner</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
        <?php 
            session_start();
            if($_SESSION['consenti'] == false){
                echo "<script>alert('Accesso non consentito')</script>";
                header('refresh:5; url=/TripPlanner/index.php');
            };
        ?>
        <style>
        body {
            line-height: 23px;
        }

        #ctn-parent {
            width: -webkit-fill-available;
            width: fit-content;
            padding-top: 30px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            row-gap: 20px;
            height: auto;
        }

        .card {
            width: 100%;
            flex-direction: row;
            align-items: center;
        }

        .card:hover {
            box-shadow: rgba(35, 34, 34, 0.54) 0px 0px 1rem;
        }

        .offcanvas.offcanvas-top {
            height: 100%;
            position: relative;
            width: 100%;
            display: none;
        }
        </style>
    </head>

    <body>
        <?php include_once "navbar.html"; ?>
        <div class="container-md" id="ctn-parent">
            <?php
                //se non sono presenti viaggi allora si visualizzerà una pagina differente altrimenti
                //verranno generate le card
                if($viaggi = hasViaggi()) creaCardViaggi($viaggi); 
                //else include 'noViaggi.php';
                function hasViaggi(){

                    /*$viaggi = "{\"viaggi\": [{\"tappe\": [\"Paris, Ile-de-France, Metropolitan France, France\"],\"nomeViaggio\": \"Il viaggio1ddd\"},{\"tappe\": [\"Bitonto, Bari, Apulia, 70032, Italy\"],\"nomeViaggio\": \"Il viaggio4455\"},{\"tappe\": [\"Paris, Ile-de-France, Metropolitan France, France\",\"Bitonto, Bari, Apulia, 70032, Italy\"],\"nomeViaggio\": \"Il viaggio2\"},{\"tappe\": [\"Paris, Ile-de-France, Metropolitan France, France\",\"Bitonto, Bari, Apulia, 70032, Italy\"],\"nomeViaggio\": \"Il viaggio3\"}],\"hash\": \"75df1d06fc54e93b5f12ee310b9cd80b\"}";
                    $json = json_decode($viaggi, true, 512, JSON_HEX_APOS);
                    return $json;*/

                    session_start();
                    include_once "../Server/credenziali.php";
                    $conn = new mysqli($host, $username, $password, $db_nome);

                    if($conn == false) return "Errore nella connessione. Codice: ".mysqli_connect_error();
                    $mail = $conn -> real_escape_string($_SESSION['Email']);

                    $sql = "SELECT Hash FROM $db_nome.Utente WHERE Email = '$mail';";
                    if($result = $conn -> query($sql)) {
                        $row = $result ->fetch_assoc();
                        $hash = $row['Hash'];
                        //se ci sono dei valori ritornati allora ritorniamo la lista dei viaggi decodificata da JSON a PHP
                        if($json = doPost($hash)){
                            //echo json_decode($json, true, 512, JSON_HEX_APOS | JSON_THROW_ON_ERROR);
                            if( ($viaggi = json_decode($json, true, 512, JSON_HEX_APOS | JSON_THROW_ON_ERROR)) != null) return $viaggi;
                            else return false;
                        }
                    }
                    else return false;
                }

                //verifichiamo l'esistenza di viaggi creati precedentamente dall'utente
                //nel caso in cui esistono ci vengono restituiti così da poter creare la pagina
                function doPost($hash){
                    $url = 'https://script.google.com/macros/s/AKfycbwGsMJWZ84VsAd0Bxf2Ji6-xc7ODkTHRLzHkYR7gjjKLcWVN0m2YE3036NHu0aO8M2YWg/exec';
                    
                    $ch = curl_init(); 
                    // Set cURL options 
                    curl_setopt($ch, CURLOPT_URL, $url); 
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $hash);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

                    if($response = curl_exec($ch)) {
                        curl_close($ch);
                        return $response;
                    }
                    else return false;
                }
                function creaCardViaggi($viaggi){
                    $i = 0;
                    $viaggiArr = $viaggi['viaggi'];
                    //verifichiamo che ci siano dei viaggi nel json, in caso non ci sono viene mostrato un avviso
                    if($viaggiArr[0] == 'empty') {
                        include 'noViaggi.php';
                        die;
                    } 
                    
                    while($i < count($viaggi['viaggi'])){
                        $card = "";
                        //echo "<br>Viaggi arr: ".print_r($viaggiArr);
                        //recuperiamo il viaggio i-esimo  in lista
                        $viaggio = $viaggiArr[$i];
                        //recuperiamo il nome del i-esimo viaggio
                        $nomeViaggio = $viaggio['nomeViaggio'];

                        $card = "<div class='card text-left'><div class='card-body p-2'><h4 class='card-title'>$nomeViaggio</h4>";
                        //recuperiamo le tappe del i-esimo viaggio contenute in un array numerico
                        $tappe = $viaggio['tappe'];

                        $card .= "<div class='container-sm' id='list-tappe'><i>Tappa/e:</i><ul>";
                        $nTappe = 0;

                        while ($nTappe < count($tappe)){
                            ///recupero le tappe una dopo l'altra
                            $tappa = $tappe[$nTappe];
                            //aagiunta tappa
                            $card .= "<li>$tappa</li>";
                            $nTappe++;
                        }
                        $card .= "</ul></div></div>";
                        $card .= "<div class='p-3' id='comandi'><button type='button' id='expand' onclick=openMap('n$i') class='btn btn-outline p-2' data-bs-toggle='offcanvas' data-bs-target='#n$i' aria-controls='offcanvasTop'><img src='../Icone/expand-more.svg' alt='Mostra' role='button'></button></div>";
                        $card .= "</div>";
                        $card .= "<div class='offcanvas offcanvas-top' data-bs-backdrop='static' tabindex='-1' id='n$i' aria-labelledby='offcanvasTopLabel'>
                        <div class='offcanvas-header'>
                            <h4>Mappa: ". $viaggio['nomeViaggio'] ."</h4>
                            <button type='button' class='btn-close' id='btnMapClose' onclick=closeMap('n$i') data-bs-dismiss='offcanvas' aria-label='Close'></button>
                        </div>
                        <div class='offcanvas-body'>
                        <iframe width='100%' height='300px' frameborder='0' allowfullscreen allow='geolocation' 
                            src='//umap.openstreetmap.fr/it/map/estate2k24_1079843?scaleControl=false&miniMap=false&scrollWheelZoom=true&zoomControl=true&editMode=disabled&moreControl=true&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=true&onLoadPanel=none&captionBar=false&captionMenus=true&editinosmControl=false'></iframe>
                        <p>
                            <a href='//umap.openstreetmap.fr/it/map/estate2k24_1079843?scaleControl=false&miniMap=false&scrollWheelZoom=true&zoomControl=true&editMode=disabled&moreControl=true&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=true&onLoadPanel=none&captionBar=false&captionMenus=true&editinosmControl=false'>
                                Visualizza a schermo intero
                            </a>
                        </p>";
                        $i++;
                        echo $card;
                    }
                }
            ?>
        </div>
        <script>
            function openMap(i){
                var map = document.getElementById(i);
                map.style.display = 'flex';
            }
            function closeMap(i){
                var map = document.getElementById(i);
                map.style.display = 'none';
            }
        </script>
    </body>
</html>