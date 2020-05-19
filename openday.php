<?php
   session_start();

   require_once (dirname(__FILE__)."/util/auth_check.php");
   require_once (dirname(__FILE__)."/util/openday_check.php");
   if(!isOpenday()) {
      header("Location:index.php");
      exit;
   }
   else if(isLogged()) {
      if(isset($_SESSION["is_openday"])) {
         header("Location:index.php");
      }
   }

   require_once (dirname(__FILE__)."/util/dbconnect.php");
   require_once (dirname(__FILE__)."/util/config.php");
   require_once (dirname(__FILE__)."/util/token_gen.php");
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
      <link rel="stylesheet" href="css/navbar.css">
      <link rel="stylesheet" href="css/form_table.css">

      <title>Accedi</title>

      <style>
         p {
            margin: 0 0 0;
         }
      </style>
   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <div class="navbar-brand">
            <a class="navbar-brand nav_nopadding" href="index.php">
               <img class="nav_logo" src="res/logo.png" alt="AV Logo">
               Aldini Valeriani
            </a>
         </div>
         <div align="right">
            <?php
            if(isOpenday()) {
               ?><a class="nav_options" href="openday.php">Open Day</a><?php
            }
            ?>
            <a class="nav_options" href="./map">Visita</a>
            <?php
            if(isLogged()) {
               ?>
               <a class="nav_options" href="./prenotazioni">Prenota</a>
               <a class="nav_options" href="./logout.php">Esci</a>
               <?php
            }
            else {
               ?>
               <a class="nav_options" href="./login.php">Accedi</a>
               <a class="nav_options" href="./register.php">Registrati</a>
               <?php
            }
            ?>
         </div>
      </nav>

      <section id="cover" class="min-vh-100">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2 text-truncate">Open Day</h1>
                     <p class="lead">Effettua il login con i dati che ti sono stati forniti.</p>
                     <br>

                     <div class="px-2">
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                           <p>Username</p>
                           <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required></td>
                           <br><br>
                           <p>Password</p>
                           <input id="password" type="password" name="password" required>
                           <br><br>
                           <input type="submit" name="submit" value="Accedi">
                           <br>
                        </form>
                     </div>

                     <?php

                     // Verifica che tutti i campi siano impostati
                     if(isset($_POST["submit"]) && isset($_POST["username"]) && isset($_POST["password"])) {

                        try {
                           $conn = db_connect();

                           // ----------------------------------------------------------------
                           // Sanitizzazione input
                           // ----------------------------------------------------------------
                           $user = $_POST["username"];
                           $pswd = $_POST["password"];
                           // ****************************************************************


                           // ----------------------------------------------------------------
                           // Estrae le credenziali facendo un controllo su data e ora
                           // ----------------------------------------------------------------
                           $sql = "SELECT prenotazioni.id, cod_permesso, ora_inizio, ora_fine, psw
                           FROM prenotazioni, visite
                           WHERE cod_visita = visite.id AND
                                 username = :username AND
                                 DATE(NOW()) = data_inizio AND
                                 TIME(NOW()) BETWEEN DATE_ADD(ora_inizio, INTERVAL $OFFSET_BEFORE_OPENDAY MINUTE) AND DATE_ADD(ora_fine, INTERVAL $OFFSET_AFTER_OPENDAY MINUTE)";
                           $stmt = $conn->prepare($sql);
                           $stmt->bindParam(":username", $user, PDO::PARAM_STR, 100);
                           $stmt->execute();
                           $res = $stmt->fetch();
                           // ****************************************************************

                           if(!empty($res["id"])) {

                              // Verifica credenziali
                              if(password_verify($pswd, $res["psw"])) {

                                 // Esegue il logout se l'utente è già autenticato
                                 session_unset();
                                 setcookie("user", "", time()-1, "/");

                                 // Inizializzazione parametri della sessione
                                 $_SESSION["id"] = $res["id"];
                                 $_SESSION["cod_permesso"] = $res["cod_permesso"];
                                 $_SESSION["ora_inizio"] = $res["ora_inizio"];
                                 $_SESSION["ora_fine"] = $res["ora_fine"];
                                 $_SESSION["is_openday"] = true;

                                 header("Location:./map");
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

                     ?>
                  </div>
               </div>
            </div>
         </div>
      </section>

   </body>
</html>
