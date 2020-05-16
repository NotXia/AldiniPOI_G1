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
      <link rel="stylesheet" href="../../css/admin_navbar.css">
      <link rel="stylesheet" href="../../css/form_table.css">

      <title>Modifica</title>

   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <a class="navbar-brand" href="../index.php">Admin</a>
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
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto text-center form p-4">
                     <?php
                        if(empty($_GET["id"]) && empty($_POST["id"])) {
                           ?>
                           <h3>Errore</h3>
                           <?php
                        }
                        else {
                           if(!empty($_GET["id"])) { $id = htmlentities($_GET["id"]); }
                           else { $id = htmlentities($_POST["id"]); }

                     ?>
                     <h1 class="display-4 py-2">Modifica dispositivo</h1>

                        <div class="table-responsive" align="center">

                           <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                              <input type="hidden" name="id" value="<?php echo $id ?>">
                              <?php
                                 $conn = db_connect();
                                 $sql = "SELECT * FROM dispositivi WHERE id = :id";
                                 $stmt = $conn->prepare($sql);
                                 $stmt->bindParam(":id", $id, PDO::PARAM_STR, 20);
                                 $stmt->execute();
                                 $res = $stmt->fetch();
                              ?>
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

   if(isset($_POST["confirm"])) {
      try {
         $conn = db_connect();

         if(!empty($_POST["mac_address"])) {
            $conn = db_connect();
            $sql = "UPDATE dispositivi
                    SET mac_address = :mac_address, descrizione = :descrizione
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":mac_address", $_POST["mac_address"], PDO::PARAM_STR, 20);
            $stmt->bindParam(":descrizione", $_POST["descrizione"], PDO::PARAM_STR, 100);
            $stmt->bindParam(":id", $_POST["id"], PDO::PARAM_INT);
            $stmt->execute();
         }

         header("Location:view.php");
         exit;

      } catch (PDOException $e) {
         echo $e->getMessage();
      }
   }

?>
