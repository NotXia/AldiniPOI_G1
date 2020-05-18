<?php
   require_once (dirname(__FILE__)."/../util/auth_check.php");
   if(isLogged()) {
      header("Location:index.php");
   }

   require_once (dirname(__FILE__)."/../util/dbconnect.php");
   require_once (dirname(__FILE__)."/../util/mailer.php");
   require_once (dirname(__FILE__)."/../util/mail_gen/reset_password.php");
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
      <link rel="stylesheet" href="../css/navbar.css">

      <title>Password dimenticata</title>
   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <div class="navbar-brand">
            <a class="navbar-brand nav_nopadding" href="../index.php">
               <img class="nav_logo" src="../res/logo.png" alt="AV Logo">
               Aldini Valeriani
            </a>
         </div>
         <div align="right">
            <a class="nav_options" href="../map">Visita</a>
            <?php
            if(isLogged()) {
               ?>
               <a class="nav_options" href="../prenotazioni">Prenota</a>
               <a class="nav_options" href="../logout.php">Esci</a>
               <?php
            }
            else {
               ?>
               <a class="nav_options" href="../login.php">Accedi</a>
               <a class="nav_options" href="../register.php">Registrati</a>
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
                     <h1 class="display-4 py-2 text-truncate">Reset Password</h1>
                     <p class="lead">Reimposta la tua password</p>
                     <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="email" name="email" placeholder="Email">
                        <br><br>
                        <input type="submit" name="request" value="Invia richiesta">
                     </form>
                     <br>
                  </div>
               </div>
            </div>
         </div>
      </section>

   </body>
</html>

<?php

   if(isset($_POST["request"])) {

      try {
         // Estrae i dati dell'utente a cui mandare la mail
         $conn = db_connect();
         $sql = "SELECT id, nome, cognome, email, data_creazione FROM utenti WHERE email = :email";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR, 100);
         $stmt->execute();

         $res = $stmt->fetch();
         if(isset($res["email"])) { // Se la query ha restituito una riga

            $conn->beginTransaction();

            // Aggiorna la data di modifica password
            $sql = "UPDATE utenti SET ultima_modifica_psw = NOW() WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $res["id"], PDO::PARAM_INT);
            $stmt->execute();

            // Estrae la data appena inserita
            $sql = "SELECT ultima_modifica_psw FROM utenti WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $res["id"], PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit();
            $now = $stmt->fetch()["ultima_modifica_psw"];

            // Creazione e invio mail
            $email_format = reset_psw_mail($res["id"], $res["nome"], $res["cognome"], $res["email"], $res["data_creazione"], $now);
            mailTo($res["email"], "POI - Cambio password", $email_format);

            echo "<p id='message'>Ti abbiamo inviato una mail con la procedura di cambio password</p>";
         }
         else {
            echo "<p id='error'>Non siamo riusciti a trovare un account associato a questa mail</p>";
         }
      }
      catch(PDOException $e) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
         $conn->rollback();
      }
   }

?>
