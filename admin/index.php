<?php
   require_once (dirname(__FILE__)."/../util/auth_check.php");
   if(isLogged()) {
      if($_SESSION["cod_permesso"] != 3) {
         header("Location:../index.php");
      }
   }
   else {
      header("Location:login.php");
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
      <link rel="stylesheet" href="../css/admin_navbar.css">

      <title>Dashboard</title>

      <style>
         .border {
            border: 1px solid;
            border-radius: 15px;
            padding: 10px;
         }
      </style>

   </head>

   <body>
      <nav class="navbar navbar-dark bg-primary">
         <a class="navbar-brand" href="#">Admin</a>
         <div align="right">
            <a id="nav_options" href="index.php">Dashboard</a>
            <a id="nav_options" href="openday/view.php">Open Day</a>
            <a id="nav_options" href="labo/view.php">Laboratori</a>
            <a id="nav_options" href="devices/view.php">Dispositivi</a>
            <a id="nav_options" href="logout.php">Logout</a>
         </div>
      </nav>

      <section id="cover" class="min-vh-90">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Dashboard</h1><br>

                     <div class="border">

                        <h4>OGGI</h4>
                        <?php
                           try {
                              $conn = db_connect();
                              $sql = "SELECT * FROM visite WHERE data_inizio = DATE(NOW())";
                              $stmt = $conn->prepare($sql);
                              $stmt->execute();
                              $res = $stmt->fetchAll();

                              if(!empty($res)) {
                                 foreach($res as $row) {
                                    $orario = date("H:i" ,strtotime($row["ora_inizio"])) . " - " . date("H:i" ,strtotime($row["ora_fine"]));
                                    $cod_visita = $row["id"];

                                    $sql = "SELECT COUNT(*) AS tot FROM prenotazioni WHERE cod_visita = $cod_visita";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $res_count = $stmt->fetch()["tot"];

                                    echo "<p style='margin: 0'>$orario ($res_count partecipanti)</p>";
                                 }
                              }
                              else {
                                 echo "<p style='margin: 0'>Non ci sono Open Day oggi</p>";
                              }
                           }
                           catch (PDOException $e) {
                              echo $e->getMessage();
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
