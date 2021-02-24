<?php

if (!empty($_SESSION["user"])) {

  $pdo = new Mypdo();
  $ParcoursManager = new ParcoursManager($pdo);
  $VilleManager = new VilleManager($pdo);
  $PersonneManager = new PersonneManager($pdo);



  if (!empty($_POST["date_dep"]) && !empty($_POST["nb_places"])
  && !empty($_POST["vil_ar"]) && !empty($_POST["heure_dep"]) ) {
    $proposeManager = new ProposeManager($pdo);
    $parcours= $ParcoursManager->getParcours($_SESSION["numvilledep"],$_POST["vil_ar"]);
    $par_num= $parcours->getParNum();
    $per_num= $PersonneManager->getNumByLogin($_SESSION["user"]);
    $pro_date= $_POST["date_dep"];
    $pro_time= $_POST["heure_dep"];
    $pro_place= $_POST["nb_places"];
    if ($_SESSION["numvilledep"]== $parcours->getVilNum1()) {
      $pro_sens= 0;
    }else {
      $pro_sens=1;
    }
    $propose = new Propose(Array("par_num"=>$par_num, "per_num"=>$per_num, "pro_date"=>$pro_date, "pro_time"=>$pro_time, "pro_place"=>$pro_place, "pro_sens"=>$pro_sens));
    $retour = $proposeManager->add($propose);
    echo "<img class=\"check\" src=\"image/valid.png\" alt=\"Validé\" />";
    echo "Le parcours a été ajouté";
  }else {


  if (empty($_POST["vil_dep"])){
    $villesDepart=$ParcoursManager->getVillesDesservies();
    ?>
    <h1>Proposer un trajet</h1>
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
    <h1>Proposer un trajet</h1>
    <form class="" action="#" method="post">
      <div class="left">
        <label for="vil_dep">Ville de départ : </label>
        <?php  echo $VilleManager->getVilleNom($_POST["vil_dep"]);?><br />
        <label for="date_dep">Date de départ : </label>
        <input type="date" class="inputText" name="date_dep" value="<?php echo date('Y-m-d') ?>"/><br />
        <label for="nb_places">Nombre de places : </label>
        <input type="text" class="inputText" name="nb_places"/><br />
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
        <label for="heure_dep">Heure de départ : </label>
        <input type="time" class="inputText" name="heure_dep" value="<?php echo date('H:i') ?>"/><br />
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
