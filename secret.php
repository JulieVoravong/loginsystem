<?php

session_start();

//Hvis brugeren er logget på kan man se den hemmelige side

if (!isset($_SESSION['uid'])) {
    echo 'Du er ikke logget på, og derfor kan du ikke se den hemmelige side.. Du vil blive omdirigeret til login siden om lidt.. :)';
    header('Refresh: 2; URL = login.php');
    // Her der bruger man die til at stoppe scriptet 
    die;
}

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hemmelige side</title>
</head>
<body>
    <p>Denne hemmlige besked er yderst hemmelig, den kan kun ses hvis du er logget ind :) </p>
   
   <br>
   <br>
        <a href='logout.php'>Log ud!
    

</body>
</html>
