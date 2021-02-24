<?php
if(empty($_SESSION["user"])){
  if ((empty($_POST["co_nom"])) ||(empty($_POST["co_mdp"])) || (empty($_POST["co_verif"]))){
    $_SESSION["val1"] = rand(1,9);
    $_SESSION["val2"] = rand(1,9);
    $_SESSION["resultat"] = ($_SESSION["val1"] + $_SESSION["val2"]);
?>
    <h1>Pour vous connecter</h1>

    <form class="formco" action="#" method="post">
      <label for="co_nom">Nom d'utilisateur :</label>
     	<input type="text" class="inputText" name="co_nom"> <br>
      <label for="co_mdp">Mot de passe :</label>
     	<input type="password" class="inputText" name="co_mdp"> <br>
      <h1><img src="image/nb/<?php echo $_SESSION["val1"] ?>.jpg"> + <img src="image/nb/<?php echo $_SESSION["val2"] ?>.jpg"> = </h1>
     	<input type="number" class="inputText" name="co_verif"> <br>
      <input type="submit" class="inputSubmit" name="valider" value="Valider" />

      <?php
  } else {
    $pdo = new Mypdo();
    $personneManager = new PersonneManager($pdo);

    if ($_POST["co_verif"] == $_SESSION["resultat"]) {
      if ($personneManager->existe($_POST["co_nom"])) {
        $pwd = $personneManager->getPasswdByLogin($_POST["co_nom"]);
        echo $_POST["co_nom"];
        $typedPwd = $personneManager->encryptPasswd($_POST["co_mdp"]);

        if ($pwd ==  $typedPwd) {
          $_SESSION["user"] = $_POST["co_nom"];
          header('Location: index.php?page=0');
          exit();
        }
      }
    }
    echo "<h1>Pour vous connecter</h1> <br> <img src="."image/erreur.png"."> Login, Mot de passe ou captcha incorrect";
  }
} else {
  header('Location: index.php?page=0');
  exit();
}?>
