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
      p1 -> hash nome+data_creazione
      p2 -> hash cognome+data_creazione
      p3 -> hash email+data_creazione
      p4 -> hash ultima_modifica_psw+data_creazione
   */
   $URL_CONFERMA = "http://localhost/poi_aldini/validation/email.php?id=%d&p1=%s&p2=%s&p3=%s";
   $URL_RESET_PSW = "http://localhost/poi_aldini/reset_password/verify.php?id=%d&p1=%s&p2=%s&p3=%s&p4=%s";

   //
   // CONFIGURAZIONE REQUISITI REGISTRAZIONE
   //
   $MIN_PSW_LENGTH = 8;
   $MIN_AGE = 0;

   // In minuti
   $TIMEOUT_CHANGE_PSW = 60;

   // In minuti
   $TIMEOUT_REMEMBER_ME = 60 * 60 * 24 * 30;

   //
   // CONFIGURAZIONE IMMAGINI
   //
   $MAX_IMAGE_SIZE = 500000000;
   $IMAGES_PATH = "res/lab_images"; // Relativo alla root

   //
   // CONFIGURAZIONE OPEN DAY
   //
   $OFFSET_BEFORE_OPENDAY = 15; // Le credenziali sono valide X minuti prima
   $OFFSET_AFTER_OPENDAY = 15; // Le credenziali sono valide X minuti dopo

?>
