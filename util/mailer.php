<?php

   require_once (dirname(__FILE__)."/../lib/phpmailer/PHPMailerAutoload.php");
   require_once (dirname(__FILE__)."/config.php");

   function mailTo($destinatario, $oggetto, $corpo) {
      $email_mitt = $GLOBALS["EMAIL_SERVER"];
      $psw_mitt = $GLOBALS["PSW_SERVER"];
      $nome_mitt = $GLOBALS["NOME_SERVER"];

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

      // Configurazione mittente
      $mail->Username = $email_mitt;
      $mail->Password = $psw_mitt;
      $mail->setFrom($email_mitt, $nome_mitt);

      // Configurazione destinatario
      $mail->addAddress($destinatario);

      // Configurazione messaggio
      $mail->isHTML(true);
      $mail->Subject = $oggetto;
      $mail->Body = $corpo;

      return $mail->send();
   }

?>
