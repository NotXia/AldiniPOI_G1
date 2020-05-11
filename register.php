<?php
   require_once (dirname(__FILE__)."/util/auth_check.php");
   if(isLogged()) {
      header("Location:index.php");
   }

   require_once (dirname(__FILE__)."/util/config.php");
   require_once (dirname(__FILE__)."/util/dbconnect.php");
   require_once (dirname(__FILE__)."/util/mailer.php");
   require_once (dirname(__FILE__)."/util/mail_gen/verification_mail.php");

   $min_birth=date_create(date("Y-m-d"));
   date_add($min_birth, date_interval_create_from_date_string("-$MIN_AGE years"));
   $min_birth = date_format($min_birth,"Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Registrazione</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
   <link rel="stylesheet" href="./css/form_table.css">
</head>
   <body>

      <div align="center">

         <h2>Registrazione</h2>

         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <table>
               <tr>
                  <td id="label">Nome</td>
                  <td id="padding"><input type="text" name="nome" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Cognome</td>
                  <td id="padding"><input type="text" name="cognome" value="<?php if(isset($_POST['cognome'])) echo $_POST['cognome']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Data di nascita</td>
                  <td id="padding"><input type="date" name="ddn" max="<?php echo htmlentities($min_birth); ?>" value="<?php if(isset($_POST['ddn'])) echo $_POST['ddn']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Email</td>
                  <td id="padding"><input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required></td>
               </tr>
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
            <input type="submit" name="submit" value="Registrati">
            <input id="strength" type="hidden" name="strength" value="">
         </form>
         <br>

      </div>

   </body>
   <script src="./lib/zxcvbn/zxcvbn.js"></script>
   <script src="./js/psw_strength.js"></script>
</html>


<?php



   if(isset($_POST["submit"])) {

      // Verifica che tutti i campi siano impostati
      if(!isset($_POST["submit"]) || !isset($_POST["nome"]) || !isset($_POST["cognome"]) || !isset($_POST["ddn"]) ||
         !isset($_POST["email"]) || !isset($_POST["password1"]) || !isset($_POST["password2"]) || !isset($_POST["strength"])) {
         echo "<p id='error'>Qualcosa è andato storto</p>";
      }
      // Verifica l'età minima
      else if(strtotime($_POST["ddn"]) > strtotime($min_birth)) {
         echo "<p id='error'>Devi avere almeno $MIN_AGE anni per iscriverti, puoi chiedere ad un genitore di iscriverti per te</p>";
      }
      // Verifica che la password soddisfi la dimensione minima
      else if(strlen($_POST["password1"]) < $MIN_PSW_LENGTH || strlen($_POST["password2"]) < $MIN_PSW_LENGTH) {
         echo "<p id='error'>La password è troppo corta</p>";
      }
      // Verifica che la mail inserita sia in un formato corretto
      else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
         echo "<p id='error'>La mail inserita non è valida</p>";
      }
      // Verifica che la complessità della password sia accettabile
      else if($_POST["strength"] < 2) {
         echo "<p id='error'>La password è troppo debole</p>";
      }
      // Verifica che le due password coincidano
      else if($_POST["password1"] == $_POST["password2"]) {
         try {
            $conn = db_connect();

            // ----------------------------------------------------------------
            // Sanitizzazione input
            // ----------------------------------------------------------------
            $nome = trim($_POST["nome"]);
            $cognome = trim($_POST["cognome"]);
            $email = strtolower(trim($_POST["email"]));
            $ddn = $_POST["ddn"];
            $pswd = password_hash($_POST["password1"], PASSWORD_DEFAULT);
            // ****************************************************************


            // ----------------------------------------------------------------
            // Controlla se l'email inserita è già presente
            // ----------------------------------------------------------------
            $sql = "SELECT COUNT(*) as conta FROM utenti WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
            $stmt->execute();
            $account_check = $stmt->fetch()["conta"]; // Numero di utenti con quella mail (0 o 1)
            // ****************************************************************


            if($account_check == 0) { // Email non presente
               // ----------------------------------------------------------------
               // Inserimento utente
               // ----------------------------------------------------------------
               $sql = "INSERT utenti (email, psw, nome, cognome, ddn, verifica_mail, data_creazione, cod_permesso)
               VALUES(:email, :psw, :nome, :cognome, :ddn, 0, NOW(), 1)"; // 1 = cod_permesso base
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(":email", $email, PDO::PARAM_STR, 100);
               $stmt->bindParam(":psw", $pswd, PDO::PARAM_STR, 60);
               $stmt->bindParam(":nome", $nome, PDO::PARAM_STR, 100);
               $stmt->bindParam(":cognome", $cognome, PDO::PARAM_STR, 100);
               $stmt->bindParam(":ddn", $ddn);
               $stmt->execute();
               // ****************************************************************

               // ID dell'utente appena inserito
               $last_id = $conn->lastInsertId();

               // ----------------------------------------------------------------
               // Estrazione data e ora creazione utente
               // ----------------------------------------------------------------
               $sql = "SELECT data_creazione FROM utenti WHERE id = $last_id";
               $stmt = $conn->prepare($sql);
               $stmt->execute();
               $data_creazione = $stmt->fetch()["data_creazione"];
               // ****************************************************************


               // ----------------------------------------------------------------
               // Invio della mail per verificare la mail
               // ----------------------------------------------------------------
               $email_format = verification_mail($last_id, $nome, $cognome, $email, $data_creazione);

               if(mailTo($email, "POI - Registrazione effettuata con successo", $email_format)){
                  header("Location:success.html");
               }
               else{
                  // TODO Gestire errore invio email
               }
               // ****************************************************************

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
