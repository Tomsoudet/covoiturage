<h1>Ajouter un parcours</h1>
<?php
if (empty($_POST["vil_num1"]) || empty($_POST["vil_num2"]) || empty($_POST["par_km"])){
  $pdo = new Mypdo();
  $villeManager = new VilleManager($pdo);
  $villes = $villeManager->getAllVille();?>
<form action="#" method="post">
  <label for="vil_num1">Ville 1 :</label>
  <select class="list" name="vil_num1"/>
    <option value="">--Selectionner une Ville--</option>
    <?php
    foreach ($villes as $ville){
      echo "<option value=".$ville->getVilNum().">".$ville->getVilNom()."</option>\n";
    } ?>
  </select>
  <label for="vil_num2">Ville 2 :</label>
  <select class="list" name="vil_num2"/>
    <option value="">--Selectionner une Ville--</option>
    <?php
    foreach ($villes as $ville){
      echo "<option value=".$ville->getVilNum().">".$ville->getVilNom()."</option>\n";
    } ?>
  </select>
  <label for="par_km">Nombre de kilomètre(s) : </label>
  <input type="int" class="inputText" name="par_km"/>
  <input type="submit" class="inputSubmit" name="valid_parcours" value="Valider" />
</form>
<?php } else {
  $pdo = new Mypdo();
  $ParcoursManager = new ParcoursManager($pdo);
  $parcours = new Parcours($_POST);
  $retour = $ParcoursManager->add($parcours);

  if ($retour != 0){
    echo "<img class=\"check\" src=\"image/valid.png\" alt=\"Validé\" />";
    echo "Le parcours a été ajouté";
  } else {
    echo "<img class=\"check\" src=\"image/erreur.png\" alt=\"Echec\">";
    echo "Le parcours n'a pas pu être ajouté";
  }
}
?>
