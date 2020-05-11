<?php
   session_start();

   require_once (dirname(__FILE__)."/../util/auth_check.php");
   if(isLogged()) {
      if($_SESSION["cod_permesso"] != 2) {
         header("Location:../index.php");
      }
   }
   else {
      header("Location:login.php");
   }
?>
