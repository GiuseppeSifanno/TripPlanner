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
                /*
                session_start();
                if($_SESSION['consenti'] == false){
                    echo "<script>alert('Accesso non consentito')</script>";
                    header('refresh:5; url=/TripPlanner/index.php');
                };
                */
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
    }
    </style>
</head>

<body>
    <?php include_once "navbar.html"; ?>
    <div class="container-md" id="ctn-parent">
        <?php
                    //se non sono presenti viaggi allora si visualizzerà una pagina differente altrimenti
                    //verranno generate le card
                    if($viaggi = hasViaggi()) {
                        echo creaCardViaggi($viaggi); 
                    }
                    //else include 'noViaggi.php';
                    function hasViaggi(){
                        $viaggi = "{\"viaggi\": [{\"tappe\": [\"Paris, Ile-de-France, Metropolitan France, France\",\"Bitonto, Bari, Apulia, 70032, Italy\"],\"nomeViaggio\": \"Il viaggio\"},{\"tappe\": [\"Paris, Ile-de-France, Metropolitan France, France\",\"Bitonto, Bari, Apulia, 70032, Italy\"],\"nomeViaggio\": \"Il viaggio\"},{\"tappe\": [\"Paris, Ile-de-France, Metropolitan France, France\",\"Bitonto, Bari, Apulia, 70032, Italy\"],\"nomeViaggio\": \"Il viaggio\"},{\"tappe\": [\"Paris, Ile-de-France, Metropolitan France, France\",\"Bitonto, Bari, Apulia, 70032, Italy\"],\"nomeViaggio\": \"Il viaggio\"}],\"hash\": \"75df1d06fc54e93b5f12ee310b9cd80b\"}";
                        $json = json_decode($viaggi, true, 512, JSON_HEX_APOS | JSON_PARTIAL_OUTPUT_ON_ERROR);
                        return $json;
                        /*
                        session_start();
                        include_once "/TripPlanner/Server/credenziali.php";
                        $conn = new mysqli($host, $username, $password, $db_nome);
                        if($conn == false) return "Errore nella connessione. Codice: ".mysqli_connect_error();
                        $mail = $conn -> real_escape_string($_SESSION['Email']);
                        $sql = "SELECT Hash FROM Utente WHERE Email = '$mail';";
                        if($hash = $conn -> query($sql)) {
                            //se ci sono dei valori ritornati allora ritorniamo la lista dei viaggi decodificata da JSON a PHP
                            if( ($viaggi = json_decode(doGet($hash), true)) != null) return $viaggi;
                            else return false; 
                        }
                        else return false;
                        */
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
                            echo count($viaggi);
                            $viaggiArr = $viaggi['viaggi'];
                            //recuperiamo il viaggio i-esimo  in lista
                            $viaggio = $viaggiArr[$i];
                            //print_r($viaggio);
                            //print_r($viaggio);

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
                                print_r($tappa);
                                //aagiunta tappa
                                $card .= "<li>$tappa</li>";
                                $nTappe++;
                            }
                            $card .= "</ul></div></div>";
                            $card .= "<div class='p-3' id='comandi'><button type='button' class='btn btn-outline p-2' data-bs-toggle='offcanvas' data-bs-target='#offcanvasTop' aria-controls='offcanvasTop'><img src='../Icone/expand-more.svg' alt='Mostra' role='button'></button></div>";
                            $card .= "</div>";
                            $card .= "<div class='offcanvas offcanvas-top' data-bs-backdrop='static' tabindex='-1' id='offcanvasTop' aria-labelledby='offcanvasTopLabel'>
                            <div class='offcanvas-header'>
                                <h5 class='offcanvas-title' id='offcanvasTopLabel'>Offcanvas top</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
                            </div>
                            <div class='offcanvas-body'>
                                <iframe width='100%' height='300px' frameborder='0' allowfullscreen allow='geolocation'
                                src='//umap.openstreetmap.fr/it/map/prova2_1071523?scaleControl=false&miniMap=false&scrollWheelZoom=true&zoomControl=true&editMode=disabled&moreControl=true&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=true&onLoadPanel=none&captionBar=false&captionMenus=true'></iframe>
                                <p>
                                <!-- cambiare il link all'src e href in maniera dinamica-->
                                <a
                                    href='//umap.openstreetmap.fr/it/map/prova2_1071523?scaleControl=false&miniMap=false&scrollWheelZoom=true&zoomControl=true&editMode=disabled&moreControl=true&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=true&onLoadPanel=none&captionBar=false&captionMenus=true'>Visualizza
                                    a schermo intero</a></p></div></div>";
                            $i++;
                        }while($i < count($viaggi));
                        return $card;
                    }
                ?>
    </div>
</body>

</html>