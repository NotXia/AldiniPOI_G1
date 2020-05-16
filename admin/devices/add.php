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
      <link rel="stylesheet" href="../../css/admin_navbar.css">
      <link rel="stylesheet" href="../../css/form_table.css">

      <title>Aggiungi</title>

   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <a class="navbar-brand" href="../index">Admin</a>
         <div align="right">
            <a id="nav_options" href="../index.php">Dashboard</a>
            <a id="nav_options" href="../openday/view.php">Open Day</a>
            <a id="nav_options" href="../labo/view.php">Laboratori</a>
            <a id="nav_options" href="view.php">Dispositivi</a>
            <a id="nav_options" href="../logout.php">Logout</a>
         </div>
      </nav>

      <section id="cover" class="min-vh-90">
         <div id="cover-caption">
            <div class="container">
               <div class="row text-black">
                  <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 mx-auto text-center form p-4">
                     <h1 class="display-4 py-2">Aggiungi dispositivo</h1>

                     <div align="center">
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                           <table>
                              <tr>
                                 <td id="label">Indirizzo MAC</td>
                                 <td id="padding"><input type="text" id="mac_address" maxlength="17" name="mac_address" value="<?php if(!empty($_POST['mac_address'])) echo $_POST['mac_address']; ?>" required></td>
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

   <script type="text/javascript">
      document.getElementById("mac_address").addEventListener('keyup', function() {
         this.value = (this.value.toUpperCase()
                      .replace(/[^\d|A-F]/g, '')
                      .match(/.{1,2}/g) || [])
                      .join(":")
      });
   </script>
</html>


<?php

   if(isset($_POST["submit"])) {

      // Controlla che tutti i campi obbligatori siano impostati
      if(!empty($_POST["mac_address"])) {
         try {
            $conn = db_connect();
            $sql = "INSERT dispositivi (mac_address, descrizione)
                    VALUES(:mac, :descrizione)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":mac", $_POST["mac_address"], PDO::PARAM_STR, 20);
            $stmt->bindParam(":descrizione", $_POST["descrizione"], PDO::PARAM_STR, 100);
            $stmt->execute();

            // Pagina per inserire immagini
            header("Location:view.php");

         } catch (PDOException $e) {
            echo "<p style='text-align:center;'>Si è verificato un errore</p>";
         }

      }
   }

?>
