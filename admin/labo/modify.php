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
   require_once (dirname(__FILE__)."/../../util/config.php");
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

      <title>Modifica</title>

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
                     <?php
                        if(empty($_GET["tag"]) && empty($_POST["tag"])) {
                           ?>
                           <h3>Errore</h3>
                           <?php
                        }
                        else {
                           if(!empty($_GET["tag"])) { $tag = htmlentities($_GET["tag"]); }
                           else { $tag = htmlentities($_POST["tag"]); }

                     ?>
                     <h1 class="display-4 py-2">Tag <?php echo "'$tag'"; ?></h1>

                        <div class="table-responsive" align="center">

                           <a href="add_images.php?tag=<?php echo $tag?>">Aggiungi immagini</a> <br><br>
                           <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                              <input type="hidden" name="old_tag" value="<?php echo $tag ?>">
                              <?php
                                 $conn = db_connect();
                                 $sql = "SELECT * FROM laboratori WHERE tag = :tag";
                                 $stmt = $conn->prepare($sql);
                                 $stmt->bindParam(":tag", $tag, PDO::PARAM_STR, 20);
                                 $stmt->execute();
                                 $res = $stmt->fetch();
                              ?>
                              <table>
                                 <tr>
                                    <td id="label">Tag</td>
                                    <td id="padding"><input type="text" name="tag" value="<?php if(!empty($res['tag'])) echo $res['tag']; ?>" required></td>
                                 </tr>
                                 <tr>
                                    <td id="label">Nome</td>
                                    <td id="padding"><input type="text" name="nome" value="<?php if(!empty($res['nome'])) echo $res['nome']; ?>" required></td>
                                 </tr>
                                 <tr>
                                    <td id="label">Piano</span></td>
                                    <td id="padding"><input type="number" min="0" max="3" name="piano" value="<?php if(!empty($res['piano'])) echo $res['piano']; ?>" required></td>
                                 </tr>
                                 <tr>
                                    <td id="label">Numero PC</td>
                                    <td id="padding"><input type="number" min="0" name="numpc" value="<?php if(!empty($res['num_pc'])) echo $res['num_pc']; ?>"></td>
                                 </tr>
                                 <tr>
                                    <td id="label">Presenza LIM</td>
                                    <td id="padding"><input type="checkbox" name="lim" <?php if(!empty($res['presenza_lim'])) { if($res['presenza_lim'] == 1) echo "checked"; } ?>></td>
                                 </tr>
                                 <tr>
                                    <td id="label">Descrizione</td>
                                    <td id="padding"><textarea name="descrizione" rows="5"><?php if(!empty($res['descrizione'])) echo $res['descrizione']; ?></textarea></td>
                                 </tr>
                                 <tr>
                                    <td id="label">Id HTML</td>
                                    <td id="padding"><input type="text" name="id_html" value="<?php if(!empty($res['id_html_map'])) echo $res['id_html_map']; ?>"></td>
                                 </tr>
                                 <tr>
                                    <td id="label">Label HTML</td>
                                    <td id="padding"><input type="text" name="label_html" value="<?php if(!empty($res['label_html_map'])) echo $res['label_html_map']; ?>"></td>
                                 </tr>
                              </table>
                              <br>
                              <table class="table table-bordered">
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
                                       <td><textarea rows='5' cols='50' name='descrizione_img[$id]'>$descrizione</textarea></td>
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

         if(!empty($_POST["tag"]) && !empty($_POST["nome"]) && !empty($_POST["piano"])) {
            $lim = isset($_POST["lim"]) ? 1 : 0;

            $conn = db_connect();
            $sql = "UPDATE laboratori
                    SET tag = :tag, nome = :nome, piano = :piano,
                        num_pc = :num_pc, presenza_lim = :presenza_lim,
                        descrizione = :descrizione, id_html_map = :id_html, label_html_map = :label_html
                    WHERE tag = :old_tag";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":tag", $_POST["tag"], PDO::PARAM_STR, 20);
            $stmt->bindParam(":nome", $_POST["nome"], PDO::PARAM_STR, 100);
            $stmt->bindParam(":piano", $_POST["piano"], PDO::PARAM_INT);
            $stmt->bindParam(":num_pc", $_POST["numpc"], PDO::PARAM_INT);
            $stmt->bindParam(":presenza_lim", $lim);
            $stmt->bindParam(":descrizione", $_POST["descrizione"], PDO::PARAM_STR, 500);
            $stmt->bindParam(":id_html", $_POST["id_html"], PDO::PARAM_STR, 100);
            $stmt->bindParam(":label_html", $_POST["label_html"], PDO::PARAM_STR, 100);
            $stmt->bindParam(":old_tag", $_POST["old_tag"], PDO::PARAM_STR, 20);
            $stmt->execute();
         }

         if(!empty($_POST["descrizione_img"])) {
            foreach($_POST["descrizione_img"] as $id=>$desc) {
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
         }

         header("Location:view.php");
         exit;

      } catch (PDOException $e) {
         echo $e->getMessage();
      }
   }

?>
