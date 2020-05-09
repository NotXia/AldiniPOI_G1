<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reset password</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
      <link rel="stylesheet" href="./css/reg_feedback_page.css">
      <style>
         p#error {
            color: red;
            text-align: center;
         }
      </style>
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
      require (dirname(__FILE__)."/../util/dbconnect.php");
      require (dirname(__FILE__)."/../util/mailer.php");
      require (dirname(__FILE__)."/../util/config.php");

      try {
         $conn = db_connect();
         $sql = "SELECT id, nome, cognome, email, data_creazione FROM utenti WHERE email = :email";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR, 100);
         $stmt->execute();
         $res = $stmt->fetch();

         if(isset($res["email"])) {

            // ----------------------------------------------------------------
            // Componimento URL per il reset della password
            // ----------------------------------------------------------------
            $url_validazione = sprintf(
               $URL_RESET_PSW,
               $res["id"],
               hash("sha512", $res["nome"].$res["data_creazione"]),
               hash("sha512", $res["cognome"].$res["data_creazione"]),
               hash("sha512", $res["email"].$res["data_creazione"])
            );
            // ****************************************************************

            // ----------------------------------------------------------------
            // Componimento HTML della mail da inviare
            // ----------------------------------------------------------------
            $email_format = file_get_contents(dirname(__FILE__)."/../res/template_reset_password.html");
            $email_format = str_replace("%cognome%", $res["cognome"], $email_format);
            $email_format = str_replace("%nome%", $res["nome"], $email_format);
            $email_format = str_replace("%url_reset%", $url_validazione, $email_format);
            // ****************************************************************

            mailTo($res["email"], "POI - Cambio password", $email_format);
            echo "<p style='text-align:center;'>Ti abbiamo inviato una mail per la procedura di cambio password</p>";
         }
         else {
            echo "<p id='error'>Non siamo riusciti a trovare un account associato a questa mail</p>";
         }
      }
      catch(PDOException $e) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
      }
   }

?>
