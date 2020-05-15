<?php

      session_start();
      session_unset();
      session_destroy();

      setcookie("user", "", time()-1, "/");

      header("Location:login.php");

?>
