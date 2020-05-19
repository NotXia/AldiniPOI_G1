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

   require_once (dirname(__FILE__)."/../util/dbconnect.php");
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

      <title>Prenotazioni</title>
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
                  <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Prenotazioni</h1><br>

                     <?php
                        try {
                           $conn = db_connect();
                           $sql = "SELECT prenotazioni.id AS id_pren, data_inizio, ora_inizio, ora_fine, cod_dispositivo
                           FROM prenotazioni, visite
                           WHERE prenotazioni.cod_visita = visite.id AND
                           cod_utente = :cod_utente";
                           $stmt = $conn->prepare($sql);
                           $stmt->bindParam(":cod_utente", $_SESSION["id"], PDO::PARAM_INT);
                           $stmt->execute();

                           $res = $stmt->fetchAll();
                        } catch (PDOException $e) {
                           echo "<p id='error'>Si è verificato un errore</p>";
                        }

                        if(!empty($res)) {
                           ?>
                              <div class="table-responsive-lg" align="center">
                                 <table class="table table-bordered">
                                    <tr style="text-align:center;">
                                       <th>Data</th> <th>Ora</th> <th>Dispositivo</th>
                                    </tr>
                                    <?php
                                       foreach($res as $row) {
                                          $id = $row["id_pren"];
                                          $data = date("d/m/Y", strtotime($row["data_inizio"]));
                                          $orario = date("H:i", strtotime($row["ora_inizio"])) . " - " . date("H:i", strtotime($row["ora_fine"]));
                                          $dispositivo = !empty($row["cod_dispositivo"]) ? "&#10003;" : " ";
                                          echo "<tr style='text-align:center;'>";
                                          echo "<td>$data</td> <td>$orario</td> <td>$dispositivo</td> <td><a href='delete.php?id=$id'>Annulla</a></td>";
                                          echo "</tr>";
                                       }
                                    ?>
                                 </table>
                              </div>
                           <?php
                        }
                        else {
                           ?>
                              <h3>Non hai nessuna prenotazione :(</h3>
                           <?php
                        }
                     ?>

                     <br>
                     <form action="add.php" method="POST">
                        <input type="submit" class="btn btn-primary btn-lg" name="add" value="Aggiungi">
                     </form>

                  </div>
               </div>
            </div>
         </div>
      </section>


   </body>

</html>
