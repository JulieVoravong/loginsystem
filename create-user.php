<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Opret bruger</title>
</head>
<body>
    <?php
        
        $resultat = '';
        // Her tjekker jeg om formen er indsendt
        if (isset($_POST['opretbruger'])) {
            
        // Her valdideres formen, feks. at der skal være @ i email(http://php.net/manual/en/filter.filters.validate.php)
            $name = filter_input(INPUT_POST, 'Navn');
            $username = filter_input(INPUT_POST, 'Brugernavn');
            $password = filter_input(INPUT_POST, 'Password');
            $email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
            // Nu tjekker om jeg får fejl. Hvis man får en fejl går die igang og teksten som står efter die kommer frem.
            if (empty($name) || is_string($name) == false) {
                die('Vær sød at skriv et gyldigt navn!');
            }
            if (empty($username) || is_string($username) == false) {
                die('Vær sød at skriv et gyldigt brugernavn!');
            }
            if (empty($password)) {
                die('Vær sød at skriv et gyldigt password!');
            }
            if (empty($email) || $email == false) {
                die('Vær sød at skriv en gyldigt email!');
            }
            // Nu hasher jeg passwordet som gør at jeg ikke kan se brugerens password i databasen
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Her laver jeg en forbindelse til databasen og  brugeren lagt i databasen 
            require_once('dbcon.php');
            $insertNewUser = 'INSERT INTO users (Navn, Brugernavn, Password, Email) VALUES (?,?,?,?)';
            $statement = $connection->prepare($insertNewUser);
            $statement->bind_param('ssss', $name, $username, $hashedPassword, $email);
            $statement->execute();
            
            if ($statement->affected_rows > 0) {
                $resultat = 'Succes! Mange tak '. $name . ' for din subscription!';
            } else {
                $resultat = 'Det her brugernavn "'. $username .'" findes allerede! Vær sød at vælge et andet!';
            }
            
            $statement->close();
            
            $connection->close();

        }
    ?>
    <p><?php echo $resultat; ?></p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
        <p><input type="text" name="Navn" placeholder="Navn"></p>
        <p><input type="text" name="Brugernavn" placeholder="Brugernavn"></p>
        <p><input type="text" name="Password" placeholder="Password"></p>
        <p><input type="text" name="Email" placeholder="Email"></p>
        <input type="submit" name="opretbruger" value="Opret bruger">
    </form>
    
    <br>
    <br>
    <a href='index.php'>Gå tilbage til forsiden</a>
</body>
</html>
