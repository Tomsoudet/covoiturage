<?php session_start();
date_default_timezone_set('Europe/Paris'); ?>
<!doctype html>
<html lang="fr">

<head>

  <meta charset="utf-8">

<?php
		$title = "Bienvenue sur le site de covoiturage de l'IUT.";?>
		<title>
		<?php echo $title ?>
		</title>
<link rel="icon" href="image/ville.png">
<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>
	<body>
	<div id="header">
		<div id="entete">
			<div class="colonne">
				<a href="index.php?page=0">
					<img src="image/logo.png" alt="Logo covoiturage IUT" title="Logo covoiturage IUT Limousin" />
				</a>
			</div>
			<div class="colonne">
				Covoiturage de l'IUT,<br />Partagez plus que votre véhicule !!!
			</div>
			</div>
			<div id="connect">
        <?php
          if (empty($_SESSION["user"])) { ?>
            <a href="index.php?page=11">Connexion</a>
            <?php
          } else {
            echo $_SESSION["user"] ?><a href="index.php?page=12">  Deconnexion</a>
         <?php
          }
         ?>

			</div>
	</div>
