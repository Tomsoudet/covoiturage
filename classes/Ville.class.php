<?php
class Ville{
	private $vil_num;
	private $vil_nom;

	public function __construct($valeurs = array()){
		if (!empty($valeurs)){
			$this->affecte($valeurs);
		}
	}

	public function affecte($donnees){
		foreach ($donnees as $attribut => $valeur) {
			switch ($attribut) {
				case 'vil_num': $this->setVilNum($valeur); break;
				case 'vil_nom': $this->setVilNom($valeur); break;
			}
		}
	}

	public function getVilnum(){
		return $this->vil_num;
	}

	public function setVilnum($id){
	        $this->vil_num=$id;
  }

	public function getVilnom(){
		return $this->vil_nom;
	}

	public function setVilnom($id){
					$this->vil_nom=$id;
	}

}
