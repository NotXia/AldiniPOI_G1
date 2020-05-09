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
   <style>
      td {
         padding: 1.7px;
      }
      td#label {
         text-align: right;
      }
      p#error {
         color: red;
         text-align: center;
      }
   </style>
</head>
   <body>

      <div align="center">

         <h2>Login</h2>

         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <table>
               <tr>
                  <td id="label">Email</td>
                  <td><input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Password</td>
                  <td><input id="password" type="password" name="password" required></td>
               </tr>
            </table>
            <br>
            <input type="submit" name="submit" value="Accedi">
            <br><br>
         </form>
         <a href="./reset_password/request.php">Ho dimenticato la password</a>
         <br>
      </div>
   </body>
</html>


<?php

   require (dirname(__FILE__)."/util/dbconnect.php");

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
            $sql = "SELECT id, nome, cognome, email, psw FROM utenti WHERE email = :email";
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
                  header("Location:index.php");
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
