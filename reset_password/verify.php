<?php

   require (dirname(__FILE__)."/../util/dbconnect.php");

   if(isset($_GET["id"]) && isset($_GET["p1"]) && isset($_GET["p2"]) && isset($_GET["p3"])) {
      try {
         $conn = db_connect();
         $id = $_GET["id"];
         $p1 = $_GET["p1"];
         $p2 = $_GET["p2"];
         $p3 = $_GET["p3"];

         // Estrazione dati dell'utente cercando utilizzando l'id passato come parametro
         $sql = "SELECT nome, cognome, email, data_creazione FROM utenti WHERE id = :id";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
         $stmt->execute();

         $res = $stmt->fetch();
         // Se la query ha restituito una riga
         if(isset($res["nome"])) {
            // Verifica dei parametri passati e gli hash corrispondenti
            if($p1 == hash("sha512", $res["nome"].$res["data_creazione"]) &&
            $p2 == hash("sha512", $res["cognome"].$res["data_creazione"]) &&
            $p3 == hash("sha512", $res["email"].$res["data_creazione"])) {
               header("Location:change.php?id=$id");
            }
         }
      }
      catch (PDOException $e) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
      }
   }

?>
