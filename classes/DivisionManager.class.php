<?php
class DivisionManager{
    private $dbo;

    public function __construct($db){
        $this->dbo = $db;
    }

    public function add($division){
        $requete = $this->dbo->prepare('INSERT INTO division (div_nom) VALUES (:div_nom)');

        $requete->bindValue(':div_nom', $division->getDivNom());

        $retour = $requete->execute();
        return $retour;
    }
    public function getAllDivision(){
        $listeDivision = array();

        $sql = 'SELECT div_num, div_nom FROM division ORDER BY 1';

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($division = $requete->fetch(PDO::FETCH_OBJ)){
            $listeDivision[] = new Division($division);
        }

        $requete->closeCursor();
        return $listeDivision;
    }
}
