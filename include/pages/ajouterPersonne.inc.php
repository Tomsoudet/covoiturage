<?php
if ((empty($_POST["per_nom"]) || empty($_POST["per_prenom"]) || empty($_POST["per_tel"]) || empty($_POST["per_mail"]) || empty($_POST["per_login"]) || empty($_POST["per_pwd"]) || empty($_POST["per_cat"]))
&& (empty($_POST["div_num"]) || empty($_POST["dep_num"])) && (empty($_POST["sal_telprof"]) || empty($_POST["fon_num"]))){
  $pdo = new Mypdo();
  $personneManager = new PersonneManager($pdo);
  $personnes = $personneManager->getAllPersonne();?>
<h1>Ajouter une personne</h1>
<form action="#" method="post">
  <div class="left">
    <label for="per_nom">Nom : </label>
    <input type="text" class="inputText" name="per_nom"/><br />
    <label for="per_tel">Telephone : </label>
    <input type="tel" class="inputText" name="per_tel"/><br />
    <label for="per_login">Login : </label>
    <input type="text" class="inputText" name="per_login"/><br />
  </div>
  <div class="right">
    <label for="per_prenom">Prenom : </label>
    <input type="text" class="inputText" name="per_prenom"/><br />
    <label for="per_mail">Mail : </label>
    <input type="email" class="inputText" name="per_mail"/><br />
    <label for="per_pwd">Mot de Passe : </label>
    <input type="password" class="inputText" name="per_pwd"/><br /><br />
  </div>
  <label for="per_cat">Catégorie :</label>
  <input type="radio" class="" name="per_cat" value="per_etu"/>
  <label for="per_etu">Etudiant</label>
  <input type="radio" class="" name="per_cat" value="per_pers"/>
  <label for="per_pers">Personnel</label><br /><br />
  <input type="submit" class="inputSubmit" name="valid_personne" value="Valider" />
</form>
<?php } else if (!empty($_POST["per_cat"])) {
  $personne = new Personne($_POST);
  $_SESSION["pers"] = serialize($personne);
  $_SESSION["per_cat"] = $_POST["per_cat"];
  if ($_POST["per_cat"] == "per_etu" && (empty($_POST["div_num"]) || empty($_POST["dep_num"]))) {
    $pdo = new Mypdo();
    $divisionManager = new divisionManager($pdo);
    $divisions = $divisionManager->getAllDivision();
    $departementManager = new departementManager($pdo);
    $departements = $departementManager->getAllDepartement();?>
    <h1>Ajouter un étudiant</h1>
    <form action="#" method="POST">
      <label for="div_num">Année :</label>
      <select class="list" name="div_num"/>
        <option value="">--Selectionner une Année--</option>
        <?php
        foreach ($divisions as $division){
          echo "<option value=".$division->getDivNum().">".$division->getDivNom()."</option> \n";
        } ?>
      </select><br /><br />
      <label for="dep_num">Département :</label>
      <select class="list" name="dep_num"/>
        <option value="">--Selectionner un Département--</option>
        <?php
        foreach ($departements as $departement){
          echo "<option value=".$departement->getDepNum().">".$departement->getDepNom()."</option> \n";
        } ?>
      </select><br /><br />
      <input type="submit" class="inputSubmit" name="valid_personne" value="Valider" />
    </form>
  <?php } else if ($_POST["per_cat"] == "per_pers" && (empty($_POST["sal_telprof"]) || empty($_POST["fon"]))) {
    $pdo = new Mypdo();
    $fonctionManager = new fonctionManager($pdo);
    $fonctions = $fonctionManager->getAllFonction();?>
    <h1>Ajouter un salarié</h1>
    <form action="#" method="POST">
      <label for="sal_telprof">Téléphone professionnel :</label>
      <input type="tel" class="inputText" name="sal_telprof"/><br /><br />
      <label for="fon_num">Fonction :</label>
      <select class="list" name="fon_num"/>
        <option value="">--Selectionner une Fonction--</option>
        <?php
        foreach ($fonctions as $fonction){
          echo "<option value=".$fonction->getFonNum().">".$fonction->getFonLibelle()."</option> \n";
        } ?>
      </select><br /><br />
      <input type="submit" class="inputSubmit" name="valid_personne" value="Valider" />
    </form>
  <?php }
    } else {
    $pdo = new Mypdo();
    $personneManager = new PersonneManager($pdo);
    $personne = unserialize($_SESSION["pers"]);
    $retour = $personneManager->add($personne);
    $_POST["per_num"] = $personneManager->getPerNumByValue($personne->getPerNom(),$personne->getPerPrenom(),$personne->getPerTel(),$personne->getPerMail(),$personne->getPerLogin());
    if ($_SESSION["per_cat"] == "per_etu"){
      $etudiantManager = new EtudiantManager($pdo);
      $etudiant = new Etudiant($_POST);
      $retour1 = $etudiantManager->add($etudiant);
    } else if ($_SESSION["per_cat"] == "per_pers"){
      $salarieManager = new SalarieManager($pdo);
      $salarie = new Salarie($_POST);
      $retour1 = $salarieManager->add($salarie);
    }
    if ($retour != 0 && $retour1 != 0){
      echo "<img class=\"check top\" src=\"image/valid.png\" alt=\"Validé\" />";
      echo "La personne a été ajouté";
    } else {
      echo "<img class=\"check top\" src=\"image/erreur.png\" alt=\"Echec\">";
      echo "La personne n'a pas pu être ajouté";
    }
}
?>
