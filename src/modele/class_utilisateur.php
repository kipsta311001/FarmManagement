<?php

class Utilisateur{
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $selectByEmail;
    private $selectByNbUnique;
    private $update;
    private $updateImage;
    private $delete;
    private $selectLimit;
    private $selectCount;
    private $rechercher;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into utilisateur(email,mdp,nom,prenom,idRole,nbUnique,photo) values(:email,:mdp,:nom,:prenom,:role,:nbUnique,:photo)");
        $this->connect = $db->prepare("select email, idRole, mdp from utilisateur where email=:email");
        $this->select = $db->prepare("select u.id,email, idRole, nom, nbUnique, prenom,photo, r.libelle as libellerole from utilisateur u, role r where u.idRole = r.id order by nom");
        $this->selectByEmail = $db->prepare("select u.id,email, idRole, nom, prenom, nbUnique,photo, r.libelle as libellerole from utilisateur u, role r where email=:email and u.idRole = r.id");
        $this->selectByNbUnique = $db->prepare("select u.id,email, idRole, nom, prenom, nbUnique,photo, r.libelle as libellerole from utilisateur u, role r where u.nbUnique=:nbUnique and u.idRole = r.id");
        $this->update = $db->prepare("update utilisateur set nom=:nom, prenom=:prenom, email=:email where nbUnique=:nbUnique");
        $this->updateImage=$db->prepare("update utilisateur set photo=:photo where nbUnique=:nbUnique");
        $this->delete = $db->prepare("delete from utilisateur where id=:id");
        $this->selectLimit = $db->prepare("select u.id,email, idRole, nom, nbUnique,photo, prenom, r.libelle as libellerole from utilisateur u, role r where u.idRole = r.id order by nom limit :inf,:limite ");
        $this->selectCount = $db->prepare("select count(*) as nb from utilisateur");
        $this->rechercher = $db->prepare("select * from utilisateur u where u.nom like :recherche");
    }

    public function insert($email, $mdp, $role, $nom, $prenom,$nbUnique, $photo) { // Étape 3
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom,':nbUnique'=>$nbUnique,'photo'=>$photo));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }

    public function connect($email){
        $this->connect->execute(array(':email'=>$email));
        if ($this->connect->errorCode()!=0){
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectByEmail($email){
        $this->selectByEmail->execute(array(':email'=>$email));
        if ($this->selectByEmail->errorCode()!=0){
            print_r($this->selectByEmail->errorInfo());
        }
        return $this->selectByEmail->fetch();
    }

    public function selectByNbUnique($nbUnique){
        $this->selectByNbUnique->execute(array(':nbUnique'=>$nbUnique));
        if ($this->selectByNbUnique->errorCode()!=0){
            print_r($this->selectByNbUnique->errorInfo());
        }
        return $this->selectByNbUnique->fetch();
    }

    public function update($email, $nom, $prenom,$nbUnique){
        $r = true;
        $this->update->execute(array(':email'=>$email, ':nom'=>$nom,':prenom'=>$prenom,':nbUnique'=>$nbUnique));
        if ($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function updateImage($photo,$nbUnique){
        $r = true;
        $this->updateImage->execute(array(':photo'=>$photo,':nbUnique'=>$nbUnique));
        if ($this->updateImage->errorCode()!=0){
            print_r($this->updateImage->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function selectLimit($inf, $limite)
    {
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if ($this->selectLimit->errorCode() != 0) {
            print_r($this->selectLimit->errorInfo());
        }
        return $this->selectLimit->fetchAll();
    }

    public function selectCount(){
        $this->selectCount->execute();
        if ($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo());
        }
        return $this->selectCount->fetch();
    }

    public function rechercher($recherche) {
        $listerecherche = $this->rechercher->execute(array(':recherche' => '%' . $recherche . '%'));
        if ($this->rechercher->errorCode() != 0) {
            print_r($this->rechercher->errorInfo());
        }
        return $this->rechercher->fetchAll();
    }



}
