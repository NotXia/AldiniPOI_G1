<?php
   require_once (dirname(__FILE__)."/../util/auth_check.php");
   if(isLogged()) {
      if($_SESSION["cod_permesso"] != 3) {
         header("Location:../index.php");
      }
   }
   else {
      header("Location:login.php");
   }

   require_once (dirname(__FILE__)."/../util/dbconnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Aggiungi laboratorio</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/form_table.css">
</head>
   <body>

      <div align="center">

         <h2>Aggiungi laboratorio</h2>

         <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <h3>Informazioni</h3>
            <table>
               <tr>
                  <td id="label">Tag</td>
                  <td id="padding"><input type="text" name="tag" value="<?php if(isset($_POST['tag'])) echo $_POST['tag']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Nome</td>
                  <td id="padding"><input type="text" name="nome" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Piano</span></td>
                  <td id="padding"><input type="number" min="0" max="3" name="piano" value="<?php if(isset($_POST['piano'])) echo $_POST['piano']; ?>" required></td>
               </tr>
               <tr>
                  <td id="label">Numero posti</td>
                  <td id="padding"><input type="number" min="0" name="numposti" value="<?php if(isset($_POST['numposti'])) echo $_POST['numposti']; ?>"></td>
               </tr>
               <tr>
                  <td id="label">Numero PC</td>
                  <td id="padding"><input type="number" min="0" name="numpc" value="<?php if(isset($_POST['numpc'])) echo $_POST['numpc']; ?>"></td>
               </tr>
               <tr>
                  <td id="label">Presenza LIM</td>
                  <td id="padding"><input type="checkbox" name="lim"></td>
               </tr>
               <tr>
                  <td id="label">Descrizione</td>
                  <td id="padding"><textarea name="descrizione" rows="5" value="<?php if(isset($_POST['descrizione'])) echo $_POST['descrizione']; ?>"></textarea></td>
               </tr>
            </table>
            <td><input type="submit" id="submit" name="submit" value="Inserisci"></td>

         </form>
      </div>
   </body>
</html>


<?php

   if(isset($_POST["submit"])) {

      // Controlla che tutti i campi obbligatori siano impostati
      if(!empty($_POST["tag"]) && !empty($_POST["nome"]) && !empty($_POST["piano"])) {
         try {
            $lim = isset($_POST["lim"]) ? 1 : 0;

            $conn = db_connect();
            $sql = "INSERT laboratori (tag, nome, piano, num_posti, num_pc, presenza_lim, descrizione)
                    VALUES(:tag, :nome, :piano, :num_posti, :num_pc, :presenza_lim, :descrizione)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":tag", $_POST["tag"], PDO::PARAM_STR, 20);
            $stmt->bindParam(":nome", $_POST["nome"], PDO::PARAM_STR, 100);
            $stmt->bindParam(":piano", $_POST["piano"], PDO::PARAM_INT);
            $stmt->bindParam(":num_posti", $_POST["numposti"], PDO::PARAM_INT);
            $stmt->bindParam(":num_pc", $_POST["numpc"], PDO::PARAM_INT);
            $stmt->bindParam(":presenza_lim", $lim);
            $stmt->bindParam(":descrizione", $_POST["descrizione"], PDO::PARAM_STR, 500);
            $stmt->execute();

            $tag = $_POST["tag"];

            // Pagina per inserire immagini
            header("Location:add_images.php?tag=$tag");

         } catch (PDOException $e) {
            echo "<p>Si è verificato un errore</p>";
         }

      }
   }

?>
