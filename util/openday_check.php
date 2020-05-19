<?php
   // Inizializza SESSION se non è già stato fatto
   if(!isset($_SESSION)) {
      session_start();
   }

   require_once (dirname(__FILE__)."/config.php");
   require_once (dirname(__FILE__)."/dbconnect.php");

   function isOpenday() : bool {

      $OFFSET_BEFORE_OPENDAY = $GLOBALS["OFFSET_BEFORE_OPENDAY"];
      $OFFSET_AFTER_OPENDAY = $GLOBALS["OFFSET_AFTER_OPENDAY"];

      try {
         $conn = db_connect();

         $sql = "SELECT id
                 FROM visite
                 WHERE DATE(NOW()) = data_inizio AND
                       TIME(NOW()) BETWEEN DATE_ADD(ora_inizio, INTERVAL -$OFFSET_BEFORE_OPENDAY MINUTE) AND DATE_ADD(ora_fine, INTERVAL $OFFSET_AFTER_OPENDAY MINUTE)";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $res = $stmt->fetch();

         if(!empty($res)) {
            return true;
         }
         return false;
      }
      catch (PDOException $e) {
         return false;
      }

   }

   function isUserValid() {
      $OFFSET_BEFORE_OPENDAY = $GLOBALS["OFFSET_BEFORE_OPENDAY"];
      $OFFSET_AFTER_OPENDAY = $GLOBALS["OFFSET_AFTER_OPENDAY"];

      $inizio = date("Y-m-d H:i:s", strtotime("-$OFFSET_BEFORE_OPENDAY minutes", strtotime($_SESSION["ora_inizio"])));
      $fine = date("Y-m-d H:i:s", strtotime("$OFFSET_AFTER_OPENDAY minutes", strtotime($_SESSION["ora_fine"])));

      if(strtotime(date("Y-m-d H:i")) > strtotime($fine) || strtotime(date("Y-m-d H:i")) < strtotime($inizio)) {
         return false;
      }
      else {
         return true;
      }
   }

?>
