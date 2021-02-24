<?php
class ParcoursManager{
	private $dbo;

	public function __construct($db){
		$this->dbo = $db;
	}
		public function add($parcours){
			$requete = $this->dbo->prepare(
				'INSERT INTO parcours ( par_km,vil_num1,vil_num2)
				 VALUES ( :par_km, :vil_num1, :vil_num2);');


			$requete->bindValue(':par_km',$parcours->getParKm());
			$requete->bindValue(':vil_num1',$parcours->getVilNum1());
			$requete->bindValue(':vil_num2',$parcours->getVilNum2());

			$retour=$requete->execute();
			return $retour;
		}

		public function getAllParcours(){
						$listeParcours = array();

						$sql = 'SELECT par_num, par_km,vil_num1, vil_num2 FROM Parcours ORDER BY 1';

						$requete = $this->dbo->prepare($sql);
						$requete->execute();

						while ($parcours = $requete->fetch(PDO::FETCH_OBJ))
								$listeParcours[] = new Parcours($parcours);

						$requete->closeCursor();
						return $listeParcours;
		}

		public function getVillesDesservies(){
						$listeParcours = array();

						$sql = 'SELECT DISTINCT vil_num, vil_nom FROM ville, Parcours WHERE vil_num=vil_num1 OR vil_num=vil_num2 GROUP BY vil_num';

						$requete = $this->dbo->prepare($sql);
						$requete->execute();

						while ($ville = $requete->fetch(PDO::FETCH_OBJ))
								$listeParcours[] = new Ville($ville);

						$requete->closeCursor();
						return $listeParcours;
		}

		public function getVillesDestination($vil_num){
						$listeParcours = array();

						$sql = "SELECT DISTINCT vil_num, vil_nom FROM ville, Parcours WHERE (vil_num=vil_num1 AND vil_num2 = $vil_num) OR (vil_num=vil_num2 AND vil_num1 = $vil_num) GROUP BY vil_num";

						$requete = $this->dbo->prepare($sql);
						$requete->execute();

						while ($ville = $requete->fetch(PDO::FETCH_OBJ))
								$listeParcours[] = new Ville($ville);

						$requete->closeCursor();
						return $listeParcours;
		}

		public function getParcours($vil_num1, $vil_num2){

			$sql = "SELECT * FROM Parcours WHERE (vil_num1=$vil_num1 AND vil_num2=$vil_num2) OR (vil_num1=$vil_num2 AND vil_num2=$vil_num1)";

			$requete = $this->dbo->prepare($sql);
			$requete->execute();

			while ($parcours = $requete->fetch(PDO::FETCH_OBJ))
					$Parcours = new Parcours($parcours);

			$requete->closeCursor();
			return $Parcours;
		}



}
