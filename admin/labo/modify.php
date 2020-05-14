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
   require_once (dirname(__FILE__)."/../../util/config.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
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
      <title>Elimina</title>

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
         <?php
            if(!isset($_GET["tag"])) {
               ?>
               <h3>Errore</h3>
               <?php
            }
            else {
               $tag = htmlentities($_GET["tag"]);

               ?>
               <h3>Tag <?php echo "'$tag'"; ?></h3>
               <a href="add_images.php?tag=<?php echo $tag?>">Aggiungi immagini</a> <br><br>
               <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                  <input type="hidden" name="tag" value="<?php echo $tag ?>">
                  <table>
                     <tr>
                        <th>Immagine</th> <th>Descizione</th> <th>Permesso</th> <th>Elimina</th>
                     </tr>
                     <?php
                     $conn = db_connect();

                     $sql = "SELECT * FROM permessi";
                     $stmt = $conn->prepare($sql);
                     $stmt->execute();
                     $res = $stmt->fetchAll();
                     $permessi = [];
                     foreach($res as $row) {
                        $permessi[$row["id"]] = $row["tipologia"];
                     }

                     // Estraee le immagini connesse al tag
                     $sql = "SELECT * FROM immagini WHERE cod_laboratorio = :tag";
                     $stmt = $conn->prepare($sql);
                     $stmt->bindParam(":tag", $tag, PDO::PARAM_STR, 20);
                     $stmt->execute();
                     $res = $stmt->fetchAll();

                     foreach($res as $row) {
                        $id = $row["id"];
                        $percorso = $row["percorso"];
                        $descrizione = $row["descrizione"];
                        $cod_permesso = $row["cod_permesso"];
                        echo "<tr>";
                        echo "<td><img src='../../$IMAGES_PATH/$percorso' width='200px'><br>$percorso</td>
                              <td><textarea rows='5' cols='50' name='descrizione[$id]'>$descrizione</textarea></td>
                              <td><select name='permesso[$id]'>";
                              foreach($permessi as $id_perm=>$tipo) { // Imposta il permesso corretto dell'immagine
                                 if($cod_permesso == $id_perm) {
                                    echo "<option value='$id_perm' selected='selected'>$tipo</option>";
                                 }
                                 else {
                                    echo "<option value='$id_perm'>$tipo</option>";
                                 }
                              }
                        echo "</select></td> <td><input type='checkbox' name='delete[$id]'></td>";
                        echo "</tr>";
                     }
                     ?>
                  </table>
                  <br>
                  <input type="submit" name="confirm" value="Salva">
               </form>
               <?php
            }
         ?>
      </div>
   </body>
</html>

<?php

   if(isset($_POST["confirm"])) {
      try {
         $conn = db_connect();

         foreach($_POST["descrizione"] as $id=>$desc) {
            if(isset($_POST["delete"][$id])) {
               $sql = "DELETE FROM immagini WHERE id = :id";
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(":id", $id, PDO::PARAM_INT);
               $stmt->execute();
            }
            else {
               $sql = "UPDATE immagini SET descrizione = :descrizione, cod_permesso = :permesso WHERE id = :id";
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(":descrizione", $desc, PDO::PARAM_STR, 500);
               $stmt->bindParam(":permesso", $_POST["permesso"][$id], PDO::PARAM_INT);
               $stmt->bindParam(":id", $id, PDO::PARAM_INT);
               $stmt->execute();
            }
         }

         $tag = $_POST["tag"];
         header("Location:modify.php?tag=$tag");

      } catch (PDOException $e) {
         echo $e->getMessage();
      }
   }

?>
