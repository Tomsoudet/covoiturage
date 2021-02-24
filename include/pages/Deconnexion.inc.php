<?php
if (!empty($_SESSION["user"])) {
	unset($_SESSION["user"]);
	header('Location: index.php?page=0');
} else {
	echo "Vous n'etes pas connecté";
}
?>
