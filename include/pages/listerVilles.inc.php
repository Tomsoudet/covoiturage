<?php
	$pdo=new Mypdo();
	$VilleManager = new VilleManager($pdo);
	$villes=$VilleManager->getAllVille();
	?>
  <div class="sstitre"><h2>Liste des villes</h2></div>

<?php
$i = 0;
 ?>



	<table>
		<tr><th>Numéro</th><th>Nom</th></tr>
		<?php
		foreach ($villes as $ville){ ?>

			<tr><td><?php echo $ville->getVilnum();?>
			</td><td><?php echo $ville->getVilnom();?>


			</td></tr>
		<?php $i++; }



  if ($i==0){
    echo "Actuellement aucune ville n'est enregistrée";
  }
  if ($i == 1){
    echo "Actuellement une ville est enregistrée";
  }
  if ($i > 1){
      echo "Actuellement $i villes sont enregistrées";
    }


 ?>

</table>


		<br />
