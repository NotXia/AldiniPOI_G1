<?php

   require "utilities.php";
   require "lib/phpmailer/PHPMailerAutoload.php";

   if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["ddn"]) &&
      isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"])) {

      if($_POST["password1"] == $_POST["password2"]) {
         try {
            $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PSW);

            $nome = trim($_POST["nome"]);
            $cognome = trim($_POST["cognome"]);
            $email = trim($_POST["email"]);
            $ddn = $_POST["ddn"];
            $pswd = password_hash($_POST["password1"], PASSWORD_DEFAULT);

            // Controlla se l'email inserita è già presente
            $sql = "SELECT COUNT(*) as conta FROM utenti WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
            $stmt->execute();

            $account_check = $stmt->fetch()["conta"];
            if($account_check == 0) {
               // Inserimento utente
               $sql = "INSERT utenti VALUES(null, :email, :psw, :nome, :cognome, :ddn, 1)"; // 1 = cod permesso base
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
               $stmt->bindParam(":psw", $pswd, PDO::PARAM_STR, 60);
               $stmt->bindParam(":nome", $nome, PDO::PARAM_STR, 100);
               $stmt->bindParam(":cognome", $cognome, PDO::PARAM_STR, 100);
               $stmt->bindParam(":ddn", $ddn);
               $stmt->execute();

               // Invio email di conferma
               $mail = new PHPMailer;
               $mail->SMTPOptions=array(
                  'ssl'=>array(
                     'verify_peer'=>false,
                     'verify_peer_name'=>false,
                     'allow_self_signed'=>false
                  )
               );
               $mail->isSMTP();
               $mail->SMTPAutoTLS=false;
               $mail->Port=587;
               $mail->SMTPAuth=TRUE;
               $mail->SMTPSecure='tls';
               $mail->Mailer="smtp";
               $mail->SMTPDebug=0;
               $mail->Host='smtp.gmail.com';

               $mail->Username = $EMAIL_CONFERMA;
               $mail->Password = $PSW_CONFERMA;
               $mail->setFrom($EMAIL_CONFERMA, $NOME_CONFERMA);
               $mail->addAddress($email);

               $email_format = file_get_contents("./res/templateMail.html");
               $email_format = str_replace("%cognome%", $cognome, $email_format);
               $email_format = str_replace("%nome%", $nome, $email_format);

               $mail->isHTML(true);
               $mail->Subject = "POI - Registrazione effettuata con successo";
               $mail->Body = $email_format;

               if($mail->send()){
                  header("Location:success.html");
               }
               else{
                  // TODO Gestite errore invio email
               }
               // FINE - Invio email di conferma
            } // if($account_check == 0)
            else {
               echo "<p>L'indirizzo email che hai inserito è già in uso</p>";
            }
         }
         catch(PDOException $e) {
            echo "<p>Qualcosa è andato storto</p>";
         }
      } // if($_POST["password1"] == $_POST["password2"])
      else {
         echo "<p>Le password non coincidono</p>";
      }
   }

?>
