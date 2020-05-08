<?php

   require "PHPMailerAutoload.php";

   function mailTo($destinatario, $oggetto, $corpo) {
      $EMAIL_CONFERMA = "tcxia.test@gmail.com";
      $PSW_CONFERMA = "XiaTesting";
      $NOME_CONFERMA = "Aldini Valeriani";

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
      $mail->addAddress($destinatario);

      $mail->isHTML(true);
      $mail->Subject = $oggetto;
      $mail->Body = $corpo;

      return $mail->send();
   }

?>
