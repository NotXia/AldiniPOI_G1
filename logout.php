<?php

      session_start();
      session_unset();
      session_destroy();

      setcookie("user", "", time()-1; "/");

?>


<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Logout</title>
   </head>
   <body>
      <p>Sei fuori</p>
   </body>
</html>
