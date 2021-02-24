<?php
	$pdo=new Mypdo();
	$ParcoursManager = new ParcoursManager($pdo);
	$parcours=$ParcoursManager->getAllParcours();
  $VilleManager= new VilleManager($pdo);
	?>
  <div class="sstitre"><h2>Liste des parcours proposés</h2></div>

<?php
$i = 0;
 ?>
	<table>
		<tr><th>Numéro</th><th>Nom ville</th><th>Nom ville</th><th>Nombre de Km</th></tr>
		<?php
		foreach ($parcours as $parcour){ ?>
			<tr><td><?php echo $parcour->getParNum();?>
			</td><td><?php echo $VilleManager->getVilleNom($parcour->getVilNum1());?>
      </td><td><?php echo $VilleManager->getVilleNom($parcour->getVilNum2());?>
      </td><td><?php echo $parcour->getParKm();?>
			</td></tr>

		<?php $i++; }



  if ($i==0){
    echo "Actuellement aucun parcours n'est enregistré";
  }
  if ($i == 1){
    echo "Actuellement un parcours est enregistré";
  }
  if ($i > 1){
      echo "Actuellement $i parcours sont enregistrés";
    }


 ?>

</table>
		<br />
