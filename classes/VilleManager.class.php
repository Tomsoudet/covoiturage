<?php

class VilleManager{
	private $dbo;

		public function __construct($db){
			$this->dbo = $db;
		}
			public function add($ville){
				$requete = $this->dbo->prepare(
					'INSERT INTO ville (vil_num, vil_nom)
					 VALUES (:vil_num, :vil_nom);');

				$requete->bindValue(':vil_num',$ville->getVilnum());
 				$requete->bindValue(':vil_nom',$ville->getVilnom());

				$retour=$requete->execute();
				return $retour;
			}

			public function getAllVille(){
							$listeVilles = array();

							$sql = 'SELECT vil_num, vil_nom FROM Ville ORDER BY 1';

							$requete = $this->dbo->prepare($sql);
							$requete->execute();

							while ($ville = $requete->fetch(PDO::FETCH_OBJ))
									$listeVilles[] = new Ville($ville);

							$requete->closeCursor();
							return $listeVilles;
						}

				public function getVilleNom($vil_num){
					$sql = "SELECT vil_nom FROM ville WHERE vil_num = $vil_num";

					$requete = $this->dbo->prepare($sql);
					$requete->execute();

					while ($vilnom = $requete->fetch())
							$name = $vilnom[0];

					$requete->closeCursor();
					return $name;
				}


}
?>
