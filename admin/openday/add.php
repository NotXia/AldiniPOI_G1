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
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Aggiungi laboratorio</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/form_table.css">
   <style media="screen">
   td#padding {
      padding: 1.7px;
   }
   td#label {
      text-align: right;
      padding: 1.7px;
   }
   </style>
</head>
   <body>

      <div align="center">

         <h2>Aggiungi Open Day</h2>

         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <table>
               <tr>
                  <td id="label">Data</td>
                  <td id="padding"><input type="date" name="data" min="<?php echo htmlentities(date("Y-m-d")); ?>" value="<?php if(isset($_POST['data'])) echo $_POST['data']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Ora inizio</td>
                  <td id="padding"><input type="time" name="ora_inizio" value="<?php if(isset($_POST['ora_inizio'])) echo $_POST['ora_inizio']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Ora fine</span></td>
                  <td id="padding"><input type="time" name="ora_fine" value="<?php if(isset($_POST['ora_fine'])) echo $_POST['ora_fine']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Numero posti</td>
                  <td id="padding"><input type="number" min="0" name="posti" value="<?php if(isset($_POST['posti'])) echo $_POST['posti']; else echo "15"; ?>" required></td>
               </tr>
            </table>
            <br>
            <input type="submit" id="submit" name="submit" value="Inserisci">

         </form>
      </div>
   </body>
</html>


<?php

   if(isset($_POST["submit"])) {




      // Controlla che tutti i campi obbligatori siano impostati
      if(!empty($_POST["data"]) && !empty($_POST["ora_inizio"]) && !empty($_POST["ora_fine"]) && !empty($_POST["posti"])) {
         try {

            $conn = db_connect();
            $sql = "INSERT visite (data_inizio, ora_inizio, ora_fine, posti_disponibili)
                    VALUES(:data_inizio, :ora_inizio, :ora_fine, :posti_disponibili)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":data_inizio", $_POST["data"]);
            $stmt->bindParam(":ora_inizio", $_POST["ora_inizio"]);
            $stmt->bindParam(":ora_fine", $_POST["ora_fine"]);
            $stmt->bindParam(":posti_disponibili", $_POST["posti"], PDO::PARAM_INT);
            $stmt->execute();

            header("Location:view.php");

         } catch (PDOException $e) {
            echo "<p>Si è verificato un errore</p>";
         }

      }
   }

?>
