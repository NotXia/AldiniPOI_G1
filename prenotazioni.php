<?php
   session_start();

   require_once (dirname(__FILE__)."/util/auth_check.php");
   if(!isLogged()) {
      header("Location:login.php");
   }

   require_once (dirname(__FILE__)."/util/dbconnect.php");

?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title></title>
   </head>
   <body>
      <p>Sei dentro</p>
   </body>
</html>
