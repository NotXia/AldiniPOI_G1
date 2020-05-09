<?php
   session_start(); // Serve per passare l'id alla pagina di change.php

   require (dirname(__FILE__)."/../util/dbconnect.php");
   require (dirname(__FILE__)."/../util/mail_gen/reset_password.php");

   if(isset($_GET["id"]) && isset($_GET["p1"]) && isset($_GET["p2"]) && isset($_GET["p3"])) {
      try {
         $conn = db_connect();
         $id = $_GET["id"];

         // Estrazione dati dell'utente utilizzando l'id passato come parametro
         $sql = "SELECT nome, cognome, email, data_creazione FROM utenti WHERE id = :id";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
         $stmt->execute();

         $res = $stmt->fetch();
         if(isset($res["nome"])) { // Se la query ha restituito una riga
            // Verifica dei parametri passati e gli hash corrispondenti
            if(check_reset_psw_mail(
               array($_GET["p1"], $_GET["p2"], $_GET["p3"]),
               array($res["nome"], $res["cognome"], $res["email"], $res["data_creazione"]))
            ) {
               $_SESSION["change_psw_id"] = $id;
               header("Location:change.php");
            }
         }
         else {
            echo "<p id='error'>Qualcosa è andato storto</p>";
         }
      }
      catch (PDOException $e) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
      }
   }

?>
