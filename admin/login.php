<?php
   session_start();

   require_once (dirname(__FILE__)."/../util/auth_check.php");
   if(isLogged()) {
      if($_SESSION["cod_permesso"] == 3) {
         // header("Location:index.php");
      }
      else {
         // header("Location:../index.php");
      }
   }
   else {
      // header("Location:login.php");
   }

   require_once (dirname(__FILE__)."/../util/dbconnect.php");
   require_once (dirname(__FILE__)."/../util/config.php");
   require_once (dirname(__FILE__)."/../util/token_gen.php");
?>

<!DOCTYPE html>
<html>
   <head>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
      <link rel="stylesheet" href="../css/admin_navbar.css">
      <link rel="stylesheet" href="../css/form_table.css">

      <title>Login admin</title>

   </head>

   <body>
      <nav class="navbar navbar-dark bg-primary">
         <a class="navbar-brand" href="#">Aldini Valeriani</a>
      </nav>

      <section id="cover" class="min-vh-90">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2 text-truncate">Admin</h1>

                     <div class="px-2">
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                           <p style="margin: 0 0 0;">Email</p>
                           <input type="email" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>" required></td>
                           <br>
                           <br>
                           <p style="margin: 0 0 0;">Password</p>
                           <input id="password" type="password" name="password" required>
                           <br><br>
                           <input type="checkbox" name="rememberme" value=""> Ricordami
                           <br><br>
                           <input type="submit" name="submit" value="Accedi">
                           <br>
                        </form>

<?php

   // Verifica che tutti i campi siano impostati
   if(isset($_POST["submit"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {

      // Verifica che la mail inserita sia in un formato corretto
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
         echo "<p id='error'>La mail inserita non è valida</p>";
      }
      else {
         try {
            $conn = db_connect();

            // ----------------------------------------------------------------
            // Sanitizzazione input
            // ----------------------------------------------------------------
            $email = strtolower(trim($_POST["email"]));
            $pswd = $_POST["password"];
            // ****************************************************************


            // ----------------------------------------------------------------
            // Controlla se l'email inserita è già presente
            // ----------------------------------------------------------------
            $sql = "SELECT id, nome, cognome, email, psw, cod_permesso
                    FROM utenti
                    WHERE email = :email AND
                          cod_permesso = 3";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
            $stmt->execute();
            $res = $stmt->fetch();
            // ****************************************************************

            if(!empty($res["id"])) {

               // Verifica credenziali
               if(password_verify($pswd, $res["psw"])) {
                  // Inizializzazione parametri della sessione
                  $_SESSION["id"] = $res["id"];
                  $_SESSION["nome"] = $res["nome"];
                  $_SESSION["cognome"] = $res["cognome"];
                  $_SESSION["email"] = $res["email"];
                  $_SESSION["cod_permesso"] = $res["cod_permesso"];

                  // ----------------------------------------------------------------
                  // Inizializza cookie per il token dell'utente (Se "Ricordami" è spuntato)
                  // ----------------------------------------------------------------
                  if(isset($_POST["rememberme"])) {
                     $token = token_gen(128);
                     $scadenza = time() + $TIMEOUT_REMEMBER_ME;
                     $token_hash = password_hash($token, PASSWORD_DEFAULT);
                     $ip = $_SERVER['REMOTE_ADDR'];
                     $web_agent = $_SERVER['HTTP_USER_AGENT'];
                     $id = $_SESSION["id"];
                     $giorno_scadenza = date("Y-m-d H:i:s", $scadenza);
                     $selector = "";

                     // Prova a generare il selector per 5 volte
                     // C'è la possibilità di una collisione tra i selector
                     $gen_times = 0;
                     $selector_created = false;
                     while($gen_times < 5) {
                        try {
                           $selector = token_gen(20);

                           $sql = "INSERT autenticazioni (selector, token, ip, web_agent, data_scadenza, cod_utente)
                           VALUES('$selector', '$token_hash', '$ip', '$web_agent', '$giorno_scadenza', $id)";
                           $stmt = $conn->prepare($sql);
                           $stmt->execute();
                           $selector_created = true;
                           break;
                        }
                        catch(PDOException $e) {
                           $gen_times++;
                        }
                     }

                     // Se non è stato possibile creare il selector
                     if(!$selector_created) {
                        die ("<p id='error'>Qualcosa è andato storto</p>");
                     }

                     setcookie("user", "$selector:$token", $scadenza, "/");
                  }
                  // ****************************************************************

                  header("Location:index.php");

               } // if(password_verify($pswd, $res["psw"]))
               else {
                  echo "<p id='error'>Credenziali non corrette</p>";
               }
            } // if(isset($res["id"]))
            else {
               echo "<p id='error'>Credenziali non corrette</p>";
            }
         }
         catch(PDOException $e) {
            echo "<p id='error'>Qualcosa è andato storto</p>";
         }
      }
   }

?>


                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </body>
</html>
