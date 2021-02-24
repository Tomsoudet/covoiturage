<?php
class SalarieManager{
    private $dbo;

    public function __construct($db){
        $this->dbo = $db;
    }

    public function add($salarie){
        $requete = $this->dbo->prepare('INSERT INTO salarie (per_num, sal_telprof, fon_num) VALUES (:per_num, :sal_telprof, :fon_num)');

        $requete->bindValue(':per_num', $salarie->getPerNum());
        $requete->bindValue(':sal_telprof', $salarie->getSalTelprof());
        $requete->bindValue(':fon_num', $salarie->getFonNum());

        $retour = $requete->execute();
        return $retour;
    }
    public function getAllSalarie(){
        $listeSalarie = array();

        $sql = 'SELECT per_num, sal_telprof, fon_num FROM salarie ORDER BY 1';

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($salarie = $requete->fetch(PDO::FETCH_OBJ)){
            $listeSalarie[] = new Salarie($salarie);
        }

        $requete->closeCursor();
        return $listeSalarie;
    }
}
