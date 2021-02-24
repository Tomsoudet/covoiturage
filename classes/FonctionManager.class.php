<?php
class FonctionManager{
    private $dbo;

    public function __construct($db){
        $this->dbo = $db;
    }

    public function add($fonction){
        $requete = $this->dbo->prepare('INSERT INTO fonction (fon_libelle) VALUES (:fon_libelle)');

        $requete->bindValue(':fon_libelle', $fonction->getFonLibelle());

        $retour = $requete->execute();
        return $retour;
    }
    public function getAllFonction(){
        $listeFonction = array();

        $sql = 'SELECT fon_num, fon_libelle FROM Fonction ORDER BY 1';

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($fonction = $requete->fetch(PDO::FETCH_OBJ)){
            $listeFonction[] = new Fonction($fonction);
        }

        $requete->closeCursor();
        return $listeFonction;
    }
}
