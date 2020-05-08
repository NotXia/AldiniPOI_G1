<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <title>Registrazione</title>

   <!-- Bootstrap -->
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

         <h2>Registrazione</h2>

         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="POST">
            <table>
               <tr>
                  <td id="label">Nome</td>
                  <td><input type="text" name="nome" value="<?php if(isset($_POST['nome'])) echo $_POST['nome'];?>" required></td>
               </tr>
               <tr>
                  <td id="label">Cognome</td>
                  <td><input type="text" name="cognome" value="<?php if(isset($_POST['cognome'])) echo $_POST['cognome'];?>" required></td>
               </tr>
               <tr>
                  <td id="label">Data di nascita</td>
                  <td><input type="date" name="ddn" value="<?php if(isset($_POST['ddn'])) echo $_POST['ddn'];?>" required></td>
               </tr>
               <tr>
                  <td id="label">Email</td>
                  <td><input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" required></td>
               </tr>
               <tr>
                  <td id="label">Password</td>
                  <td>
                     <input id="password" type="password" name="password1" minlength="8" required>
                     <!-- <meter max="3" id="password-strength-meter"></meter> -->
                     <p id="password-strength-text"></p>
                  </td>
               </tr>
               <tr>
                  <td id="label">Conferma password</td>
                  <td><input type="password" name="password2" minlength="8" required></td>
               </tr>
            </table>
            <br>
            <input type="submit" value="Registrati">
         </form>
         <br>

      </div>

   </body>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
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

      password.addEventListener('input', function()
      {
         var val = password.value;
         var result = zxcvbn(val);
         if(val !== "") {
            text.innerHTML = "Efficacia: " + "<strong>" + strength[result.score] + "</strong>";
         }
         else {
            text.innerHTML = "";
         }
      });

   </script>
</html>


<?php

   require "utilities.php";
   require "./lib/phpmailer/mailer.php";

   if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["ddn"]) &&
      isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"])) {

      if(strlen($_POST["password1"]) < 8 || strlen($_POST["password2"]) < 8) {
         echo "<p id='error'>La password è troppo corta</p>";
      }
      else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
         echo "<p id='error'>La mail inserita non è valida</p>";
      }
      else if($_POST["password1"] == $_POST["password2"]) {
         try {
            $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PSW);

            $nome = trim($_POST["nome"]);
            $cognome = trim($_POST["cognome"]);
            $email = strtolower(trim($_POST["email"]));
            $ddn = $_POST["ddn"];
            $pswd = password_hash($_POST["password1"], PASSWORD_DEFAULT);

            // Controlla se l'email inserita è già presente
            $sql = "SELECT COUNT(*) as conta FROM utenti WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
            $stmt->execute();

            $account_check = $stmt->fetch()["conta"];
            if($account_check == 0) {
               // Inserimento utente
               $sql = "INSERT utenti (email, psw, nome, cognome, ddn, verifica_mail, data_creazione, cod_permesso)
                       VALUES(:email, :psw, :nome, :cognome, :ddn, 0, NOW(), 1)"; // 1 = cod permesso base
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
               $stmt->bindParam(":psw", $pswd, PDO::PARAM_STR, 60);
               $stmt->bindParam(":nome", $nome, PDO::PARAM_STR, 100);
               $stmt->bindParam(":cognome", $cognome, PDO::PARAM_STR, 100);
               $stmt->bindParam(":ddn", $ddn);
               $stmt->execute();

               $last_id = $conn->lastInsertId();

               $sql = "SELECT data_creazione FROM utenti WHERE id=$last_id";
               $stmt = $conn->prepare($sql);
               $stmt->execute();

               $data_creazione = $stmt->fetch()["data_creazione"];

               $url_validazione = sprintf(
                  $URL_CONFERMA,
                  $last_id,
                  hash("sha512", $nome.$data_creazione),
                  hash("sha512", $cognome.$data_creazione),
                  hash("sha512", $email.$data_creazione)
               );

               echo $url_validazione;

               $email_format = file_get_contents("./res/templateMail.html");
               $email_format = str_replace("%cognome%", $cognome, $email_format);
               $email_format = str_replace("%nome%", $nome, $email_format);
               $email_format = str_replace("%url_conferma%", $url_validazione, $email_format);

               if(mailTo($email, "POI - Registrazione effettuata con successo", $email_format)){
                  header("Location:success.html");
               }
               else{
                  // TODO Gestite errore invio email
               }
               // FINE - Invio email di conferma
            } // if($account_check == 0)
            else {
               echo "<p id='error'>L'indirizzo email che hai inserito è già in uso</p>";
            }
         }
         catch(PDOException $e) {
            echo "<p id='error'>Qualcosa è andato storto</p>";
         }
      } // if($_POST["password1"] == $_POST["password2"])
      else {
         echo "<p id='error'>Le password non coincidono</p>";
      }
   }

?>
