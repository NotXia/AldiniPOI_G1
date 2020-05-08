<?php

   require (dirname(__FILE__)."/../util/dbconnect.php");

   try {
      $conn = db_connect();

      $id = $_GET["id"];
      $p1 = $_GET["p1"];
      $p2 = $_GET["p2"];
      $p3 = $_GET["p3"];

      // Estrazione dati dell'utente cercando utilizzando l'id passato come parametro
      $sql = "SELECT nome, cognome, email, data_creazione, verifica_mail FROM utenti WHERE id = :id";
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

            // Verifica se l'utente ha già la mail verificata
            // (Viene fatto dopo il controllo degli hash per evitare il libero accesso alla situazione di altri utenti)
            // (Nel caso si riuscisse ad arrivare alla pagina errore per chiedere un nuovo invio,
            //  viene bloccato l'invio se l'utente ha già verificato la mail)
            if($res["verifica_mail"] == 1) {
               header("Location:already_done.html");
            }
            else { // Aggiornamento stato utente
               $sql = "UPDATE utenti SET verifica_mail = 1 WHERE id = :id";
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(":id", $id, PDO::PARAM_INT);
               $stmt->execute();
               header("Location:success.html");
            }
         }
         else {
            header("Location:error.php?id=$id");
         }
      }
      else { // Nessuna riga restituita (URL manipolato)
         header("Location:error.php?id=$id");
      }
   }
   catch(PDOException $e) {
      header("Location:error.php?id=$id");
   }

?>
