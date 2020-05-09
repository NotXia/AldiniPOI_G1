<?php
   session_start();
   if(!isset($_SESSION["cod_permesso"])) {
      header("Location:login.php");
   }
   else if($_SESSION["cod_permesso"] != 2) {
      header("Location:../index.php");
   }
?>
