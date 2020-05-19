<?php
   require_once(dirname(__FILE__)."/util/auth_check.php");
   require_once(dirname(__FILE__)."/util/openday_check.php");

   if(isLogged()) {
      if(isset($_SESSION["is_openday"])) {
         if(!isUserValid()) {
            header("Location:./logout.php");
            exit;
         }
         header("Location:./map");
         exit;
      }
      if($_SESSION["mail_verif"] == 0) {
         header("Location:./mail.php");
         exit;
      }
   }
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
      <link rel="stylesheet" href="css/navbar.css">

      <title>Aldini Valeriani</title>
   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <div class="navbar-brand">
            <a class="navbar-brand nav_nopadding" href="index.php">
               <img class="nav_logo" src="res/logo.png" alt="AV Logo">
               Aldini Valeriani
            </a>
         </div>
         <div align="right">
            <?php
            if(isOpenday()) {
               ?><a class="nav_options" href="openday.php">Open Day</a><?php
            }
            ?>
            <a class="nav_options" href="./map">Visita</a>
            <?php
               if(isLogged()) {
                  if(!isset($_SESSION["is_openday"])) {
                     ?><a class="nav_options" href="./prenotazioni">Prenota</a><?php
                  }
                  ?>
                     <a class="nav_options" href="./logout.php">Esci</a>
                  <?php
               }
               else {
                  ?>
                     <a class="nav_options" href="./login.php">Accedi</a>
                     <a class="nav_options" href="./register.php">Registrati</a>
                  <?php
               }
            ?>
         </div>
      </nav>

      <section id="cover" class="min-vh-100">
          <div id="cover-caption">
              <div class="container">
                  <div class="row text-black">
                      <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 mx-auto text-center p-4">
                        <img width="120px" src="res/logo.png" alt="Logo AV">
                        <h1 class="display-2 py-2 ">Aldini Valeriani</h1>
                        <?php
                        if(isLogged()) {
                           $nome = $_SESSION["nome"];
                           echo "<h2 class='display-4 py-2'>Bentornat@ $nome</h2>";
                        }
                        else {
                           ?>
                           <h2 class="display-4 py-2 ">Benvenut@</h2>
                           <?php
                        }
                        ?>
                      </div>
                   </div>
               </div>
           </div>
      </section>

   </body>
</html>
