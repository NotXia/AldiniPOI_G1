<?php
   require_once (dirname(__FILE__)."/../util/auth_check.php");
   if(isLogged()) {
      if($_SESSION["cod_permesso"] != 3) {
         header("Location:../index.php");
      }
   }
   else {
      header("Location:login.php");
   }
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title></title>
   </head>
   <body>
      <a href="labo/add.php">Aggiungi laboratorio</a><br>
      <a href="openday/add.php">Aggiungi open day</a>
   </body>
</html>
