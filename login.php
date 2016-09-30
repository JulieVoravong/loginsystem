<?php

session_start();

// Hvis brugeren er logget på vil vi ikke vise login.php
if (isset($_SESSION['uid'])) {
   echo 'Du er allerede logget ind. Du vil nu blive omdirigeret til den hemmelige side, som kun kan ses når man er logget på.';
   header('Refresh: 2; URL = secret.php');
}

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Log på</title>
</head>
<body>
    <?php
        
        $resultat = '';
        
       		if (isset($_POST['login'])) {
            
            $username = filter_input(INPUT_POST, 'Brugernavn');
            $password = filter_input(INPUT_POST, 'Password');
          
            if (empty($username) || is_string($username) == false) {
                die('Vær sød at skrive et gyldigt brugernavn!');
            }
            if (empty($password)) {
                die('Vær sød at skrive dit password!');
            }
            // Hvis brugeren er fin så loader den database forbindelsen
            require_once('dbcon.php');
            // Her tager man brugeren fra databasen 
            $getUser = 'SELECT id, Navn, password, email FROM users WHERE Brugernavn = ?';
            $statement = $connection->prepare($getUser);
            $statement->bind_param('s', $username);
            $statement->execute();
            $statement->bind_result($uid, $name, $hashedPassword, $email);
            $statement->fetch();
          
            $statement->close();
            // Her der tjekker man om der er en bruger med det brugernavn
            if (!$uid) {
                die('Denne bruger"'. $username .'" findes desværre ikke!');
            }
            // Hvis der findes en bruger med det navn, så sammenligner man med passwordet 
            if (!password_verify($password, $hashedPassword)) {
                die('Denne bruger "'. $username .'" eksisterer men det er forkert password!');
            }
            // Hvis man finder et macht logger den ind
            $_SESSION['uid'] = $uid;
            $resultat = 'Hej '. $name .'! Du er nu logget på!';
            
            $connection->close();
        }
    ?>
    <p><?php echo $resultat; ?></p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
        <input type="text" name="Brugernavn" placeholder="Brugernavn">
        <input type="text" name="Password" placeholder="Password">
        <input type="submit" name="login" value="Log på">
    </form>
    
    <br>
    <br>
    	<a href='secret.php'>Gå til den hemmelige side!</a>
        <br>
        <br>
       <a href='index.php'>Gå tilbage til forsiden!
       
</body>
</html>
