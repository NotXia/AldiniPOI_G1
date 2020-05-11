<?php
   require (dirname(__FILE__)."/../util/dbconnect.php");
   require (dirname(__FILE__)."/../util/mailer.php");
   require (dirname(__FILE__)."/../util/mail_gen/reset_password.php");
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reset password</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
      <link rel="stylesheet" href="../css/form_table.css">
   </head>
   <body>
      <div align="center">
         <img width="3%" src="../res/logo.png" alt="Logo AV"><br><br>
         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            Email <input type="email" name="email">
            <input type="submit" name="request" value="Invia richiesta">
         </form>
         <br>
      </div>
   </body>
</html>

<?php

   if(isset($_POST["request"])) {

      try {
         // Estrae i dati dell'utente a cui mandare la mail
         $conn = db_connect();
         $sql = "SELECT id, nome, cognome, email, data_creazione FROM utenti WHERE email = :email";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR, 100);
         $stmt->execute();

         $res = $stmt->fetch();
         if(isset($res["email"])) { // Se la query ha restituito una riga

            $conn->beginTransaction();

            // Aggiorna la data di modifica password
            $sql = "UPDATE utenti SET ultima_modifica_psw = NOW() WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $res["id"], PDO::PARAM_INT);
            $stmt->execute();

            // Estrae la data appena inserita
            $sql = "SELECT ultima_modifica_psw FROM utenti WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $res["id"], PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit();
            $now = $stmt->fetch()["ultima_modifica_psw"];

            // Creazione e invio mail
            $email_format = reset_psw_mail($res["id"], $res["nome"], $res["cognome"], $res["email"], $res["data_creazione"], $now);
            mailTo($res["email"], "POI - Cambio password", $email_format);

            echo "<p id='message'>Ti abbiamo inviato una mail con la procedura di cambio password</p>";
         }
         else {
            echo "<p id='error'>Non siamo riusciti a trovare un account associato a questa mail</p>";
         }
      }
      catch(PDOException $e) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
         $conn->rollback();
      }
   }

?>
