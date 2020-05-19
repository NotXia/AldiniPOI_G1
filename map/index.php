<?php
   require_once (dirname(__FILE__)."/../util/auth_check.php");
   require_once (dirname(__FILE__)."/../util/openday_check.php");
   require_once (dirname(__FILE__)."/../util/dbconnect.php");
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
      <link rel="stylesheet" href="../css/navbar.css">
      <link rel="stylesheet" href="../css/form_table.css">
      <link rel="stylesheet" type="text/css" href="../css/map.css">
      <script src="../js/map.js"></script>

      <title>Visita</title>

      <style>
         #rotate {
            /* transform: rotate3d(3, -2, -1.8, -0.15turn); */
            transform: rotate3d(1, 0, 0, -0.23turn) scale(0.6);
            transition: all 1.0s ease-in;
         }
         #rotate2 {
            /* transform: rotate3d(3, -2, -1.8, -0.15turn); */
            transform: rotate3d(1, 0, 0, -0.23turn) scale(0.6);
            transition: all 1.0s ease-in;
         }
         #rotate3 {
            /* transform: rotate3d(3, -2, -1.8, -0.15turn); */
            transform: rotate3d(1, 0, 0, -0.23turn) scale(0.6);
            transition: all 1.0s ease-in;
         }

         body {
            display: table;
            position: absolute;
            height: 100%;
            width: 100%;
         }
      </style>

   </head>

   <body>

      <nav class="navbar navbar-dark bg-primary">
         <div class="navbar-brand">
            <a class="navbar-brand nav_nopadding" href="../index.php">
               <img class="nav_logo" src="../res/logo.png" alt="AV Logo">
               Aldini Valeriani
            </a>
         </div>
         <div align="right">
            <?php
            if(isOpenday()) {
               ?><a class="nav_options" href="../openday.php">Open Day</a><?php
            }
            ?>
            <a class="nav_options" href="index.php">Visita</a>
            <?php
               if(isLogged()) {
                  if(!isset($_SESSION["is_openday"])) {
                     ?><a class="nav_options" href="../prenotazioni">Prenota</a><?php
                  }
                  ?>
                     <a class="nav_options" href="../logout.php">Esci</a>
                  <?php
               }
               else {
                  ?>
                     <a class="nav_options" href="../login.php">Accedi</a>
                     <a class="nav_options" href="../register.php">Registrati</a>
                  <?php
               }
            ?>
         </div>
      </nav>

      <section id="cover" class="min-vh-100">
         <div style="vertical-align: middle;background-color: #ffffff;" class="jumbotron vertical-center">
            <div class="container text-center">
               <div class="row">
                  <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8 mx-auto text-center p-4">
                     <!-- <h1 class="display-4 py-2 text-truncate">Admin</h1> -->
                     <div align="center" class="maptriennio">
                        <svg id="rotate" align="center" width=100% xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1339 468" preserveAspectRatio="xMidYMid meet">

                           <polygon class="cls-1" points="0.5 0.5 0.5 467.5 256.5 467.5 256.5 267.5 338.5 267.5 338.5 389.5 1338.5 387.5 1338.5 87.5 338.5 86.5 338.5 206.5 258.5 206.5 258.5 0.5 0.5 0.5"/>

                           <g id="Informatico">
                              <a onclick="redirect(228)" class="cls-2">
                                 <rect id="_228" data-name="228" x="355.5" y="256.5" width="200" height="115"/>
                                 <text id="t228" class="cls-6" x="416" y="321">Lab 228</text>
                              </a>
                              <a onclick="redirect(221)" class="cls-2">
                                 <rect id="_221" data-name="221" x="519.5" y="98.5" width="300" height="115"/>
                                 <text id="t221" class="cls-6" x="635" y="163">Lab 221</text>
                              </a>
                              <a onclick="redirect(230)" class="cls-2">
                                 <rect id="_230" data-name="230" x="152.5" y="256.5" width="95" height="195"/>
                                 <text id="t230" class="cls-6" transform="translate(209.33 394.24) rotate(-90)">Lab 230</text>
                              </a>
                           </g>

                           <g id="Piano">
                              <a onclick="redirect(226)" class="cls-2">
                                 <rect id="_226" data-name="226" x="561.5" y="256.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(608.33 354.24) rotate(-90)">Aula 226</text>
                              </a>
                              <a onclick="redirect(210)" class="cls-2">
                                 <rect id="_210" data-name="210" x="1195.5" y="256.5" width="130" height="115"/>
                                 <text class="cls-6" transform="translate(1267.33 358.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 210</tspan></text>
                              </a>
                              <a onclick="redirect(227)" class="cls-2">
                                 <rect id="_227" data-name="227" x="152.5" y="23.5" width="95" height="195"/>
                                 <text class="cls-6" transform="translate(212.33 164.24) rotate(-90)">Lab 227</text>
                              </a>
                              <a onclick="redirect(212)" class="cls-2">
                                 <rect id="_212" data-name="212" x="1107.5" y="256.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(1155.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 212</tspan></text>
                              </a>
                              <a onclick="redirect(214)" class="cls-2">
                                 <rect id="_214" data-name="214" x="1020.5" y="256.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(1067.33 358.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 214</tspan></text>
                              </a>
                              <a onclick="redirect(216)" class="cls-2">
                                 <rect id="_216" data-name="216" x="933.5" y="256.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(980.33 358.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 216</tspan></text>
                              </a>
                              <a onclick="redirect(213)" class="cls-2">
                                 <rect id="_213" data-name="213" x="1107.5" y="98.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(1155.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 213</tspan></text>
                              </a>
                              <a onclick="redirect(215)" class="cls-2">
                                 <rect id="_215" data-name="215" x="933.5" y="98.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(980.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 215</tspan></text>
                              </a>
                              <a onclick="redirect(217)" class="cls-2">
                                 <rect id="_217" data-name="217" x="847.5" y="98.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(894.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 217</tspan></text>
                              </a>
                              <a onclick="redirect(211)" class="cls-2">
                                 <rect id="_211" data-name="211" x="1195.5" y="98.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(1242.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 211</tspan></text>
                              </a>
                              <a onclick="redirect(224)" class="cls-2">
                                 <rect id="_224" data-name="224" x="649.5" y="256.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(696.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 224</tspan></text>
                              </a>
                              <a onclick="redirect(222)" class="cls-2">
                                 <rect id="_222" data-name="222" x="736.5" y="256.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(783.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 222</tspan></text>
                              </a>
                              <a onclick="redirect(218)" class="cls-2">
                                 <rect id="_218" data-name="218" x="845.5" y="256.5" width="80" height="115"/>
                                 <text class="cls-6" transform="translate(894.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 218</tspan></text>
                              </a>
                              <a onclick="redirect(232)" class="cls-2">
                                 <rect id="_232" data-name="232" x="10.5" y="256.5" width="125" height="195"/>
                                 <text class="cls-6" transform="translate(80.33 403.24) rotate(-90)">Lab 232</text>
                              </a>
                              <a onclick="redirect(229)" class="cls-2">
                                 <rect id="_229" data-name="229" x="10.5" y="23.5" width="125" height="195"/>
                                 <text class="cls-6" transform="translate(80.33 174.24) rotate(-90)">Lab 229</text>
                              </a>
                           </g>

                        </svg>

                     </div>

                     <div align="center" class="mapbiennio">

                        <svg align="center" id="rotate2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1336 542">

                           <g id="Base">
                              <polygon class="cls-1" points="0.5 446.5 0.5 99.5 994.5 99.5 994.5 235.5 1081.5 235.5 1081.5 0.5 1335.5 0.5 1335.5 541.5 1082.5 541.5 1081.5 303.5 996.5 303.5 996.5 446.5 0.5 446.5"/><path class="cls-2" d="M1302.5,326.5" transform="translate(-23 -118)"/>
                           </g>

                           <g id="labobiennio">
                              <a onclick="redirect(288)" class="cls-2">
                                 <rect id="_288" x="1090.5" y="32.5" width="75" height="185"/>
                                 <text id="t288" class="cls-6" transform="translate(1132.33 164.24) rotate(-90)">Lab 288</text>
                              </a>
                              <a onclick="redirect(290)" class="cls-2">
                                 <rect id="_290"    x="1171.5" y="32.5" width="75" height="185"/>
                                 <text id="t290" class="cls-6" transform="translate(1216.33 164.24) rotate(-90)">Lab 290</text>
                              </a>
                              <a onclick="redirect(292)" class="cls-2">
                                 <rect id="_292" x="1251.5" y="32.5" width="75" height="185"/>
                                 <text id="t292" class="cls-6" transform="translate(1296.33 164.24) rotate(-90)">Lab 292</text>
                              </a>
                              <a onclick="redirect(297b)" class="cls-2">
                                 <rect id="_297b" x="1251.5" y="323.5" width="75" height="185"/>
                                 <text id="t297b" class="cls-6" transform="translate(1296.33 455.24) rotate(-90)">Lab 297b</text>
                              </a>
                           </g>

                           <g id="Livello_2" data-name="Livello 2">
                              <a onclick="redirect(270)" class="cls-2">
                                 <rect id="" x="87.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(135.33 222.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 270</tspan></text>
                              </a>
                              <a onclick="redirect(272)" class="cls-2">
                                 <rect id="" x="181.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(228.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 272</tspan></text>
                              </a>
                              <a onclick="redirect(297b)" class="cls-2">
                                 <rect id="" x="273.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(320.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 274</tspan></text>
                              </a>
                              <a onclick="redirect(276)" class="cls-2">
                                 <rect id="" x="363.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(408.33 222.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 276</tspan></text>
                              </a>
                              <a onclick="redirect(278)" class="cls-2">
                                 <rect id="" x="453.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(501.33 222.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 278</tspan></text>
                              </a>
                              <a onclick="redirect(280)" class="cls-2">
                                 <rect id="" x="544.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(591.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 280</tspan></text>
                              </a>
                              <a onclick="redirect(282)" class="cls-2">
                                 <rect id="" x="635.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(682.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 282</tspan></text>
                              </a>
                              <a onclick="redirect(284)" class="cls-2">
                                 <rect id="" x="725.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(774.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 284</tspan></text>
                              </a>
                              <a onclick="redirect(286)" class="cls-2">
                                 <rect id="" x="817.5" y="115.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(863.33 223.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 286</tspan></text>
                              </a>
                              <a onclick="redirect(273)" class="cls-2">
                                 <rect id="" x="12.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(59.33 408.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 273</tspan></text>
                              </a>
                              <a onclick="redirect(275)" class="cls-2">
                                 <rect id="" x="101.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(148.33 408.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 275</tspan></text>
                              </a>
                              <a onclick="redirect(277)" class="cls-2">
                                 <rect id="" x="189.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(237.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 277</tspan></text>
                              </a>
                              <a onclick="redirect(279)" class="cls-2">
                                 <rect id="" x="279.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(326.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 279</tspan></text>
                              </a>
                              <a onclick="redirect(281)" class="cls-2">
                                 <rect id="" x="368.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(415.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 281</tspan></text>
                              </a>
                              <a onclick="redirect(283)" class="cls-2">
                                 <rect id="" x="460.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(508.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 283</tspan></text>
                              </a>
                              <a onclick="redirect(285)" class="cls-2">
                                 <rect id="" x="551.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(599.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 285</tspan></text>
                              </a>
                              <a onclick="redirect(287)" class="cls-2">
                                 <rect id="" x="643.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(690.33 408.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 287</tspan></text>
                              </a>
                              <a onclick="redirect(289)" class="cls-2">
                                 <rect id="" x="731.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(779.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 289</tspan></text>
                              </a>
                              <a onclick="redirect(291)" class="cls-2">
                                 <rect id="" x="821.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(869.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 291</tspan></text>
                              </a>
                              <a onclick="redirect(293)" class="cls-2">
                                 <rect id="" x="909.5" y="300.5" width="80" height="125"/>
                                 <text class="cls-6" transform="translate(958.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 293</tspan></text>
                              </a>
                              <a onclick="redirect(295)" class="cls-2">
                                 <rect id="" x="1090.5" y="323.5" width="75" height="185"/>
                                 <text class="cls-6" transform="translate(1136.33 455.24) rotate(-90)">Lab 295</text>
                              </a>
                              <a onclick="redirect(297)" class="cls-2">
                                 <rect id="" x="1171.5" y="323.5" width="75" height="185"/>
                                 <text class="cls-6" transform="translate(1216.33 455.24) rotate(-90)">Lab 297</text>
                              </a>
                           </g>

                        </svg>
                     </div>
                  </div>

                  <?php
                     $conn = db_connect();
                  ?>

                  <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 mx-auto p-4 sidebar">

                     <?php
                        try {
                           $sql = "SELECT tag, id_html_map, label_html_map FROM laboratori
                                   WHERE id_html_map IN ('232', '229', '230', '227', '228', '221', '226', '224', '222', '218', '217', '216', '215', '214', '212', '213', '210', '211')";
                           $stmt = $conn->prepare($sql);
                           $stmt->execute();
                           $res_triennio = $stmt->fetchAll();

                           if(!empty($res_triennio)) {
                              echo "<h1 id='labs'>Laboratori Triennio</h1>";
                              foreach($res_triennio as $row) {
                                 $id_html = $row["id_html_map"];
                                 $label_html = $row["label_html_map"];
                                 echo "<a id='s$id_html' onclick='redirect($id_html)'>$label_html</a>";
                              }
                           }
                        } catch (PDOException $e) {
                        }
                     ?>
                     <br>

                     <?php
                        try {
                           $sql = "SELECT tag, id_html_map, label_html_map FROM laboratori
                                   WHERE id_html_map IN ('273', '275', '270', '277', '272', '279', '274', '281', '276', '283',
                                                         '278', '285', '280', '287', '282', '289', '284', '291', '286', '293', '295', '288', '297', '290', '292', '297b')";
                           $stmt = $conn->prepare($sql);
                           $stmt->execute();
                           $res_biennio = $stmt->fetchAll();

                           if(!empty($res_biennio)) {
                              echo "<h1 id='labsb'>Laboratori Biennio</h1>";
                              foreach($res_biennio as $row) {
                                 $id_html = $row["id_html_map"];
                                 $label_html = $row["label_html_map"];
                                 echo "<a id='s$id_html' onclick='redirect($id_html)'>$label_html</a>";
                              }
                           }
                        } catch (PDOException $e) {
                        }
                     ?>

                     <?php
                        try {
                           $sql = "SELECT tag, id_html_map, label_html_map FROM laboratori
                                   WHERE id_html_map NOT IN ('232', '229', '230', '227', '228', '221', '226', '224', '222', '218', '217', '216', '215', '214', '212', '213', '210', '211',
                                                             '273', '275', '270', '277', '272', '279', '274', '281', '276', '283', '278', '285', '280', '287', '282', '289', '284', '291',
                                                             '286', '293', '295', '288', '297', '290', '292', '297b')";
                           $stmt = $conn->prepare($sql);
                           $stmt->execute();
                           $res_altro = $stmt->fetchAll();

                           if(!empty($res_altro)) {
                              echo "<h1>Altri laboratori</h1>";
                              foreach($res_altro as $row) {
                                 $id_html = $row["id_html_map"];
                                 $label_html = $row["label_html_map"];
                                 echo "<a id='s$id_html' onclick='redirect($id_html)'>$label_html</a>";
                              }
                           }
                        } catch (PDOException $e) {
                        }
                     ?>
                  </div>

               </div>
            </div>
         </div>
      </section>
   </body>

   <script type="text/javascript">
   function sleep(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
   }

   async function animate() {
      x = document.getElementById("rotate");
      //await sleep(350);
      // x.style = "transform: rotate3d(1, 0, 0, -0.23turn);";
      x.style = "transform: rotate3d(3, -2, -1.8, -0.15turn);";
   }
   async function animate_2() {
      x = document.getElementById("rotate2");
      //await sleep(350);
      // x.style = "transform: rotate3d(1, 0, 0, -0.23turn);";
      x.style = "transform: rotate3d(3, -2, -1.8, -0.15turn);";
   }
   async function animate_3() {
      x = document.getElementById("rotate3");
      //await sleep(350);
      // x.style = "transform: rotate3d(1, 0, 0, -0.23turn);";
      x.style = "transform: rotate3d(3, -2, -1.8, -0.15turn);";
   }

   animate();
   animate_2();

   </script>

   <script type="text/javascript">
      function redirect (x) {
         switch(x) {
            <?php
               foreach($res_triennio as $row) {
                  $tag = $row["tag"];
                  $id_html = $row["id_html_map"];
                  echo "case $id_html:";
                  echo "window.location.href = '../view.php?tag=$tag';";
                  echo "break;";
               }
               foreach($res_biennio as $row) {
                  $tag = $row["tag"];
                  $id_html = $row["id_html_map"];
                  echo "case $id_html:";
                  echo "window.location.href = '../view.php?tag=$tag';";
                  echo "break;";
               }
               foreach($res_altro as $row) {
                  $tag = $row["tag"];
                  $id_html = $row["id_html_map"];
                  echo "case $id_html:";
                  echo "window.location.href = '../view.php?tag=$tag';";
                  echo "break;";
               }
            ?>

         }
      }
   </script>
</html>
