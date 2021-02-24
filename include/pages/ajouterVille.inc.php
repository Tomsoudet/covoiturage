<?php
	$pdo=new Mypdo();
	$VilleManager = new VilleManager($pdo);
	$ville=$VilleManager->getAllVille();
	?>

<h1>Ajouter une ville</h1>

<?php if(empty($_POST["vil_nom"])){

 ?>
<form class="" action="#" method="post">
  <label for="vil_nom">Nom :</label>
  <input type="text" class="inputText" name="vil_nom" value="">
  <input type="submit" class="inputSubmit" name="valville" value="Valider">
</form>
<?php } else {
	$pdo=new Mypdo();
	$VilleManager = new VilleManager($pdo);
	$ville= new Ville($_POST);
	$retour = $VilleManager->add($ville);

	if($retour != 0) {
		echo "<img class=\"check\" src=\"image/valid.png\" alt=\"Validé\" />";
		echo "La ville <b>".$_POST["vil_nom"]."</b> a été ajoutée";
	} else {
		echo "La ville <b>".$_POST["vil_nom"]."</b> n' a pas été ajoutée";
	}
} ?>
