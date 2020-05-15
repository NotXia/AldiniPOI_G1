<?php

   require_once (dirname(__FILE__)."/../config.php");

   function openday_update_mail($nome, $cognome, $data_old, $ora_inizio_old, $ora_fine_old,
                                                 $data, $ora_inizio, $ora_fine) {

      // ----------------------------------------------------------------
      // Componimento HTML della mail da inviare
      // ----------------------------------------------------------------
      $email_format = file_get_contents(dirname(__FILE__)."/templates/openday_update.html");
      $email_format = str_replace("%cognome%", $cognome, $email_format);
      $email_format = str_replace("%nome%", $nome, $email_format);
      $email_format = str_replace("%data_old%", $data_old, $email_format);
      $email_format = str_replace("%ora_inizio_old%", $ora_inizio_old, $email_format);
      $email_format = str_replace("%ora_fine_old%", $ora_fine_old, $email_format);
      $email_format = str_replace("%data%", $data, $email_format);
      $email_format = str_replace("%ora_inizio%", $ora_inizio, $email_format);
      $email_format = str_replace("%ora_fine%", $ora_fine, $email_format);
      // ****************************************************************

      return $email_format;

   }

?>
