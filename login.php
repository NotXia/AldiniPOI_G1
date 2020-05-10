<?php
   session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Login</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
   <link rel="stylesheet" href="./css/form_table.css">
</head>
   <body>

      <div align="center">

         <h2>Login</h2>

         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <table>
               <tr>
                  <td id="label">Email</td>
                  <td id="padding"><input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Password</td>
                  <td id="padding"><input id="password" type="password" name="password" required></td>
               </tr>
            </table>
            <input type="checkbox" name="rememberme" value=""> Ricordami
            <br><br>
            <input type="submit" name="submit" value="Accedi">
            <br>
         </form>
         <a href="./reset_password/request.php">Ho dimenticato la password</a>
         <br>
      </div>
   </body>
</html>


<?php

   require (dirname(__FILE__)."/util/dbconnect.php");
   require (dirname(__FILE__)."/util/config.php");
   require (dirname(__FILE__)."/util/token_gen.php");

   // Verifica che tutti i campi siano impostati
   if(isset($_POST["submit"]) && isset($_POST["email"]) && isset($_POST["password"])) {

      // Verifica che la mail inserita sia in un formato corretto
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
         echo "<p id='error'>La mail inserita non è valida</p>";
      }
      else {
         try {
            $conn = db_connect();

            // ----------------------------------------------------------------
            // Sanitizzazione input
            // ----------------------------------------------------------------
            $email = strtolower(trim($_POST["email"]));
            $pswd = $_POST["password"];
            // ****************************************************************


            // ----------------------------------------------------------------
            // Controlla se l'email inserita è già presente
            // ----------------------------------------------------------------
            $sql = "SELECT id, nome, cognome, email, psw, cod_permesso FROM utenti WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
            $stmt->execute();
            $res = $stmt->fetch();
            // ****************************************************************

            if(isset($res["id"])) {
               if(password_verify($pswd, $res["psw"])) {
                  // Inizializzazione parametri della sessione
                  $_SESSION["id"] = $res["id"];
                  $_SESSION["nome"] = $res["nome"];
                  $_SESSION["cognome"] = $res["cognome"];
                  $_SESSION["email"] = $res["email"];
                  $_SESSION["cod_permesso"] = $res["cod_permesso"];

                  // Inizializza cookie per ricordare l'utente
                  if(isset($_POST["rememberme"])) {
                     $token = token_gen();
                     $selector = token_gen(20);
                     $scadenza = time() + $TIMEOUT_REMEMBER_ME;

                     setcookie("user", "$selector:$token", $scadenza, "/");

                     $token_hash = password_hash($token, PASSWORD_DEFAULT);
                     $ip = $_SERVER['REMOTE_ADDR'];
                     $web_agent = $_SERVER['HTTP_USER_AGENT'];
                     $id = $_SESSION["id"];
                     $giorno_scadenza = date("Y-m-d H:i:s", $scadenza);

                     $sql = "INSERT autenticazioni (token, selector, ip, web_agent, data_scadenza, cod_utente) 
                             VALUES('$token_hash', '$selector', '$ip', '$web_agent', '$giorno_scadenza', $id)";
                     $stmt = $conn->prepare($sql);
                     $stmt->execute();
                  }

                  header("Location:prenotazioni.php");
               }
               else {
                  echo "<p id='error'>Credenziali non corrette</p>";
               }
            } // if(isset($res["id"]))
            else {
               echo "<p id='error'>Credenziali non corrette</p>";
            }
         }
         catch(PDOException $e) {
            echo "<p id='error'>Qualcosa è andato storto</p>";
         }
      }
   }

?>
