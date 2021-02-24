<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);
$personnes = $personneManager->getAllPersonne();
if (empty($_POST["click"])){?>
<h1>Liste des personnes proposés</h1>
<table>
  <tr>
    <th>Numéro</th>
    <th>Nom</th>
    <th>Prénom</th>
  </tr>
  <?php $i = 0; ?>
  <form action="#" method="post">
  <?php foreach ($personnes as $personne){ ?>
    <tr><td><input class="false_a" type="submit" name="click" value="<?php echo $personne->getPerNum();?>"></td>
    <td><?php echo $personne->getPerNom();?></td>
    <td><?php echo $personne->getPerPrenom();?></td>
    </tr>
    <?php $i++ ?>
  <?php } ?>
  </form>
  <?php if ($i == 0){
    echo "Actuellement aucune personne n'est enregistrée";
  }
  if ($i == 1){
    echo "Actuellement $i personne est enregistrée";
  }
  if ($i > 1){
    echo "Actuellement $i personnes sont enregistrées";
  } ?>
</table>
<?php } else if ($personneManager->isSalarie($_POST["click"])){
  $pdo = new Mypdo();
  $personneManager = new PersonneManager($pdo);
  $salarie = $personneManager->infoSalarie($_POST["click"]); ?>
  <h1>Détail sur le salarié <?php echo $personneManager->getPerNomByValue($_POST["click"]) ?></h1>
  <table>
    <tr>
      <th>Prénom</th>
      <th>Mail</th>
      <th>Tel</th>
      <th>Tel Pro</th>
      <th>Fonction</th>
    </tr>
    <tr>
      <td><?php echo $salarie[0]; ?></td>
      <td><?php echo $salarie[1]; ?></td>
      <td><?php echo $salarie[2]; ?></td>
      <td><?php echo $salarie[3]; ?></td>
      <td><?php echo $salarie[4]; ?></td>
    </tr>
    </table>
<?php } else {
  $pdo = new Mypdo();
  $personneManager = new PersonneManager($pdo);
  $etudiant = $personneManager->infoEtudiant($_POST["click"]); ?>
  <h1>Détail sur l'étudiant <?php echo $personneManager->getPerNomByValue($_POST["click"]) ?></h1>
  <table>
    <tr>
      <th>Prénom</th>
      <th>Mail</th>
      <th>Tel</th>
      <th>Departement</th>
      <th>Ville</th>
    </tr>
    <tr>
      <td><?php echo $etudiant[0]; ?></td>
      <td><?php echo $etudiant[1]; ?></td>
      <td><?php echo $etudiant[2]; ?></td>
      <td><?php echo $etudiant[3]; ?></td>
      <td><?php echo $etudiant[4]; ?></td>
    </tr>
    </table>
<?php } ?>
