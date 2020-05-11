<?php
   // Inizializza SESSION se non è già stato fatto
   if(!isset($_SESSION)) {
      session_start();
   }

   require_once (dirname(__FILE__)."/dbconnect.php");

   function isLogged() : bool {

      if(!isset($_SESSION["id"])) {

         // "Ricordami" attivo
         if(isset($_COOKIE["user"])) {

            // [selector, token]
            $parti = explode(":", $_COOKIE["user"]);

            try {
               $conn = db_connect();

               // Estrae l'hash del token e la scadenza del selector memorizzato dall'utente
               $sql = "SELECT token, data_scadenza, utenti.id as idUtente, nome, cognome, email, cod_permesso
                       FROM autenticazioni, utenti
                       WHERE utenti.id = cod_utente AND
                             selector = :selector";
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(':selector', $parti[0], PDO::PARAM_STR, 20);
               $stmt->execute();
               $res = $stmt->fetch();

               if(isset($res["token"])) {
                  // Verifica se il token è scaduto
                  if(strtotime($res['data_scadenza']) > strtotime(date("Y-m-d H:i:s"))) {

                     if(password_verify($parti[1], $res['token'])) { // Token verificato
                        $_SESSION["id"] = $res["idUtente"];
                        $_SESSION["nome"] = $res["nome"];
                        $_SESSION["cognome"] = $res["cognome"];
                        $_SESSION["email"] = $res["email"];
                        $_SESSION["cod_permesso"] = $res["cod_permesso"];
                        return true;
                     }
                     else { // Token errato
                        $sql = "DELETE FROM autenticazioni WHERE selector = :selector";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':selector', $parti[0], PDO::PARAM_STR, 20);
                        $stmt->execute();
                        setcookie("user", "", time()-1, "/");
                        return false;
                     }
                  } // if(strtotime($res['data_scadenza']) > strtotime(date("Y-m-d H:i:s")))
                  else { // Token scaduto
                     $sql = "DELETE FROM autenticazioni WHERE selector = :selector";
                     $stmt = $conn->prepare($sql);
                     $stmt->bindParam(':selector', $parti[0], PDO::PARAM_STR, 20);
                     $stmt->execute();
                     setcookie("user", "", time()-1, "/");
                     return false;
                  }
               } // if(isset($res["token"]))
            }
            catch (PDOException $e) {
               return false;
            }

         } // if(isset($_COOKIE["user"]))
         else {
            return false;
         }
      } // if(!isset($_SESSION["id"]))
      else {
         // SESSION già impostato
         return true;
      }
   }

?>
