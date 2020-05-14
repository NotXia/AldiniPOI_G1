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
      <link rel="stylesheet" type="text/css" href="style.css">
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
      <title>Visualizza</title>

      <style>
         table {
            border-collapse: collapse;
         }

         table, th, td {
            border: 1px solid #969696;
            padding: 5px;
         }
      </style>
   </head>
   <body>

      <div align="center">

         <h2>Lista laboratori</h2><br>

         <table>
            <tr>
               <th>Tag</th> <th>Nome</th> <th>Piano</th>
               <th>Numero posti</th> <th>Numero PC</th>
               <th>LIM</th> <th>Descrizione</th>
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
               $desc = $row["descrizione"];
               echo "<tr>";
               echo "<td>$tag</td> <td>$nome</td> <td>$piano</td> <td>$num_post</td> <td>$num_pc</td> <td>$lim</td> <td><div style='width:300px; word-wrap: break-word''>$desc</div></td>";
               echo "<td><a>Visualizza</a></td> <td><a href='modify.php?tag=$tag'>Modifica</a></td> <td><a href='delete.php?tag=$tag'>Elimina</a></td>";
               echo "</tr>";
            }

            ?>
         </table>

      </div>

   </body>
</html>
