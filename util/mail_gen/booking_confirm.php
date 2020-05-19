<?php

   function booking_confirm_mail($nome, $cognome, $data, $ora_inizio, $ora_fine, $dispositivo) {

      $str_dispositivo = $dispositivo ?
         "Il dispositivo da te richiesto &#232; disponibile e ti &#232; stato assegnato." :
         "Nessun dispositivo &#232; disponibile nella data da te scelta.";

      $box_dispositivo = $dispositivo ? "&#10003;" : "&#10005;";

      // ----------------------------------------------------------------
      // Componimento HTML della mail da inviare
      // ----------------------------------------------------------------
      $email_format = file_get_contents(dirname(__FILE__)."/templates/booking_confirm.html");
      $email_format = str_replace("%cognome%", $cognome, $email_format);
      $email_format = str_replace("%nome%", $nome, $email_format);
      $email_format = str_replace("%data%", $data, $email_format);
      $email_format = str_replace("%ora_inizio%", $ora_inizio, $email_format);
      $email_format = str_replace("%ora_fine%", $ora_fine, $email_format);
      $email_format = str_replace("%richiesta_dispositivo%", $str_dispositivo, $email_format);
      $email_format = str_replace("%richiesta_dispositivo_box%", $box_dispositivo, $email_format);
      // ****************************************************************

      return $email_format;

   }

?>
