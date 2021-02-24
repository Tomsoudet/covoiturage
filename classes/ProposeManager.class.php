<?php
class ProposeManager{
	private $dbo;

	public function __construct($db){
		$this->dbo = $db;
	}
		public function add($propose){
			$requete = $this->dbo->prepare(
				'INSERT INTO propose ( par_num,per_num,pro_date,pro_time,pro_place,pro_sens)
				 VALUES ( :par_num, :per_num, :pro_date,:pro_time,:pro_place, :pro_sens);');


			$requete->bindValue(':par_num',$propose->getParNum());
			$requete->bindValue(':per_num',$propose->getPerNum());
			$requete->bindValue(':pro_date',$propose->getProDate());
			$requete->bindValue(':pro_time',$propose->getProTime());
			$requete->bindValue(':pro_place',$propose->getProPlace());
			$requete->bindValue(':pro_sens',$propose->getProSens());

			$retour=$requete->execute();
			return $retour;
		}

		public function getVilleDépart(){
			$listeVilleDepart = array();

			$sql = "SELECT DISTINCT v.vil_nom, v.vil_num FROM ville v, parcours p, propose pr WHERE pr.par_num=p.par_num AND ((v.vil_num=p.vil_num1 AND pr.pro_sens=0)
			OR (v.vil_num=p.vil_num2 AND pr.pro_sens=1)) ";

			$requete = $this->dbo->prepare($sql);
			$requete->execute();

			while ($ville = $requete->fetch(PDO::FETCH_OBJ))
					$listeVilleDepart[] = new Ville($ville);

			$requete->closeCursor();
			return $listeVilleDepart;
		}

		public function getRechercheTrajets($dateDepart,$precision, $heure, $par_num){
            $listeTrajets = array();

            $sql = "SELECT * FROM  propose  WHERE pro_time >= $heure AND par_num = $par_num AND pro_date between DATE_SUB(\"$dateDepart\", INTERVAL $precision DAY) AND DATE_ADD(\"$dateDepart\", INTERVAL $precision DAY)";

            $requete = $this->dbo->prepare($sql);
            $requete->execute();

            while ($trajets = $requete->fetch(PDO::FETCH_OBJ))
                    $listeTrajets[] = new Propose($trajets);

            $requete->closeCursor();
            return $listeTrajets;
        }







}
