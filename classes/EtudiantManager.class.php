<?php
class EtudiantManager{
    private $dbo;

    public function __construct($db){
        $this->dbo = $db;
    }

    public function add($etudiant){
        $requete = $this->dbo->prepare('INSERT INTO etudiant (per_num, dep_num, div_num) VALUES (:per_num, :dep_num, :div_num)');

        $requete->bindValue(':per_num', $etudiant->getPerNum());
        $requete->bindValue(':dep_num', $etudiant->getDepNum());
        $requete->bindValue(':div_num', $etudiant->getDivNum());

        $retour = $requete->execute();
        return $retour;
    }

    public function getAlletudiant(){
        $listeetudiants = array();

        $sql = 'SELECT per_num, dep_num, div_num FROM etudiant ORDER BY 1';

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($etudiant = $requete->fetch(PDO::FETCH_OBJ)){
            $listeetudiants[] = new Etudiant($etudiant);
        }

        $requete->closeCursor();
        return $listeetudiants;
    }
}
