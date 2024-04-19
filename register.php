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
                ob_start();
                session_start();
                if(isset($_SESSION)) header('Location: /areaPrivata/index.php?SID='.session_id());
                include "./Server/registrazione.php"; 
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
            <?php 
                if(isset($_POST['Submit'])){
                    $_SESSION['Nome'] = $_POST['Nome'];
                    $_SESSION['Cognome'] = $_POST['Cognome'];
                    $_SESSION['Email'] = $_POST['Email'];
                }
            ?>
            <div class="container rounded-2 flex-lg-wrap" id="ctn-register">
                <div id="alert" style="visibility: hidden;">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div id="messaggio"></div>
                        <button type="button" style="box-shadow: none;" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-control shadow-lg border-1" id="Form" oninput=Controlla()>
                    <fieldset>
                        <div class="form-group row my-1">
                            <div class="col">
                                <label for="Nome" class="form-label label">Nome</label>
                                <input type="text" id="Nome" name="Nome" class="form-control" placeholder="Inserisci il nome"
                                    required maxlength="30" value="<?php if($_SESSION['Nome']) echo $_SESSION['Nome'] ?>">
                            </div>

                            <div class="col">
                                <label for="Cognome" class="form-label label">Cognome</label>
                                <input type="text" id="Cognome" name="Cognome" class="form-control"
                                    placeholder="Inserisci il cognome" required maxlength="30" value="<?php if($_SESSION['Cognome']) echo $_SESSION['Cognome'] ?>">
                            </div>
                        </div>

                        <div class="form-group my-3">
                            <label for="Email" class="form-label label">Inserisci la tua email</label>
                            <input type="email" class="form-control" name="Email" id="Email" placeholder="email@example.com"
                                required maxlength="60" value="<?php if($_SESSION['Email']) echo $_SESSION['Email'] ?>">
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="form-group my-1">
                            <label for="Password" class="form-label label">Crea una password</label>
                            <input type="password" class="form-control" name="Password" id="Password" placeholder="Password"
                                aria-describedby="passwordHelpBlock" onkeyup="ValidaPassword()" required
                                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" maxlength="30" minlength="8">

                            <p id="al" class="my-1" style="height: 15px;"></p>
                            <div class="progress my-2" id="Progress-bar" role="progressbar" aria-label="ProgressBar"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" id="bar"></div>
                            </div>

                            <div id="passwordHelpBlock" class="form-text">
                                <p style="color: whitesmoke;">
                                    La password deve essere di almeno 8 caratteri contenenti almeno una lettera minuscola e una
                                    maiuscola, un numero ed un simbolo
                                </p>
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <label for="PasswordRipetuta" class="form-label label">Ripeti la tua password</label>
                            <input type="password" class="form-control" name="PasswordRipetuta" id="PasswordRipetuta"
                                placeholder="Ripeti la tua password" required maxlength="30" minlength="8">
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="btn-group my-2 col-12 column-gap-2" role="group">
                            <input type="submit" class="btn btn-sm btn-success rounded-1 w-50" name="Submit" id="Submit" value="Invia" disabled>
                            <input type="reset" class="btn btn-sm btn-danger rounded-1 w-50" id="Reset" value="Cancella" style="margin: 0;">
                        </div>
                    </fieldset>

                    <div style="text-align: end;">
                        <p style="margin-bottom: 0;">Oppure <a href="login.php">accedi</a></p>
                    </div>
                    <?php 
                    if(isset($_POST['Submit'])){
                        $msg = Registra();
                        if($msg === true) {
                            header('Location: /TripPlanner/areaPrivata/index.php?SID='.session_id()); 
                            ob_end_flush();
                        } else {
                            $alert = "<script>document.getElementById('alert').style.visibility = 'visible';";
                            $alert .= "document.getElementById('messaggio').innerHTML = \"".$msg."\";</script>";
                            echo $alert;
                        }
                    }
                ?>
                </form>
            </div>

            <script>
                let button = document.getElementById("Submit");
                var nome = document.getElementById("Nome");
                var cognome = document.getElementById("Cognome");
                var email = document.getElementById("Email");

                var passwordRipetuta = document.getElementById("PasswordRipetuta");

                function Controlla() {
                    console.log("Controlla");

                    //true se non stati rispettati dei campi (blocco attivo sul pulsante)
                    //false altrimenti (blocco disattivato sul pulsante)
                    var sem = false;

                    console.log("Valore di sem: ", sem);

                    //i criteri usati qui devono essere rispettati nel DB
                    if (nome.value.length < 1 || nome.value.length > 30) {
                        nome.classList.add("is-invalid");
                        sem = true;
                    }
                    else {
                        nome.classList.remove("is-invalid");
                        nome.classList.add("is-valid");
                        sem = false;
                    }

                    if (cognome.value.length < 1 || cognome.value.length > 30) {
                        cognome.classList.add("is-invalid");
                        sem = true;
                    }
                    else {
                        cognome.classList.remove("is-invalid");
                        cognome.classList.add("is-valid");
                        sem = false;
                    }

                    //controllo da sistemare secondo un pattern
                    var password = document.getElementById("Password");
                    if (password.value.length < 8 || (password.value != passwordRipetuta.value) || password.value.length > 30) {
                        password.classList.add("is-invalid");
                        passwordRipetuta.classList.add("is-invalid");
                        sem = true;
                    }
                    else {
                        password.classList.remove("is-invalid");
                        passwordRipetuta.classList.remove("is-invalid");

                        passwordRipetuta.classList.add("is-valid");
                        password.classList.add("is-valid");
                        sem = false;
                    }

                    console.log("Valore di sem: ", sem);
                    if (sem) button.disabled = true;
                    else button.disabled = false;
                }

                function ValidaPassword() {
                    var password = document.getElementById("Password").value;
                    var x = 0;
                    var bar = document.getElementById("bar");
                    var al = document.getElementById("al");

                    //numbers
                    var check = /[0-9]/;
                    if (check.test(password)) {
                        x += 20;
                    }
                    //lowercase
                    var check2 = /[a-z]/;
                    if (check2.test(password)) {
                        x += 20;
                    }
                    //uppercase
                    var check3 = /[A-Z]/;
                    if (check3.test(password)) {
                        x += 20;
                    }

                    //symbols
                    var check4 = /[$-/:-?{-~!"^_`\[\]]/;
                    if (check4.test(password)) {
                        x += 20;
                    }

                    // result
                    if (password.length >= 10) {
                        x += + 20;
                    }
                    bar.style.width = x + "%";

                    if (x == 100) {
                        bar.style.backgroundColor = "green";
                        al.innerHTML = "Molto forte";
                    }

                    if (x > 40 && x <= 80) {
                        bar.style.backgroundColor = "green";
                        al.innerHTML = "Forte";
                    }
                    if (x <= 40 && x > 20) {
                        bar.style.backgroundColor = "yellow";

                        al.innerHTML = "Buona";
                    }
                    if (x <= 20) {
                        bar.style.backgroundColor = "red";
                        al.innerHTML = "Debole";
                    }
                    if (password.length == 0) {
                        x == 0;
                        al.innerHTML = "";
                    }
                    //white spaces
                    var check5 = /\s\S/;
                    if (check5.test(password)) {
                        al.innerHTML = "La password non deve contenere spazi!";
                        bar.style.backgroundColor = "red";
                    }
                }
            </script>
        </body>
    </html>