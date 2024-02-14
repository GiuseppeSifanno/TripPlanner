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
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </head>
    <body onload=SetFoto()>
        <header>
            <div class="container-fluid">
                <nav class="navbar navbar-expand-sm" id="navbar">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Nome del sito</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                            <ul class="navbar-nav mb-2 mb-lg-0 column-gap-5">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Crea il tuo viaggio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link img-thumbnail" href="#">
                                        <img src="/TripPlanner/Icone/account_circle_FILL0_wght400_GRAD0_opsz24.svg"
                                            class="text-decoration-none">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <script type="text/javascript">
            function SetFoto(){
                const xhttp = new XMLHttpRequest();
                xhttp.onload =function() {
                    let img = xhttp.responseText;
                    document.body.style.backgroundImage = "url(/TripPlanner/Sfondi/".concat(img)+")";
                    console.log("/TripPlanner/Sfondi/".concat(img));
                }
                xhttp.open('POST', '/TripPlanner/Server/getImmagine.php');
                xhttp.send();
            }
        </script>
    </body>
</html>