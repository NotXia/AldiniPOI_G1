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

      <title>Visualizza</title>

   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <a class="navbar-brand" href="../index.php">Aldini Valeriani</a>
         <div align="right">
            <a id="nav_options" href="../index.php">Dashboard</a>
            <a id="nav_options" href="view.php">Open Day</a>
            <a id="nav_options" href="../labo/view.php">Laboratori</a>
            <a id="nav_options" href="../logout.php">Logout</a>
         </div>
      </nav>

      <section id="cover" class="min-vh-90">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Open Day pianificati</h1><br>

                     <div class="table-responsive" align="center">
                        <table class="table table-bordered">
                           <tr style="text-align:center;">
                              <th>Data</th> <th>Orario</th> <th>Posti rimanenti</th>
                           </tr>
                           <?php
                              $conn = db_connect();

                              // Estrae tutti gli Open day da oggi in poi
                              $sql = "SELECT * FROM visite WHERE data_inizio >= DATE(NOW())";
                              $stmt = $conn->prepare($sql);
                              $stmt->execute();

                              $res = $stmt->fetchAll();
                              foreach($res as $row) {
                                 $id = $row["id"];
                                 $data = $row["data_inizio"];
                                 $ora_inizio = date("h:i", strtotime($row["ora_inizio"]));
                                 $ora_fine = date("h:i", strtotime($row["ora_fine"]));
                                 $posti = $row["posti_disponibili"];
                                 echo "<tr style='text-align:center;'>";
                                 echo "<td>$data</td> <td>$ora_inizio - $ora_fine</td> <td>$posti</td>";
                                 echo "<td><a href='modify.php?id=$id'>Modifica</a></td> <td><a href='delete.php?id=$id'>Elimina</a></td>";
                                 echo "</tr>";
                              }
                           ?>
                        </table>
                        <a href="add.php">Aggiungi</a>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </section>

   </body>
</html>
