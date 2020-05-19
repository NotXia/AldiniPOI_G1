<?php
   session_start();

   require_once (dirname(__FILE__)."/../util/auth_check.php");
   require_once (dirname(__FILE__)."/../util/openday_check.php");
   if(!isLogged()) {
      header("Location:../login.php");
      exit;
   }
   if(isset($_SESSION["is_openday"])) {
      header("Location:../index.php");
      exit;
   }
   if($_SESSION["mail_verif"] == 0) {
      header("Location:../mail.php");
      exit;
   }

   require_once (dirname(__FILE__)."/../util/dbconnect.php");
   require_once (dirname(__FILE__)."/../util/mailer.php");
   require_once (dirname(__FILE__)."/../util/mail_gen/booking_delete.php");
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

      <title>Elimina</title>

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
            <?php
            if(isOpenday()) {
               ?><a class="nav_options" href="../openday.php">Open Day</a><?php
            }
            ?>
            <a class="nav_options" href="../map">Visita</a>
            <?php
               if(isLogged()) {
                  ?>
                     <a class="nav_options" href="./index.php">Prenota</a>
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
                  <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 mx-auto text-center form p-4">
                     <h3>Confermi la cancellazione della prenotazione?</h3><br>

                     <div align="center">
                        <?php
                           if(empty($_GET["id"]) && empty($_POST["id"])) {
                              ?>
                              <h3>Errore</h3>
                              <?php
                           }
                           else {
                              if(!empty($_GET["id"])) { $id = htmlentities($_GET["id"]); }
                              else { $id = htmlentities($_POST["id"]); }
                              ?>
                              <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                                 <input type="hidden" name="id" value="<?php echo $id ?>">
                                 <input type="submit" name="confirm" value="Elimina">
                              </form>
                           <?php
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

<?php

   if(isset($_POST["confirm"])) {
      try {
         $conn = db_connect();

         $sql = "SELECT *
                 FROM prenotazioni, visite
                 WHERE cod_visita = visite.id AND
                       prenotazioni.id = :id";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $_POST["id"], PDO::PARAM_INT);
         $stmt->execute();
         $res = $stmt->fetch();

         // La prenotazione appartiene all'utente
         if($res["cod_utente"] == $_SESSION["id"]) {
            $conn->beginTransaction();

            $sql = "DELETE FROM prenotazioni WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $_POST["id"], PDO::PARAM_INT);
            $stmt->execute();

            $sql = "UPDATE visite SET posti_disponibili = posti_disponibili+1 WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $res["cod_visita"], PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit();

            mailTo(
               $_SESSION["email"],
               "POI - Cancellazione prenotazione",
               booking_delete_mail(
                  $_SESSION["nome"],
                  $_SESSION["cognome"],
                  date("d/m/Y", strtotime($res["data_inizio"])),
                  date("H:i", strtotime($res["ora_inizio"])),
                  date("H:i", strtotime($res["ora_fine"]))
               )
            );
         }

         header("Location:index.php");
      } catch (PDOException $e) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
         $conn->rollBack();
      }
   }

?>
