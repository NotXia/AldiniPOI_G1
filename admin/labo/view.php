<?php
   ob_start();
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
      <link rel="stylesheet" href="../../css/navbar.css">
      <link rel="stylesheet" href="../../css/form_table.css">

      <title>Visualizza</title>

   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <div class="navbar-brand">
            <a class="navbar-brand nav_nopadding" href="../index.php">
               <img class="nav_logo" src="../../res/logo.png" alt="AV Logo">
               AV Admin
            </a>
         </div>
         <div align="right">
            <a class="nav_options" href="../index.php">Dashboard</a>
            <a class="nav_options" href="../openday/view.php">Open Day</a>
            <a class="nav_options" href="view.php">Laboratori</a>
            <a class="nav_options" href="../devices/view.php">Dispositivi</a>
            <a class="nav_options" href="../logout.php">Logout</a>
         </div>
      </nav>

      <section id="cover" class="min-vh-100">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Laboratori</h1><br>

                     <div class="table-responsive-lg" align="center">
                        <table class="table table-bordered">
                           <tr style="text-align:center;">
                              <th>Tag</th> <th>Nome</th> <th>Piano</th>
                              <th>Numero posti</th> <th>Numero PC</th>
                              <th>LIM</th> <th>Descrizione</th> <th>Id HTML</th>
                           </tr>
                           <?php

                           $conn = db_connect();
                           $sql = "SELECT * FROM laboratori";
                           $stmt = $conn->prepare($sql);
                           $stmt->execute();

                           $res = $stmt->fetchAll();
                           foreach($res as $row) {
                              $tag = $row["tag"];
                              $nome = $row["nome"];
                              $piano = $row["piano"];
                              $num_post = $row["num_posti"];
                              $num_pc = $row["num_pc"];
                              $lim = $row["presenza_lim"] ? "Si" : "No";
                              $desc = nl2br($row["descrizione"]);
                              $id_html = $row["id_html_map"];
                              echo "<tr style='text-align:center;'>";
                              echo "<td>$tag</td> <td>$nome</td> <td>$piano</td> <td>$num_post</td> <td>$num_pc</td> <td>$lim</td> <td><div style='width:200px; word-wrap: break-word; text-align:left;'>$desc</div></td> <td>$id_html</td>";
                              echo "<td><a href='../../view.php?tag=$tag'>Visualizza</a></td> <td><a href='modify.php?tag=$tag'>Modifica</a></td> <td><a href='delete.php?tag=$tag'>Elimina</a></td>";
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
