<?php

session_start();

unset($_SESSION['uid']);

echo 'Du er nu logget ud.. Du vil om lidt blive omdirigeret til forsiden :)';

header('Refresh: 2; URL = index.php');

?>
