<?php
   require_once (dirname(__FILE__)."/../../util/auth_check.php");
   if(isLogged()) {
      if($_SESSION["cod_permesso"] != 3) {
         header("Location:../../index.php");
      }
   }
   else {
      header("Location:../login.php");
   }

   require_once (dirname(__FILE__)."/../../util/dbconnect.php");
   require_once (dirname(__FILE__)."/../../util/token_gen.php");
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
      <link rel="stylesheet" href="../../css/admin_navbar.css">

      <title>Partecipanti</title>

      <style>
      @media print {
         .noprint {
            display: none;
         }
      }
   </style>

   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <a class="navbar-brand" href="../index.php">Admin</a>
         <div align="right">
            <a id="nav_options" href="../index.php">Dashboard</a>
            <a id="nav_options" href="view.php">Open Day</a>
            <a id="nav_options" href="../labo/view.php">Laboratori</a>
            <a id="nav_options" href="../devices/view.php">Dispositivi</a>
            <a id="nav_options" href="../logout.php">Logout</a>
         </div>
      </nav>

      <section id="cover" class="min-vh-90">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Partecipanti</h1>

                     <?php
                        $id = "";
                        if(empty($_GET["id"]) && empty($_POST["id"])) {
                           die("<h3>Errore</h3>");
                        }
                        else {
                           if(!empty($_GET["id"])) { $id = htmlentities($_GET["id"]); }
                           else { $id = htmlentities($_POST["id"]); }
                        }

                        $conn = db_connect();
                        // Estrae i dati dell'Open Day
                        $sql = "SELECT * FROM visite WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();
                        $res = $stmt->fetch();

                        if(!empty($res)) {
                           $data = date("d/m/Y", strtotime($res["data_inizio"]));
                           $orario = date("H:i" ,strtotime($res["ora_inizio"])) . " - " . date("H:i" ,strtotime($res["ora_fine"]));
                           echo "<p>$data | $orario</p>";
                        }
                     ?>
                     <br>

                     <div id="tab1" class="table-responsive" align="center">
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                           <table class="table table-bordered">
                              <tr style="text-align:center;">
                                 <th></th> <th>Cognome</th> <th>Nome</th> <th>Email</th> <th>Dispositivo</th>
                              </tr>
                              <?php
                                 try {
                                    $conn = db_connect();

                                    // Estrae tutti i partecipanti dell'Open Day associandoli eventualmente al dispositivo
                                    $sql = "SELECT cod_utente, email, nome, cognome, mac_address
                                            FROM (utenti INNER JOIN prenotazioni ON (cod_utente = utenti.id))
                                                 LEFT OUTER JOIN dispositivi ON (cod_dispositivo = dispositivi.id)
                                            WHERE cod_visita = :cod_visita";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(":cod_visita", $id, PDO::PARAM_INT);
                                    $stmt->execute();

                                    $res = $stmt->fetchAll();
                                    foreach($res as $row) {
                                       $nome = $row["nome"];
                                       $cognome = $row["cognome"];
                                       $email = $row["email"];
                                       $id_user = $row["cod_utente"];
                                       $dispositivo = $row["mac_address"];
                                       echo "<tr style='text-align:center;'>";
                                       echo "<td><input type='checkbox' name='choose[$id_user]'></td><td>$cognome</td> <td>$nome</td> <td>$email</td> <td>$dispositivo</td>";
                                       echo "</tr>";
                                    }
                                 } catch (PDOException $e) {
                                    echo $e->getMessage();
                                 }

                              ?>
                           </table>
                           <input type="hidden" name="id" value="<?php echo htmlentities($id) ?>">
                           <input type="submit" name="submit_selected" value="Genera credenziali a selezionati">
                           <input type="submit" name="submit_all" value="Genera credenziali a tutti">
                        </form>
                     </div>

                     <div id="tab2" style="display: none;" class="table-responsive" align="center">
                        <table class="table table-bordered">
                           <tr style="text-align:center;">
                              <th rowspan="2"><br>Cognome</th> <th rowspan="2"><br>Nome</th> <th rowspan="2"><br>Email</th> <th rowspan="2"><br>Dispositivo</th> <th colspan="2">Accesso visita</th>
                           </tr>
                           <tr style="text-align:center;">
                              <th>Username</th> <th>Password</th>
                           </tr>

                           <?php
                              if(isset($_POST["submit_all"]) || isset($_POST["submit_selected"])) {
                                 $selected = false;
                                 if(isset($_POST["submit_selected"])) {
                                    $selected = true;
                                 }

                                 try {
                                    $conn = db_connect();
                                    // Estrae tutti i partecipanti dell'Open Day associandoli eventualmente al dispositivo
                                    $sql = "SELECT prenotazioni.id AS id_p, cod_utente, email, nome, cognome, mac_address
                                            FROM (utenti INNER JOIN prenotazioni ON (cod_utente = utenti.id))
                                                 LEFT OUTER JOIN dispositivi ON (cod_dispositivo = dispositivi.id)
                                            WHERE cod_visita = :cod_visita";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(":cod_visita", $_POST["id"], PDO::PARAM_INT);
                                    $stmt->execute();

                                    $res = $stmt->fetchAll();
                                    foreach($res as $row) {
                                       // Se la generazione è per selezione, verifica che l'utente sia stato selezionato
                                       if($selected) {
                                          if(!isset($_POST["choose"][$row["cod_utente"]])) {
                                             continue;
                                          }
                                       }
                                       $nome = $row["nome"];
                                       $cognome = $row["cognome"];
                                       $email = $row["email"];
                                       $dispositivo = $row["mac_address"];
                                       $id_pren = $row["id_p"];

                                       // -------------------------------------------------------------
                                       // GENERAZIONE CREDENZIALI
                                       // -------------------------------------------------------------
                                       $username = "openday_$id_pren";
                                       $password = token_gen(8, "abcdefghijklmnopqrstuvwxyz"); // Password di 8 caratteri e solo minuscole
                                       $psw_hash = password_hash($password, PASSWORD_DEFAULT);
                                       // **************************************************************


                                       // Inserimento credenziali su DB
                                       $sql = "UPDATE prenotazioni SET username = :username, psw = :psw WHERE id = :id";
                                       $stmt = $conn->prepare($sql);
                                       $stmt->bindParam(":id", $id_pren, PDO::PARAM_INT);
                                       $stmt->bindParam(":username", $username, PDO::PARAM_STR, 100);
                                       $stmt->bindParam(":psw", $psw_hash, PDO::PARAM_STR, 60);
                                       $stmt->execute();

                                       echo "<tr style='text-align:center;'>";
                                       echo "<td>$cognome</td> <td>$nome</td> <td>$email</td> <td>$dispositivo</td> <td>$username</td> <td>$password</td>";
                                       echo "</tr>";
                                    }
                                    ?>
                                       </table>

                                       <script>
                                          document.getElementById('tab1').style = 'display: none;';
                                          document.getElementById('tab2').style = 'display: block;';
                                       </script>
                                    <?php

                                 }
                                 catch (PDOException $e) {
                                    echo $e->getMessage();
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
