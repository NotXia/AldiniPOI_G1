<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reset password</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
      <link rel="stylesheet" href="./css/reg_feedback_page.css">
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
         <img width="3%" src="../res/logo.png" alt="Logo AV"><br><br>
         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <table>
               <tr>
                  <td id="label">Password</td>
                  <td>
                     <input id="password" type="password" name="password1" minlength="<?php echo htmlentities($MIN_PSW_LENGTH); ?>" required>
                     <p id="password-strength-text"></p>
                  </td>
               </tr>
               <tr>
                  <td id="label">Conferma password</td>
                  <td><input type="password" name="password2" minlength="<?php echo htmlentities($MIN_PSW_LENGTH); ?>" required></td>
               </tr>
            </table>
            <br>
            <input type="submit" name="change_psw" value="Cambia password">
            <input id="strength" type="hidden" name="strength">
            <input type="hidden" name="id" value="<?php echo htmlentities($_GET['id']); ?>">
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
            text.innerHTML = "Efficacia: " + "<strong>" + strength[result.score] + "</strong>";
            document.getElementById('strength').value = result.score;
         }
         else { text.innerHTML = ""; }
      });
   </script>
</html>

<?php

   require (dirname(__FILE__)."/../util/dbconnect.php");

   if(isset($_POST["change_psw"])) {
      if(isset($_POST["id"]) && isset($_POST["password1"]) && isset($_POST["password2"]) && isset($_POST["strength"])) {
         if($_POST["password1"] == $_POST["password2"]) {
            if($_POST["strength"] >= 2) {
               try {
                  $conn = db_connect();
                  $pswd = password_hash($_POST["password1"], PASSWORD_DEFAULT);
                  $id = $_POST["id"];

                  $sql = "UPDATE utenti SET psw = '$pswd' WHERE id = :id";
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                  $stmt->execute();

                  echo "<p style='text-align:center;'>La password è stata impostata con successo</p>";
               }
               catch (PDOException $e) {
                  echo "<p id='error'>Qualcosa è andato storto</p>";
               }
            }
            else {
               echo "<p id='error'>La password è troppo semplice</p>";
            }
         }
         else {
            echo "<p id='error'>Le password non coincidono</p>";
         }
      }
   }

?>
