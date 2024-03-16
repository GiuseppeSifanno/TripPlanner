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
            <!-- <?php 
                session_start();
                if(!isset($_SESSION['Consenti']) && $_SESSION['Consenti']){
                    echo "<script>alert('Accesso non consentito')</script>";
                    header('Location: /TripPlanner/index.php');
                };
            ?> -->  
            
            <script>
                function setFoto(){
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload =function() {
                        let img = "url(/TripPlanner/Sfondi/".concat(xhttp.responseText);
                        document.body.style.backgroundImage = "linear-gradient(to right, rgba(12, 12, 12, 0.782), rgba(53, 50, 50, 0.327)),".concat(img);
                        document.body.id = "sfondo";
                    }
                    //si puo nascondere il percorso
                    xhttp.open('POST', "/TripPlanner/Server/getImmagine.php");
                    xhttp.send();
                }
                setFoto();
            </script>
        </head>

        <body>
            <?php include "./navbar.html"?>

            <div class="container-fluid">
                <div class="container rounded-2 flex-lg-wrap" id="ctn-creaViaggio">
                    <div id="alert" style="visibility: hidden;">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div id="messaggio"></div>
                            <button type="button" style="box-shadow: none;" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-control shadow-lg border-1" id="Form">
                        <fieldset>
                            <div class="btn-group my-2 col-12 column-gap-2" role="group">
                                <input type="submit" class="btn btn-sm btn-success rounded-1 w-50" name="Submit" id="Submit" value="Crea">
                                <input type="reset" class="btn btn-sm btn-danger rounded-1 w-50" id="Reset" value="Cancella" style="margin: 0;">
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <label for=""></label>
                            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">Help text</small>
                        </div>

                        <?php 
                            if(isset($_POST['Submit'])){
                                $msg = Registra();
                                if($msg === true) {
                                    header('Location: /areaPrivata/index.php?SID='.session_id());
                                } else {
                                    $alert = "<script>document.getElementById('alert').style.visibility = 'visible';";
                                    $alert .= "document.getElementById('messaggio').innerHTML = \"".$msg."\";</script>";
                                    echo $alert;
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>
            <script>
                const testo = document.getElementById("search");
                testo.oninput = function () {
                    //console.log(testo.value);
                    if(isNaN(testo.value) && testo.value !== ""){
                        //console.log(testo.value);
                        const xhttp = new XMLHttpRequest();
                        xhttp.onload = function() {
                            var xml = xhttp.responseText;
                            var parser = new DOMParser();
                            //console.log(studenti);
                            VisualizzaStudenti(parser.parseFromString(xml, "text/html"));
                        }

                        xhttp.open('GET', "Server.php?parola="+testo.value);
                        xhttp.send();
                    }
                };
            </script>
        </body>
    </html>