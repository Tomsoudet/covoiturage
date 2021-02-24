<?php
class DepartementManager{
    private $dbo;

    public function __construct($db){
        $this->dbo = $db;
    }

    public function add($departement){
        $requete = $this->dbo->prepare('INSERT INTO departement (dep_nom, vil_num) VALUES (:dep_nom, :vil_num)');

        $requete->bindValue(':dep_nom', $departement->getDepNom());
        $requete->bindValue(':vil_num', $departement->getVilNum());

        $retour = $requete->execute();
        return $retour;
    }
    public function getAllDepartement(){
        $listeDepartement = array();

        $sql = 'SELECT dep_num, dep_nom, vil_num FROM departement ORDER BY 2,3';

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($departement = $requete->fetch(PDO::FETCH_OBJ)){
            $listeDepartement[] = new Departement($departement);
        }

        $requete->closeCursor();
        return $listeDepartement;
    }
}
