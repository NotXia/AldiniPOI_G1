<?php

   require "utilities.php";

   try {
      $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PSW);

      $id = $_GET["id"];
      $p1 = $_GET["p1"];
      $p2 = $_GET["p2"];
      $p3 = $_GET["p3"];

      $sql = "SELECT nome, cognome, email, data_creazione FROM utenti WHERE id = $id";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      $res = $stmt->fetch();

      if(isset($res)) {
         if($p1 == hash("sha512", $res["nome"].$res["data_creazione"]) &&
         $p2 == hash("sha512", $res["cognome"].$res["data_creazione"]) &&
         $p3 == hash("sha512", $res["email"].$res["data_creazione"])) {

            $sql = "UPDATE utenti SET verifica_mail = 1 WHERE id = $id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            echo "Email validata";
         }
      }
   }
   catch(PDOException $e) {
      echo "Male";
   }

?>
