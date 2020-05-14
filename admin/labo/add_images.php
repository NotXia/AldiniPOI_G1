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
      <link rel="stylesheet" href="../../css/form_table.css">

      <title>Aggiungi immagini</title>

   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <a class="navbar-brand" href="../index.php">Aldini Valeriani</a>
         <div align="right">
            <a id="nav_options" href="../openday/view.php">Open Day</a>
            <a id="nav_options" href="view.php">Laboratori</a>
         </div>
      </nav>

      <section id="cover" class="min-vh-90">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Aggiungi immagini</h1>

                     <div align="center">

                        <div id="form1">
                           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                              <input id="tag_id" type="hidden" name="tag" value="<?php if(isset($_GET['tag'])) echo $_GET['tag'] ?>">

                              Permessi <select name="permessi">
                                 <?php
                                    // Estrae i tipi di permessi disponibili, diversi da admin
                                    $conn = db_connect();
                                    $sql = "SELECT * FROM permessi WHERE id != 3";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $res = $stmt->fetchAll();
                                    foreach($res as $row) {
                                       $id = $row["id"];
                                       $tipologia = $row["tipologia"];
                                       echo "<option value='$id'>$tipologia</option>";
                                    }
                                 ?>
                              </select>
                              <br>
                              <br>
                              <input id="file_1" type="file" name="img_user[]" accept=".jpg,.jpeg,.png" multiple><br>
                              <br>
                              <input id="submit_1" type="submit" name="submit_load_base" value="Carica">

                           </form>
                        </div>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <table>

                        <?php
                           // Inserisce le immagini nel db e nella cartella di upload.
                           // Stampa le immagini appena inserite permettendo di inserire una descizione
                           if(isset($_POST["submit_load_base"]) && !empty($_POST["tag"])) {
                              $conn = db_connect();

                              for($i=0; $i < count($_FILES["img_user"]["name"]); $i++) {
                                 $check_res = check_img("img_user", $i);

                                 // Immagine ok
                                 if($check_res == 0) {
                                    try {
                                       $conn->beginTransaction();

                                       // Inserimento dell'immagine con percorso fittizio
                                       $sql = "INSERT immagini (percorso, descrizione, cod_laboratorio, cod_permesso)
                                       VALUES('temp', null, :cod_laboratorio, :cod_permesso)";
                                       $stmt = $conn->prepare($sql);
                                       $stmt->bindParam(":cod_laboratorio", $_POST["tag"], PDO::PARAM_STR, 20);
                                       $stmt->bindParam(":cod_permesso", $_POST["permessi"], PDO::PARAM_INT);
                                       $stmt->execute();

                                       $last_id = $conn->lastInsertId();

                                       // Compone il nome del file da salvare
                                       $estensione = strtolower(pathinfo($_FILES["img_user"]["name"][$i], PATHINFO_EXTENSION));
                                       $nome_immagine = $_POST["tag"] . "_" . $last_id . "_" . $_POST["permessi"] . "." . $estensione;
                                       $final_path = "../../" . $IMAGES_PATH . "/" .  $nome_immagine;

                                       // Sposta l'immagine nella cartella upload
                                       if (move_uploaded_file($_FILES["img_user"]["tmp_name"][$i], $final_path)) {

                                          // Aggiorna il percorso nel db con quello reale
                                          $sql = "UPDATE immagini SET percorso = :percorso WHERE id = $last_id";
                                          $stmt = $conn->prepare($sql);
                                          $stmt->bindParam(":percorso", $nome_immagine, PDO::PARAM_STR, 500);
                                          $stmt->execute();

                                          // Stampa l'immagine e un'area di testo
                                          echo "<tr>
                                                <td><img src=$final_path width=200></td>
                                                <td><textarea name='descrizione[$last_id]' rows=6></textarea></td>
                                                </tr>";
                                       }
                                       else { // Inserimento fallito
                                          // Eliminazione dell'immagine dal db
                                          $sql = "DELETE FROM immagini WHERE id = $last_id";
                                          $stmt = $conn->prepare($sql);
                                          $stmt->execute();
                                          echo "<tr><td>" . basename($_FILES["img_user"]["name"][$i]) . " non è stato caricato</td></tr>";
                                       }

                                       $conn->commit();

                                    }
                                    catch(PDOException $e) {
                                       $conn->rollBack();
                                       echo "<tr><td>" . basename($_FILES["img_user"]["name"][$i]) . " non è stato caricato</td></tr>";
                                    }
                                 }
                                 else if($check_res == 1) { // Non è immagine
                                    $file_name = basename($_FILES["img_user"]["name"][$i]);
                                    echo "<tr><td>$file_name non è un'immagine</td></tr>";
                                 }
                                 else if($check_res == 2) { // Troppo grande
                                    $file_name = basename($_FILES["img_user"]["name"][$i]);
                                    echo "<tr><td>$file_name è troppo grande</td></tr>";
                                 }
                                 else if($check_res == -1) { // Errore generico
                                    echo "<p>Qualcosa non ha funzionato</p> <br>";
                                 }
                              }

                              // Nasconde il primo form (caricamento immagine)
                              echo "<script> document.getElementById('form1').style = 'display:none;'; </script>";

                           } // if(isset($_POST["submit_load_base"]) && !empty($_POST["tag"]))
                        ?>

                        </table>
                        <?php
                           // Stampa il bottone di submit del secondo form (inserimento descrizione)
                           if(isset($_POST["submit_load_base"]) && !empty($_POST["tag"])) {
                              ?>
                              <br>
                              <input type="submit" name="submit" value="Salva">
                              <?php
                           }
                        ?>
                        </form>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </section>

      <div align="center">


         <br>
      </div>
   </body>
</html>

<?php

   if(isset($_POST["submit"])) {

      $conn = db_connect();

      if(!empty($_POST["descrizione"])) {
         // Inserisce per ogni immagine la descrizione corrispondente
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

         $current_tag = "";

         // Estrae il tag del laboratorio in modo tale da poter tornare alla fase iniziale
         foreach($_POST["descrizione"] as $id=>$desc) {
            $sql = "SELECT cod_laboratorio FROM immagini WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_STR, 20);
            $stmt->execute();
            $current_tag = $stmt->fetch()["cod_laboratorio"];
            break;
         }

         echo "<script> document.getElementById('tag_id').value = '$current_tag' </script>";
         echo "<p style='text-align:center'>Immagini aggiornate con successo</p>";
      }
   }

?>
