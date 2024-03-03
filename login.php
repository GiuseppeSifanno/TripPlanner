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
                include("./Server/accesso.php")
            ?>
    </head>

    <body onload=setFoto()>
        <div class="container rounded-2 flex-lg-wrap" id="ctn-login">
            <form action="./Server/accesso.php" method="post" class="form-control shadow-lg border-1"
                id="Form" target="_self">
                <div class="form-group">
                    <label for="Email" class="form-label label">Inserisci la tua email</label>
                    <input type="email" class="form-control" name="Email" id="Email" placeholder="email@example.com"
                        required>
                </div>
                <div class="form-group my-1">
                    <label for="Password" class="form-label label">Inserisci la tua password</label>
                    <input type="password" class="form-control" name="Password" id="Password" placeholder="Password"
                        aria-describedby="passwordHelpBlock" onkeyup="ValidaPassword()" required
                        pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$">
                <div class="btn-group my-3 col-12 column-gap-2" role="group">
                    <input type="submit" class="btn btn-sm btn-success rounded-1 w-50" id="Submit" value="Invia"
                        disabled>
                    <input type="reset" class="btn btn-sm btn-danger rounded-1 w-50" id="Reset" value="Cancella"
                        style="margin: 0;">
                </div>
                <div style="text-align: end;">
                    <p style="margin-bottom: 0;">Oppure <a href="register.php">registrati</a></p>
                </div>
            </form>
        </div>

        <script type="text/javascript">
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
        </script>
    </body>
</html>