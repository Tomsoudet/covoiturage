<?php

if (!empty($_SESSION["user"])) {

  $pdo = new Mypdo();
  $ParcoursManager = new ParcoursManager($pdo);
  $VilleManager = new VilleManager($pdo);
  $ProposeManager = new ProposeManager($pdo);
  $PersonneManager = new PersonneManager($pdo);


  if (!empty($_POST["date_dep"]) && !empty($_POST["apartirde"]) && !empty($_POST["vil_ar"]) && !empty($_POST["precision"]) ) {
    if ($_POST["precision"]=="day") {
      $_POST["precision"] = 0;
    }
  $villeDepart= $VilleManager->getVilleNom($_SESSION["numvilledep"]);
  $villeArrivee=$VilleManager->getVilleNom($_POST["vil_ar"]);
  $parcours = $ParcoursManager->getParcours($_SESSION["numvilledep"],$_POST["vil_ar"]);

  $trajets = $ProposeManager->getRechercheTrajets($_POST["date_dep"],$_POST["precision"], $_POST["apartirde"], $parcours->getParNum());
  ?>
  <h1>Rechercher un trajet</h1>
  <table>
    <tr>
      <th>Ville départ</th>
      <th>Ville arrivée</th>
      <th>Date départ</th>
      <th>Heure départ</th>
      <th>Nombre de place(s)</th>
      <th>Nom du covoitureur</th>
    </tr>
  <?php
    foreach ($trajets as $trajet) { ?>
      <tr>
        <td><?php echo $villeDepart?></td>
        <td><?php echo $villeArrivee?></td>
        <td><?php echo $trajet->getProDate()?></td>
        <td><?php echo $trajet->getProTime()?></td>
        <td><?php echo $trajet->getProPlace()?></td>
        <td><acronym title="Moyenne des avis : <?php echo $PersonneManager->getMoyAvis($trajet->getPerNum()) ?> || Dernier avis : <?php echo $PersonneManager->getLastAvis($trajet->getPerNum()) ?>"><?php echo $PersonneManager->getPerByValue($trajet->getPerNum())?></acronym></td>
      </tr>
  <?php } ?>

  </table>
  <?php
  } else {

    if (empty($_POST["vil_dep"])){
      $villesDepart=$ProposeManager->getVilleDépart();
      ?>
      <h1><h1>Rechercher un trajet</h1></h1>
      <form class="" action="#" method="post">
        <label for="vil_dep">Ville de départ :</label>
        <select class="list" name="vil_dep"/>
          <option value="">--Choisissez--</option>
          <?php
          foreach ($villesDepart as $ville){
            echo "<option value=".$ville->getVilNum().">".$ville->getVilNom()."</option>\n";
          } ?>
        </select>
      <input class="inputSubmit" type="submit" value="Valider">
    </form>
    <?php } else {
      $_SESSION["numvilledep"] = $_POST["vil_dep"];
      $villesArrivee=$ParcoursManager->getVillesDestination($_POST["vil_dep"]);
      ?>
      <h1>Rechercher un trajet</h1>
      <form class="" action="#" method="post">
        <div class="left">
          <label for="vil_dep">Ville de départ : </label>
          <?php  echo $VilleManager->getVilleNom($_POST["vil_dep"]);?><br />
          <label for="date_dep">Date de départ : </label>
          <input type="date" class="inputText" name="date_dep" value="<?php echo date('Y-m-d') ?>"/><br />
          <label for="apartirde">A partir de : </label>
          <select class="list" name="apartirde"/>
          <?php for ($i=1; $i<=24; $i++){ ?>
            <option value="<?php echo $i ?>"><?php echo $i ?>h</option>
        <?php   } ?>
        </select>
        </div>
        <div class="right">
          <label for="vil_ar">Ville d'arrivée : </label>
          <select class="list" name="vil_ar"/>
            <option value="">--Choisissez--</option>
            <?php
            foreach ($villesArrivee as $ville){
              echo "<option value=".$ville->getVilNum().">".$ville->getVilNom()."</option>\n";
            } ?>
          </select><br />
          <label for="precision">Précision : </label>
          <select class="list" name="precision"/>
            <option value="day">Ce jour</option>
            <option value="1">+/- 1 jour</option>
            <option value="2">+/- 2 jours</option>
            <option value="3">+/- 3 jours</option>
          </select>
        </div>
        <input class="inputSubmit" type="submit" name="click" value="Valider">
      </form>

    <?php
    }

}
} else {
  ?>
<h1>Acces refusé</h1> <br>
<h2>Vous devez etre connecté pour acceder à cette page</h2>
  <?php
}
?>
