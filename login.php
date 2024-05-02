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
            include "./Server/accesso.php";
        ?>
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
        <div class="container rounded-2 flex-lg-wrap" id="ctn-login" style="width: 600px;">
            <div id="alert" style="visibility: hidden; width: 100%;">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: inherit;">
                    <div id="messaggio"></div>
                    <button type="button" style="box-shadow: none;" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" class="form-control shadow-lg border-1" id="Form" style="min-width: 500px;">
                <div class="form-group">
                    <label for="Email" class="form-label label">Inserisci la tua email</label>
                    <input type="email" class="form-control" name="Email" id="Email" value="<?php if($_SESSION['Email']) echo $_SESSION['Email'] ?>" 
                        placeholder="email@example.com" maxlength="60" required>
                </div>
                <div class="form-group my-3">
                    <label for="Password" class="form-label label">Inserisci la tua password</label>
                    <input type="password" class="form-control" name="Password" id="Password" placeholder="Password"
                        aria-describedby="passwordHelpBlock" minlength="8" maxlength="30" required
                        pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$">
                </div>
                <div class="btn-group my-3 col-12 column-gap-2" role="group">
                    <input type="submit" class="btn btn-sm btn-success rounded-1 w-50" name="Submit" id="Submit" value="Invia">
                    <input type="reset" class="btn btn-sm btn-danger rounded-1 w-50" id="Reset" value="Cancella"
                        style="margin: 0;">
                </div>
                <div style="text-align: end;">
                    <p style="margin-bottom: 0;">Oppure <a href="register.php">registrati</a></p>
                </div>
            </form>

            <?php
                if(isset($_POST['Submit'])){
                    $_SESSION['Email'] = $_POST['Email'];
                    $msg = Accedi();
                    if($msg === true) header('Location: /TripPlanner/areaPrivata/index.php'); 
                    else {
                        $alert = "<script>document.getElementById('alert').style.visibility = 'visible';";
                        $alert .= "document.getElementById('messaggio').innerHTML = \"".$msg."\";</script>";
                        echo $alert;
                    }
                }
            ?>
        </div>
    </body>
</html>