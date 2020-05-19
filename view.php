<?php
   session_start();
   require_once (dirname(__FILE__)."/util/dbconnect.php");
   require_once (dirname(__FILE__)."/util/config.php");
   require_once (dirname(__FILE__)."/util/openday_check.php");

   $cod_permesso = 1;
   if(isset($_SESSION["cod_permesso"])) {
      if($_SESSION["cod_permesso"] == 3) {
         $cod_permesso = 2;
      }
      else {
         if(isset($_SESSION["is_openday"])) {
            if(!isUserValid()) {
               $cod_permesso = 1;
            }
            else {
               $cod_permesso = 2;
            }
         }
         else {
            $cod_permesso = $_SESSION["cod_permesso"];
         }
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

      <title>Prenotazioni</title>

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
               if($_SESSION["cod_permesso"] == 3) {
                  ?>
                     <a class="nav_options" href="./map">Mappa</a>
                     <a class="nav_options" href="./admin/labo/view.php">Indietro</a>
                  <?php
               }
               else {
                  ?>
                     <a class="nav_options" href="./map">Indietro</a>
                  <?php
               }
            ?>
         </div>
      </nav>

      <section id="cover" class="min-vh-100">
          <div id="cover-caption">
              <div class="container">
                  <div class="row text-black">
                      <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center p-4">
                        <?php
                           if(empty($_GET["tag"])) {
                              die("<h3>Si è verificato un errore</h3>");
                           }
                           else {
                              try {
                                 $conn = db_connect();

                                 // Estrae i dati del laboratorio
                                 $sql = "SELECT *
                                         FROM laboratori
                                         WHERE tag = :tag";
                                 $stmt = $conn->prepare($sql);
                                 $stmt->bindParam(":tag", $_GET["tag"], PDO::PARAM_STR, 20);
                                 $stmt->execute();
                                 $res_lab = $stmt->fetch();
                                 if(empty($res_lab)) {
                                    die("<h3>Si è verificato un errore</h3>");
                                 }
                              } catch (PDOException $e) {
                                 die("<h3>Si è verificato un errore</h3>");
                              }
                           }
                        ?>
                        <h1 class="display-4 py-2"><?php echo htmlentities($res_lab["nome"]); ?></h1>
                        <p class="lead"><?php if(!empty($res_lab["descrizione"])) echo htmlentities($res_lab["descrizione"]); ?></p>
                        <p class="lead" style="margin: 0 0 0;"><?php echo "Piano n°".htmlentities($res_lab["piano"]); ?></p>
                        <p class="lead" style="margin: 0 0 0;"><?php if(!empty($res_lab["num_pc"])) echo htmlentities($res_lab["num_pc"])." postazioni"; ?></p>
                        <p class="lead" style="margin: 0 0 0;"><?php if(!empty($res_lab["presenza_lim"])) echo ($res_lab["presenza_lim"]==1 ? "LIM &#10003" : ""); ?></p>
                      </div>
                   </div>

                   <?php
                      try {
                        $sql = "";
                        // Estrae le immagini del laboratorio
                        if($cod_permesso == 2) {
                           $sql = "SELECT *
                           FROM immagini
                           WHERE cod_laboratorio = :tag AND
                                 cod_permesso IN (1, 2)
                           ORDER BY cod_permesso";
                        }
                        else {
                           $sql = "SELECT *
                           FROM immagini
                           WHERE cod_laboratorio = :tag AND
                                 cod_permesso = 1";
                        }
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":tag", $_GET["tag"], PDO::PARAM_STR, 20);
                        $stmt->execute();
                        $res_img = $stmt->fetchAll();
                      } catch (PDOException $e) {
                         die("<h3>Si è verificato un errore</h3>");
                      }
                   ?>

                   <div class="row">
                      <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 mx-auto text-center">

                        <div id="labImages" class="carousel slide" data-ride="carousel">
                           <ol class="carousel-indicators">
                              <?php
                                 $i = 0;
                                 foreach($res_img as $row) {
                                    if($i==0)
                                       echo "<li data-target='#labImages' data-slide-to='0' class='active'></li>";
                                    else
                                       echo "<li data-target='#labImages' data-slide-to='$i'></li>";
                                    $i++;
                                 }
                              ?>
                           </ol>
                           <div class="carousel-inner">
                              <?php
                                 $i = 0;
                                 foreach($res_img as $row) {
                                    $path = $IMAGES_PATH . "/" . $row["percorso"];
                                    $descrizione = nl2br($row["descrizione"]);
                                    if($i==0)
                                       echo "<div class='carousel-item active' align='center'>";
                                    else
                                       echo "<div class='carousel-item' align='center'>";
                                    echo "<img style='width:100%;' src='$path'>
                                          <div class='carousel-caption'>
                                             <div style='background-color:rgba(150, 150, 150, 0.6);padding:0;text-align:center;word-wrap: break-word;'>
                                                <p>$descrizione</p>
                                             </div>
                                          </div>
                                       </div>";
                                    $i++;
                                 }
                              ?>
                           </div>
                           <a class="carousel-control-prev" href="#labImages" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Indietro</span>
                           </a>
                           <a class="carousel-control-next" href="#labImages" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Avanti</span>
                           </a>
                        </div>

                     </div>
                   </div>
               </div>
           </div>
      </section>

   </body>
</html>
