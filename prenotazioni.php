<?php
   require (dirname(__FILE__)."/util/dbconnect.php");

   session_start();

   if(!isset($_SESSION["id"])) {
      // Ricordami attivo
      if(isset($_COOKIE["user"])) {
         // [selector, token]
         $parti = explode(":", $_COOKIE["user"]);

         try {
            $conn = db_connect();

            $sql = "SELECT token, data_scadenza, utenti.id as idUtente, nome, cognome, email, cod_permesso
                    FROM autenticazioni, utenti
                    WHERE utenti.id = cod_utente AND selector = :selector";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':selector', $parti[0], PDO::PARAM_STR, 20);
            $stmt->execute();
            $res = $stmt->fetch();

            if(isset($res["token"])) {
               // Verifica se il token è scaduto
               if(strtotime($res['data_scadenza']) > strtotime(date("Y-m-d H:i:s"))) {
                  if(password_verify($parti[1], $res['token'])) {
                     $_SESSION["id"] = $res["idUtente"];
                     $_SESSION["nome"] = $res["nome"];
                     $_SESSION["cognome"] = $res["cognome"];
                     $_SESSION["email"] = $res["email"];
                     $_SESSION["cod_permesso"] = $res["cod_permesso"];
                  }
                  else { // Token errato
                     $sql = "DELETE FROM autenticazioni WHERE selector = :selector";
                     $stmt = $conn->prepare($sql);
                     $stmt->bindParam(':selector', $parti[0], PDO::PARAM_STR, 20);
                     $stmt->execute();
                     setcookie("user", "", time()-1, "/");
                     header("Location:login.php");
                  }
               }
               else { // Token scaduto
                  $sql = "DELETE FROM autenticazioni WHERE selector = :selector";
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(':selector', $parti[0], PDO::PARAM_STR, 20);
                  $stmt->execute();
                  setcookie("user", "", time()-1, "/");
                  header("Location:login.php");
               }
            }
         } catch (PDOException $e) {
            header("Location:login.php");
         }

      }
      else {
         header("Location:login.php");
      }
   }

?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title></title>
   </head>
   <body>
      <p>Sei dentro</p>
   </body>
</html>
