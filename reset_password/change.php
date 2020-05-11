<?php
   require (dirname(__FILE__)."/../util/config.php");
   require (dirname(__FILE__)."/../util/dbconnect.php");

   session_start();
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reset password</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
      <link rel="stylesheet" href="../css/form_table.css">
   </head>
   <body>
      <div align="center">
         <img width="3%" src="../res/logo.png" alt="Logo AV"><br><br>
         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <table>
               <tr>
                  <td id="label">Password</td>
                  <td id="padding">
                     <input id="password" type="password" name="password1" minlength="<?php echo htmlentities($MIN_PSW_LENGTH); ?>" required>
                     <p id="password-strength-text" style="display:none;"></p>
                  </td>
               </tr>
               <tr>
                  <td id="label">Conferma password</td>
                  <td id="padding"><input type="password" name="password2" minlength="<?php echo htmlentities($MIN_PSW_LENGTH); ?>" required></td>
               </tr>
            </table>
            <br>
            <input type="submit" name="change_psw" value="Cambia password">
            <input id="strength" type="hidden" name="strength">
            <br><br>
         </form>
      </div>
   </body>

   <script src="../lib/zxcvbn/zxcvbn.js"></script>
   <script>
      var strength = {
         0: "Pessima 😣",
         1: "Debole 😞",
         2: "Mediocre 😐",
         3: "Buona 😃",
         4: "Ottima 😄"
      }
      var password = document.getElementById('password');
      var text = document.getElementById('password-strength-text');

      password.addEventListener('input', function() {
         var val = password.value;
         var result = zxcvbn(val);
         if(val !== "") {
            text.style = "display: block;"
            text.innerHTML = "Efficacia: " + "<strong>" + strength[result.score] + "</strong>";
            document.getElementById('strength').value = result.score;
         }
         else {
            text.style = "display: none;"
            text.innerHTML = "";
         }
      });
   </script>
</html>

<?php

   if(isset($_POST["change_psw"])) {

      //
      // TODO Ulteriore controllo sulla scadenza della richiesta
      //

      // Controlla se tutti i campi sono impostati
      if(!isset($_POST["password1"]) || !isset($_POST["password2"]) || !isset($_POST["strength"])) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
      }

      // Controlla se le due password sono uguali
      else if($_POST["password1"] != $_POST["password2"]) {
         echo "<p id='error'>Le password non coincidono</p>";
      }

      // Controlla se la complessità della password sia accettabile
      else if($_POST["strength"] < 2) {
         echo "<p id='error'>La password è troppo semplice</p>";
      }

      // Evita di far modificare la password più volte
      else if(isset($_SESSION["change_psw_id"])) {
         try {
            $conn = db_connect();
            $pswd = password_hash($_POST["password1"], PASSWORD_DEFAULT);

            // Aggiornamento password e impostazione data richiesta ultima modifica a null
            $sql = "UPDATE utenti SET psw = '$pswd', ultima_modifica_psw = null WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $_SESSION["change_psw_id"], PDO::PARAM_INT);
            $stmt->execute();

            echo "<p id='message'>La password è stata impostata con successo.</p>";
            echo "<p id='message'>Clicca <a href='../login.php'>qui</a> per recarti alla pagina di login</p>";
            $_SESSION["change_psw_id"] = null;
         }
         catch (PDOException $e) {
            echo "<p id='error'>Qualcosa è andato storto</p>";
         }
      }
      else { // if(isset($_SESSION["change_psw_id"]))
         echo "<p id='error'>Si è verificato un errore</p>";
      }

   } // if(isset($_POST["change_psw"]))

?>
