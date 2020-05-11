<?php
   require (dirname(__FILE__)."/../util/dbconnect.php");
   require (dirname(__FILE__)."/../util/mailer.php");
   require (dirname(__FILE__)."/../util/mail_gen/verification_mail.php");
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
      <link rel="stylesheet" href="../css/reg_feedback_page.css">
      <title>Errore</title>
   </head>
   <body>
      <div id="page_center">
         <img src="../res/logo.png" alt="Logo AV" id="av_header">
         <h1>ERRORE</h1>
         <h4>Si è verificato un errore nel processo di attivazione dell'account</h4>
         <h4>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
               <input type="hidden" name="id" value="<?php echo htmlentities($_GET['id']); ?>">
               Se vuoi ricevere una nuova mail di validazione premi <input type="submit" name="mail_again" value="qui" style="padding:0;border:none;background:none;color:blue">
            </form>
         </h4>
      </div>
   </body>
</html>

<?php

   if(isset($_POST["mail_again"])) {

      $id = $_POST["id"];

      try {
         $conn = db_connect();

         // Estrazione dei dati per formare la mail
         $sql = "SELECT nome, cognome, data_creazione, email FROM utenti WHERE id = :id AND verifica_mail = 0";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
         $stmt->execute();

         $res = $stmt->fetch();
         if(isset($res["email"])) {

            $email_format = verification_mail($id, $res["nome"], $res["cognome"], $res["email"], $res["data_creazione"]);
            mailTo($res["email"], "POI - Verifica email", $email_format);

            header("Location:sent.html");

         }
      }
      catch(PDOException $e) {
      }
   }

?>
