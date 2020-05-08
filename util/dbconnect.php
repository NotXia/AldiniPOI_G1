<?php

   require (dirname(__FILE__)."/config.php");

   function db_connect() {
      $host = $GLOBALS["DB_HOST"];
      $db = $GLOBALS["DB_NAME"];
      $user = $GLOBALS["DB_USER"];
      $psw = $GLOBALS["DB_PSW"];

      return new PDO("mysql:host=$host;dbname=$db", $user, $psw);
   }

?>
