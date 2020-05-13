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
   require_once (dirname(__FILE__)."/../util/config.php");


   if(isset($_GET["tag"])) {
      $tag = $_GET["tag"];
   }

   /*
      return
        -1 -> Errore generico
         0 -> Ok
         1 -> Non è un'immagine
         2 -> Troppo grande
   */
   function check_img($name, $index) : int {

      if(!empty($_FILES[$name]["tmp_name"][$index])) {
         // Controlla se è un'immagine
         if(getimagesize($_FILES[$name]["tmp_name"][$index]) == false) {
            return 1;
         }

         // controllo dimensione file
         if ($_FILES[$name]["size"][$index] > 500000) {
            return 2;
         }

         return 0;
      }
      else {
         return -1;
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Aggiungi laboratorio</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/form_table.css">

</head>
   <body>

      <div align="center">

         <h2>Aggiungi laboratorio</h2>

         <h3>Immagini base</h3>
         <div id="form1">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="tag" value="<?php if(isset($_GET['tag'])) echo $_GET['tag'] ?>">
               Permessi <select name="permessi">
                  <?php
                     $conn = db_connect();
                     $sql = "SELECT * FROM permessi WHERE id != 3";
                     $stmt = $conn->prepare($sql);
                     $stmt->execute();
                     while($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $tipologia = $row["tipologia"];
                        echo "<option value='$id'>$tipologia</option>";
                     }
                  ?>
               </select>
               <br>
               <br>
               <table>
                  <tr>
                     <td><input id="file_1" type="file" name="img_base[]" accept=".jpg,.jpeg,.png" multiple></td>
                     <td><input id="submit_1" type="submit" name="submit_load_base" value="Carica"></td>
                  </tr>
               </table>
            </form>
         </div>

         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
         <table>

         <?php
            if(isset($_POST["submit_load_base"]) && !empty($_POST["tag"])) {
               $conn = db_connect();

               for($i=0; $i < count($_FILES["img_base"]["name"]); $i++) {
                  $check_res = check_img("img_base", $i);

                  // Immagine ok
                  if($check_res == 0) {
                     try {
                        $conn->beginTransaction();

                        // Inserimento con percorso fittizio
                        $sql = "INSERT immagini (percorso, descrizione, cod_laboratorio, cod_permesso)
                        VALUES('temp', null, :cod_laboratorio, :cod_permesso)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":cod_laboratorio", $_POST["tag"], PDO::PARAM_STR, 20);
                        $stmt->bindParam(":cod_permesso", $_POST["permessi"], PDO::PARAM_INT);
                        $stmt->execute();

                        $last_id = $conn->lastInsertId();

                        // Compone il nome del file da salvare
                        $estensione = strtolower(pathinfo($_FILES["img_base"]["name"][$i], PATHINFO_EXTENSION));
                        $nome_immagine = $_POST["tag"] . "_" . $last_id . "." . $estensione;
                        $final_path = "../" . $IMAGES_PATH_BASE . "/" .  $nome_immagine;

                        if (move_uploaded_file($_FILES["img_base"]["tmp_name"][$i], $final_path)) {
                           // Aggiorna il percorso con quello reale
                           $sql = "UPDATE immagini SET percorso = :percorso WHERE id = $last_id";
                           $stmt = $conn->prepare($sql);
                           $stmt->bindParam(":percorso", $final_path, PDO::PARAM_STR, 500);
                           $stmt->execute();
                           echo "<tr>
                                 <td><img src=$final_path width=200></td>
                                 <td><textarea name='descrizione[$last_id]' rows=6></textarea></td>
                                 </tr>";
                        }
                        else { // Inserimento fallito
                           $sql = "DELETE FROM immagini WHERE id = $last_id";
                           $stmt = $conn->prepare($sql);
                           $stmt->execute();
                           echo "<tr><td>" . basename($_FILES["img_base"]["name"][$i]) . " non è stato caricato</td></tr>";
                        }

                        $conn->commit();

                     }
                     catch(PDOException $e) {
                        echo $e->getMessage();
                        $conn->rollBack();
                     }
                  }
                  else if($check_res == 1) { // Non è immagine
                     $file_name = basename($_FILES["img_base"]["name"][$i]);
                     echo "<tr><td>$file_name non è un'immagine</td></tr>";
                  }
                  else if($check_res == 2) { // Troppo grande
                     $file_name = basename($_FILES["img_base"]["name"][$i]);
                     echo "<tr><td>$file_name è troppo grande</td></tr>";
                  }
                  else if($check_res == -1) { // Errore generico
                     echo "<p>Qualcosa non ha funzionato</p> <br>";
                  }
               }

               echo "<script> document.getElementById('form1').style = 'display:none;'; </script>";

            } // if(isset($_POST["submit_load_base"]) && !empty($_POST["tag"]))
         ?>

         </table>
         <?php
            if(isset($_POST["submit_load_base"]) && !empty($_POST["tag"])) {
               ?>
               <br>
               <input type="submit" name="submit_base" value="Salva">
               <?php
            }
         ?>
         </form>
         <br>
      </div>
   </body>
</html>

<?php

   if(isset($_POST["submit_base"])) {
      $conn = db_connect();

      foreach($_POST["descrizione"] as $id=>$desc) {
         try {
            $sql = "UPDATE immagini SET descrizione = :descrizione WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":descrizione", $desc, PDO::PARAM_STR, 500);
            $stmt->bindParam(":id", $id, PDO::PARAM_STR, 20);
            $stmt->execute();
         }
         catch(PDOException $e) {

         }
      }

      echo "<script> document.getElementById('form1').style = 'display:none;'; </script>";
      echo "<h4 style='text-align:center'>Fatto</h4>";
   }

?>
