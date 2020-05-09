<?php

   //
   // CONFIGURAZIONE DATABASE
   //
   $DB_HOST = "localhost";
   $DB_NAME = "aldini_poi";
   $DB_USER = "root";
   $DB_PSW = "";

   //
   // CONFIGURAZIONE EMAIL
   //
   $EMAIL_SERVER = "tcxia.test@gmail.com";
   $PSW_SERVER = "XiaTesting";
   $NOME_SERVER = "Aldini Valeriani";

   /*
      Parametri GET
      id -> id utente in chiaro
      p1 -> hash nome
      p2 -> hash cognome
      p3 -> hash email
   */
   $URL_CONFERMA = "http://localhost/aldini_poi/validation/email.php?id=%d&p1=%s&p2=%s&p3=%s";

   //
   // CONFIGURAZIONE REQUISITI REGISTRAZIONE
   //
   $MIN_PSW_LENGTH = 8;
   $MIN_AGE = 12;

?>
