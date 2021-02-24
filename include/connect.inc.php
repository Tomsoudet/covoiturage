<?php
$db = mysqli_connect('localhost:3308', 'root', 'tomsoudet') or die("Veuillez nous excusez : erreur connection");
mysqli_select_db($db,'covoiturage') or die("Veuillez nous excusez : erreur système");
?>
