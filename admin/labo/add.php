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
<html lang="en">
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

      <title>Aggiungi</title>

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
                  <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Aggiungi laboratorio</h1>

                     <div align="center">
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                           <table>
                              <tr>
                                 <td id="label">Tag</td>
                                 <td id="padding"><input type="text" name="tag" value="<?php if(!empty($_POST['tag'])) echo $_POST['tag']; ?>" required></td>
                              </tr>
                              <tr>
                                 <td id="label">Nome</td>
                                 <td id="padding"><input type="text" name="nome" value="<?php if(!empty($_POST['nome'])) echo $_POST['nome']; ?>" required></td>
                              </tr>
                              <tr>
                                 <td id="label">Piano</span></td>
                                 <td id="padding"><input type="number" min="0" max="3" name="piano" value="<?php if(!empty($_POST['piano'])) echo $_POST['piano']; ?>" required></td>
                              </tr>
                              <tr>
                                 <td id="label">Numero posti</td>
                                 <td id="padding"><input type="number" min="0" name="numposti" value="<?php if(!empty($_POST['numposti'])) echo $_POST['numposti']; ?>"></td>
                              </tr>
                              <tr>
                                 <td id="label">Numero PC</td>
                                 <td id="padding"><input type="number" min="0" name="numpc" value="<?php if(!empty($_POST['numpc'])) echo $_POST['numpc']; ?>"></td>
                              </tr>
                              <tr>
                                 <td id="label">Presenza LIM</td>
                                 <td id="padding"><input type="checkbox" name="lim"></td>
                              </tr>
                              <tr>
                                 <td id="label">Descrizione</td>
                                 <td id="padding"><textarea name="descrizione" rows="5" value="<?php if(!empty($_POST['descrizione'])) echo $_POST['descrizione']; ?>"></textarea></td>
                              </tr>
                           </table>
                           <br>
                           <input type="submit" id="submit" name="submit" value="Inserisci">

                        </form>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </section>

   </body>
</html>


<?php

   if(isset($_POST["submit"])) {

      // Controlla che tutti i campi obbligatori siano impostati
      if(!empty($_POST["tag"]) && !empty($_POST["nome"]) && !empty($_POST["piano"])) {
         try {
            $lim = isset($_POST["lim"]) ? 1 : 0;

            $conn = db_connect();
            $sql = "INSERT laboratori (tag, nome, piano, num_posti, num_pc, presenza_lim, descrizione)
                    VALUES(:tag, :nome, :piano, :num_posti, :num_pc, :presenza_lim, :descrizione)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":tag", $_POST["tag"], PDO::PARAM_STR, 20);
            $stmt->bindParam(":nome", $_POST["nome"], PDO::PARAM_STR, 100);
            $stmt->bindParam(":piano", $_POST["piano"], PDO::PARAM_INT);
            $stmt->bindParam(":num_posti", $_POST["numposti"], PDO::PARAM_INT);
            $stmt->bindParam(":num_pc", $_POST["numpc"], PDO::PARAM_INT);
            $stmt->bindParam(":presenza_lim", $lim);
            $stmt->bindParam(":descrizione", $_POST["descrizione"], PDO::PARAM_STR, 500);
            $stmt->execute();

            $tag = $_POST["tag"];

            // Pagina per inserire immagini
            header("Location:add_images.php?tag=$tag");

         } catch (PDOException $e) {
            echo "<p style='text-align:center;'>Si è verificato un errore</p>";
         }

      }
   }

?>
