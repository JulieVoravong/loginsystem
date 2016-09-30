<?php

//Forbindelse til database serveren med PHP7 mySQLi metoden

//Definer forbindelses-KONSTANTER
define("HOSTNAME", "localhost");
define("MYSQLUSER", "root");
define("MYSQLPASS", "");
define("MYSQLDB", "profiler");

// Her skaber jeg forbindelse til databasen
$connection = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);
// Nu tjekker jeg om jeg får en vellykket forbindelse til databasen
if ($connection->connect_error) {
    // Hvis jeg får en fejl stopperscriptet og udskriver error beskeden
    die('Connect Error ('. $connection->connect_errno .') ' . $connection->connect_error);
}
//Hvis vi har en succesfuld forbindelse bruger vi  UTF8 charset
$connection->set_charset('utf8');

?>
