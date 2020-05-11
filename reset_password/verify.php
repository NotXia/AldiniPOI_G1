<?php
   require (dirname(__FILE__)."/../util/config.php");
   require (dirname(__FILE__)."/../util/dbconnect.php");
   require (dirname(__FILE__)."/../util/mail_gen/reset_password.php");

   session_start(); // Serve per passare l'id alla pagina di change.php
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reset password</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
      <link rel="stylesheet" href="../css/form_table.css">
      <title></title>
   </head>
   <body>
      <div align="center">
         <img width="3%" src="../res/logo.png" alt="Logo AV"><br><br>
      </div>
   </body>
</html>

<?php

   if(isset($_GET["id"]) && isset($_GET["p1"]) && isset($_GET["p2"]) && isset($_GET["p3"]) && isset($_GET["p4"])) {
      try {
         $conn = db_connect();
         $id = $_GET["id"];

         // Estrazione dati dell'utente utilizzando l'id passato come parametro
         $sql = "SELECT nome, cognome, email, data_creazione, ultima_modifica_psw FROM utenti WHERE id = :id";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
         $stmt->execute();

         $res = $stmt->fetch();
         if(isset($res["nome"])) { // Se la query ha restituito una riga

            // Verifica che la richiesta di modifica password sia stata fatta
            if(isset($res["ultima_modifica_psw"])) {
               $time_diff = round((strtotime(date("Y-m-d H:i:s")) - strtotime($res["ultima_modifica_psw"])) / 60); // In minuti

               // Verifica che la richiesta di modifica password sia ancora valida
               if($time_diff > $TIMEOUT_CHANGE_PSW) {
                  $sql = "UPDATE utenti SET ultima_modifica_psw = null WHERE id = :id";
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                  $stmt->execute();
                  die ("<p id='error'>La tua richiesta è scaduta, richiedine un'altra premendo <a href='request.php'>qui</a></p>");
               }

            }
            else {
               die ("<p id='error'>La tua richiesta è scaduta, richiedine un'altra premendo <a href='request.php'>qui</a></p>");
            }

            // Verifica dei parametri passati e gli hash corrispondenti
            if(check_reset_psw_mail(
               array($_GET["p1"], $_GET["p2"], $_GET["p3"], $_GET["p4"]),
               array($res["nome"], $res["cognome"], $res["email"], $res["data_creazione"], $res["ultima_modifica_psw"]))
            ) {
               $_SESSION["change_psw_id"] = $id; // Per passarlo alla pagina change.php
               header("Location:change.php");
            }
            else {
               echo "<p id='error'>Qualcosa è andato storto</p>";
            }
         } // if(isset($res["nome"]))
         else {
            echo "<p id='error'>Qualcosa è andato storto</p>";
         }
      }
      catch (PDOException $e) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
      }
   } // if(isset($_GET["id"]) && isset($_GET["p1"]) && isset($_GET["p2"]) && isset($_GET["p3"]) && isset($_GET["p4"]))
   else {
      echo "<p id='error'>Qualcosa è andato storto</p>";
   }

?>
