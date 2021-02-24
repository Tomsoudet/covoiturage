<?php
class PersonneManager{
    private $dbo;

    public function __construct($db){
        $this->dbo = $db;
    }

    public function add($personne){
        $requete = $this->dbo->prepare('INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:per_nom, :per_prenom, :per_tel, :per_mail, :per_login, :per_pwd)');

        $requete->bindValue(':per_nom', $personne->getPerNom());
        $requete->bindValue(':per_prenom', $personne->getPerPrenom());
        $requete->bindValue(':per_tel', $personne->getPerTel());
        $requete->bindValue(':per_mail', $personne->getPerMail());
        $requete->bindValue(':per_login', $personne->getPerLogin());
        $requete->bindValue(':per_pwd', $this->encryptPasswd($personne->getPerPwd()));

        $retour = $requete->execute();
        return $retour;
    }

    public function getAllPersonne(){
        $listePersonne = array();

        $sql = 'SELECT per_num, per_nom, per_prenom FROM personne ORDER BY 2,3';

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($personne = $requete->fetch(PDO::FETCH_OBJ)){
            $listePersonne[] = new Personne($personne);
        }

        $requete->closeCursor();
        return $listePersonne;
    }

		public function getPerNumByValue($per_nom, $per_prenom, $per_tel, $per_mail, $per_login){
        $sql = "SELECT per_num FROM personne WHERE per_nom = \"$per_nom\" AND per_prenom = \"$per_prenom\" AND per_tel = $per_tel AND per_mail = \"$per_mail\" AND per_login = \"$per_login\"";

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($pernum = $requete->fetch()){
            $num = $pernum[0];
        }

        $requete->closeCursor();
        return $num;
    }

    public function getPerNomByValue($per_num){
        $sql = "SELECT per_nom FROM personne WHERE per_num = $per_num";

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($pernom = $requete->fetch()){
            $name = $pernom[0];
        }

        $requete->closeCursor();
        return $name;
    }

    public function isSalarie($per_num){
        $sql = "SELECT per_num FROM salarie WHERE per_num = $per_num";

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($salarie = $requete->fetch()){
            $num = $salarie[0];
        }
				if(isset($num)){
            if($num == $per_num){
                return 1;
            } else {
                return -1;
            }
        }
    }

    public function infoSalarie($per_num){
        $sql = "SELECT p.per_prenom, p.per_mail, p.per_tel, s.sal_telprof, f.fon_libelle FROM salarie s, fonction f, personne p WHERE s.per_num = p.per_num AND f.fon_num = s.fon_num AND s.per_num = $per_num ";

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($salarie = $requete->fetch()){
            $info = $salarie;
        }

        $requete->closeCursor();
        return $info;
    }

    public function infoEtudiant($per_num){
        $sql = "SELECT p.per_prenom, p.per_mail, p.per_tel, d.dep_nom, v.vil_nom FROM etudiant e, departement d, ville v, personne p WHERE e.per_num = p.per_num AND e.dep_num = d.dep_num AND d.vil_num = v.vil_num AND e.per_num = $per_num ";

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($etudiant = $requete->fetch()){
            $info = $etudiant;
        }

        $requete->closeCursor();
        return $info;
    }

    public function getPasswdByLogin($per_login){
        $sql = "SELECT * FROM personne WHERE per_login=\"$per_login\"";

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($motdepasse = $requete->fetch()){
            $newpersonne = new Personne($motdepasse);
        }

        $requete->closeCursor();
        return $newpersonne->getPerPwd();
    }

    public function encryptPasswd($per_pwd){
        $info = sha1(sha1($per_pwd).SALT);
        return $info;
    }

    public function existe($per_login){
        $sql = "SELECT * FROM personne WHERE per_login=\"$per_login\"";

        $requete = $this->dbo->prepare("SELECT EXISTS($sql)");
        $requete->execute();

        if ($requete->fetchColumn()==1) {
          $existe=true;
        }else {
          $existe=false;
        }

        $requete->closeCursor();
        return $existe;
    }

    public function getNumByLogin($per_login){
        $sql = "SELECT * FROM personne WHERE per_login=\"$per_login\"";

        $requete = $this->dbo->prepare($sql);
        $requete->execute();

        while($personne = $requete->fetch()){
            $newpersonne = new Personne($personne);
        }

        $requete->closeCursor();
        return $newpersonne->getPerNum();
    }

    public function getPerByValue($per_num){
            $sql = "SELECT per_prenom, per_nom FROM personne WHERE per_num = $per_num";

            $requete = $this->dbo->prepare($sql);
            $requete->execute();

            while($per = $requete->fetch()){
                $name = $per[0];
                $name = $name." ".$per[1];
            }

            $requete->closeCursor();
            return $name;
        }

    public function getLastAvis($per_num){
          $sql = "SELECT avi_comm FROM avis WHERE per_num = $per_num ORDER BY avi_date DESC";

          $requete = $this->dbo->prepare($sql);
          $requete->execute();

          while($comm = $requete->fetch()){
              $avis = $comm[0];
          }

          $requete->closeCursor();
          return $avis;
        }

        public function getMoyAvis($per_num){
          $sql = "SELECT avi_note FROM avis WHERE per_num = $per_num";

          $requete = $this->dbo->prepare($sql);
          $requete->execute();

          $i = 0;
          while($note = $requete->fetch()){
              $avis = $note[0];
              $i++;
          }

          $avis = $avis/$i;

          $requete->closeCursor();
          return $avis;
        }

}
