<?php
   require_once (dirname(__FILE__)."/../util/auth_check.php");
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
            <a class="nav_options" href="index.php">Visita</a>
            <?php
               if(isLogged()) {
                  ?>
                     <a class="nav_options" href="../prenotazioni">Prenota</a>
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

      <section id="cover" class="min-vh-90">
         <div style="vertical-align: middle;background-color: #ffffff;" class="jumbotron vertical-center">
            <div class="container text-center">
               <div class="row">
                  <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8 mx-auto text-center p-4">
                     <!-- <h1 class="display-4 py-2 text-truncate">Admin</h1> -->
                     <div align="center" class="maptriennio">
                        <svg id="rotate" align="center" width=100% xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1339 468" preserveAspectRatio="xMidYMid meet">
                           <polygon class="cls-1" points="0.5 0.5 0.5 467.5 256.5 467.5 256.5 267.5 338.5 267.5 338.5 389.5 1338.5 387.5 1338.5 87.5 338.5 86.5 338.5 206.5 258.5 206.5 258.5 0.5 0.5 0.5"/>
                           <g id="Informatico">
                              <a xlink:title="Lab info  228" xlink:href="./img/1.jpg">
                                 <rect id="_228" data-name="228" class="cls-3" x="355.5" y="256.5" width="200" height="115"/>
                              </a>
                              <a xlink:title="Lab info  221" xlink:href="./img/3.jpg">
                                 <rect id="_221" data-name="221" class="cls-3" x="519.5" y="98.5" width="300" height="115"/>
                              </a>
                              <a xlink:title="Lab Info 230" xlink:href="./img/5.jpg">
                                 <rect id="_230" data-name="230" class="cls-3" x="152.5" y="256.5" width="95" height="195"/>
                              </a>
                              <a xlink:title="Lab info  221" xlink:href="./img/3.jpg">
                                 <text id="t221" class="cls-4" x="635" y="163">Lab 221</text>
                              </a>
                              <a xlink:title="Lab info  228" xlink:href="./img/1.jpg">
                                 <text id="t228" class="cls-4" x="416" y="321">Lab 228</text>
                              </a>
                              <a xlink:title="Lab Info 230" xlink:href="./img/5.jpg">
                                 <text id="t230" class="cls-4" x=212.33 y=397.24>Lab 230</text>
                              </a>
                           </g>
                           <g id="Piano">
                              <rect id="_212" data-name="212" class="cls-2" x="1107.5" y="256.5" width="80" height="115"/>
                              <rect id="_214" data-name="214" class="cls-2" x="1020.5" y="256.5" width="80" height="115"/>
                              <rect id="_216" data-name="216" class="cls-2" x="933.5" y="256.5" width="80" height="115"/>
                              <rect id="_213" data-name="213" class="cls-2" x="1107.5" y="98.5" width="80" height="115"/>
                              <rect id="_215" data-name="215" class="cls-2" x="933.5" y="98.5" width="80" height="115"/>
                              <rect id="_217" data-name="217" class="cls-2" x="847.5" y="98.5" width="80" height="115"/>
                              <rect id="_211" data-name="211" class="cls-2" x="1195.5" y="98.5" width="80" height="115"/>
                              <a xlink:title="Lab info  226" xlink:href="./img/2.jpg">
                                 <rect id="_226" data-name="226" class="cls-2" x="561.5" y="256.5" width="80" height="115"/>
                              </a>
                              <a xlink:title="Aula 5AIN" xlink:href="./img/4.jpg">
                                 <rect id="_210" data-name="210" class="cls-2" x="1195.5" y="256.5" width="130" height="115"/>
                              </a>
                              <a xlink:title="Lab Telecom 227" xlink:href="./img/6.jpg">
                                 <rect id="_227" data-name="227" class="cls-2" x="152.5" y="23.5" width="95" height="195"/>
                              </a>
                              <a xlink:title="Lab info  226" xlink:href="./img/2.jpg">
                                    <text class="cls-6" transform="translate(608.33 354.24) rotate(-90)">Aula 226</text>
                              </a>
                              <a xlink:title="Aula 5AIN" xlink:href="./img/4.jpg">
                                    <text class="cls-6" transform="translate(1267.33 358.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 210</tspan></text>
                              </a>
                              <a xlink:title="Lab Telecom 227" xlink:href="./img/6.jpg">
                                    <text class="cls-6" transform="translate(212.33 164.24) rotate(-90)">Lab 227</text>
                              </a>
                              <rect id="_224" data-name="224" class="cls-2" x="649.5" y="256.5" width="80" height="115"/>
                              <rect id="_222" data-name="222" class="cls-2" x="736.5" y="256.5" width="80" height="115"/>
                              <rect id="_218" data-name="218" class="cls-2" x="845.5" y="256.5" width="80" height="115"/>
                              <rect id="_232" data-name="232" class="cls-2" x="10.5" y="256.5" width="125" height="195"/>
                              <rect id="_229" data-name="229" class="cls-2" x="10.5" y="23.5" width="125" height="195"/>
                              <text class="cls-6" transform="translate(1155.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 212</tspan></text>
                              <text class="cls-6" transform="translate(1067.33 358.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 214</tspan></text>
                              <text class="cls-6" transform="translate(980.33 358.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 216</tspan></text>
                              <text class="cls-6" transform="translate(894.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 218</tspan></text>
                              <text class="cls-6" transform="translate(783.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 222</tspan></text>
                              <text class="cls-6" transform="translate(696.33 359.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 224</tspan></text>
                              <text class="cls-6" transform="translate(894.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 217</tspan></text>
                              <text class="cls-6" transform="translate(980.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 215</tspan></text>
                              <text class="cls-6" transform="translate(1155.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 213</tspan></text>
                              <text class="cls-6" transform="translate(1242.33 200.24) rotate(-90)"><tspan class="cls-5">A</tspan><tspan x="14.4" y="0">ula 211</tspan></text>
                              <text class="cls-6" transform="translate(80.33 174.24) rotate(-90)">Lab 229</text><text class="cls-6" transform="translate(80.33 403.24) rotate(-90)">Lab 232</text>
                           </g>
                        </svg>
                     </div>
                     <div align="center" class="mapbiennio">
                        <svg align="center" id="rotate2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1336 542">
                           <g id="Base">
                              <polygon class="cls-1" points="0.5 446.5 0.5 99.5 994.5 99.5 994.5 235.5 1081.5 235.5 1081.5 0.5 1335.5 0.5 1335.5 541.5 1082.5 541.5 1081.5 303.5 996.5 303.5 996.5 446.5 0.5 446.5"/><path class="cls-2" d="M1302.5,326.5" transform="translate(-23 -118)"/>
                           </g>
                           <g id="labobiennio">
                              <a xlink:title="Lab info 288" xlink:href="./img/7.jpg">
                                 <rect id="_288" class="cls-3" x="1090.5" y="32.5" width="75" height="185"/>
                              </a>
                              <a xlink:title="Lab info 290" xlink:href="./img/8.jpg">
                                 <rect id="_290" class="cls-3" x="1171.5" y="32.5" width="75" height="185"/>
                              </a>
                              <a xlink:title="Lab info 292" xlink:href="./img/9.jpg">
                                 <rect id="_292" class="cls-3" x="1251.5" y="32.5" width="75" height="185"/>
                              </a>
                              <a xlink:title="Lab info 297b" xlink:href="./img/10.jpg">
                                 <rect id="_297b" class="cls-3" x="1251.5" y="323.5" width="75" height="185"/>
                              </a>
                              <a xlink:title="Lab info 288" xlink:href="./img/7.jpg">
                                 <text id="t288" class="cls-4" transform="translate(1136.33 162.24) rotate(-90)">Lab 288</text>
                              </a>
                              <a xlink:title="Lab info 290" xlink:href="./img/8.jpg">
                                 <text id="t290" class="cls-4" transform="translate(1216.33 164.24) rotate(-90)">Lab 290</text>
                              </a>
                              <a xlink:title="Lab info 292" xlink:href="./img/9.jpg">
                                 <text id="t292" class="cls-4" transform="translate(1296.33 164.24) rotate(-90)">Lab 292</text>
                              </a>
                              <a xlink:title="Lab info 297b" xlink:href="./img/10.jpg">
                                 <text id="t297b" class="cls-4" transform="translate(1296.33 455.24) rotate(-90)">Lab 297b</text>
                              </a>
                           </g>
                           <g id="Livello_2" data-name="Livello 2">
                              <rect id="" class="cls-2" x="87.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="181.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="87.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="273.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="363.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="453.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="544.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="635.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="725.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="817.5" y="115.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="12.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="101.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="189.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="279.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="368.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="460.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="551.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="643.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="731.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="821.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="909.5" y="300.5" width="80" height="125"/>
                              <rect id="" class="cls-2" x="1090.5" y="323.5" width="75" height="185"/>
                              <rect id="" class="cls-2" x="1171.5" y="323.5" width="75" height="185"/>
                              <text class="cls-6" transform="translate(1136.33 455.24) rotate(-90)">Lab 295</text>
                              <text class="cls-6" transform="translate(1216.33 455.24) rotate(-90)">Lab 297</text>
                              <text class="cls-6" transform="translate(863.33 223.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 286</tspan></text>
                              <text class="cls-6" transform="translate(774.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 284</tspan></text>
                              <text class="cls-6" transform="translate(682.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 282</tspan></text>
                              <text class="cls-6" transform="translate(591.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 280</tspan></text>
                              <text class="cls-6" transform="translate(501.33 222.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 278</tspan></text>
                              <text class="cls-6" transform="translate(408.33 222.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 276</tspan></text>
                              <text class="cls-6" transform="translate(320.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 274</tspan></text>
                              <text class="cls-6" transform="translate(228.33 224.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 272</tspan></text>
                              <text class="cls-6" transform="translate(135.33 222.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 270</tspan></text>
                              <text class="cls-6" transform="translate(958.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 293</tspan></text>
                              <text class="cls-6" transform="translate(869.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 291</tspan></text>
                              <text class="cls-6" transform="translate(779.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 289</tspan></text>
                              <text class="cls-6" transform="translate(690.33 408.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 287</tspan></text>
                              <text class="cls-6" transform="translate(599.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 285</tspan></text>
                              <text class="cls-6" transform="translate(508.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 283</tspan></text>
                              <text class="cls-6" transform="translate(415.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 281</tspan></text>
                              <text class="cls-6" transform="translate(326.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 279</tspan></text>
                              <text class="cls-6" transform="translate(237.33 407.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 277</tspan></text>
                              <text class="cls-6" transform="translate(148.33 408.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 275</tspan></text>
                              <text class="cls-6" transform="translate(59.33 408.24) rotate(-90)"><tspan class="cls-7">A</tspan><tspan x="14.4" y="0">ula 273</tspan></text>
                           </g>
                        </svg>
                     </div>
                  </div>

                  <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 mx-auto p-4 sidebar">
                     <h1 id="dipartimento">Dipartimento&nbspdi Informatica</h1>
                     <h2 id="labs">Laboratori Triennio</h2>
                     <a id="s221" href="">Lab 221</a>
                     <a id="s228" href="">Lab 228</a>
                     <a id="s230" href="">Lab 230</a>
                     <h2 id="labsb">Laboratori Biennio</h2>
                     <a id="s288" href="">Lab 288</a>
                     <a id="s290" href="">Lab 290</a>
                     <a id="s292" href="">Lab 292</a>
                     <a id="s297b" href="">Lab 297b</a>
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

   animate()
   animate_2()
   </script>
</html>