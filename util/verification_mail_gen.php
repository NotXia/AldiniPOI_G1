<?php

   require (dirname(__FILE__)."/config.php");

   function verification_mail($id, $nome, $cognome, $email, $data_creazione) {

      $url_conferma = $GLOBALS["URL_CONFERMA"];

      // ----------------------------------------------------------------
      // Componimento URL per la validazione della mail
      // ----------------------------------------------------------------
      $url_validazione = sprintf(
         $url_conferma,
         $id,
         hash("sha512", $nome.$data_creazione),
         hash("sha512", $cognome.$data_creazione),
         hash("sha512", $email.$data_creazione)
      );
      // ****************************************************************

      // ----------------------------------------------------------------
      // Componimento HTML della mail da inviare
      // ----------------------------------------------------------------
      $email_format = file_get_contents(dirname(__FILE__)."/../res/template_verification_mail.html");
      $email_format = str_replace("%cognome%", $cognome, $email_format);
      $email_format = str_replace("%nome%", $nome, $email_format);
      $email_format = str_replace("%url_conferma%", $url_validazione, $email_format);
      // ****************************************************************

      return $email_format;

   }

?>
