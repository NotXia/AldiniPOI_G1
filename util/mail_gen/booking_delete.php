<?php

   require_once (dirname(__FILE__)."/../config.php");

   function booking_delete_mail($nome, $cognome, $data, $ora_inizio, $ora_fine) {

      // ----------------------------------------------------------------
      // Componimento HTML della mail da inviare
      // ----------------------------------------------------------------
      $email_format = file_get_contents(dirname(__FILE__)."/templates/booking_delete.html");
      $email_format = str_replace("%cognome%", $cognome, $email_format);
      $email_format = str_replace("%nome%", $nome, $email_format);
      $email_format = str_replace("%data%", $data, $email_format);
      $email_format = str_replace("%ora_inizio%", $ora_inizio, $email_format);
      $email_format = str_replace("%ora_fine%", $ora_fine, $email_format);
      // ****************************************************************

      return $email_format;

   }

?>
