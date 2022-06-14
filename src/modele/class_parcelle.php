<?php

class Parcelle{
    private $db;
    private $insert;
    private $selectByUtilisateur;
    private $selectSurfaceCheck;
    private $deleteById;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into parcelle(idIlot, libelle, surface) values(:idIlot, :libelle, :surface)");
        $this->selectByUtilisateur = $db->prepare("SELECT i.id as IdOfIlot, p.id as idParcelle, p.libelle, p.surface, p.idIlot FROM parcelle p inner join ilots i on p.idIlot = i.numIlot inner join utilisateur u on u.id = i.idUtilisateur and u.email = :email");
        $this->selectSurfaceCheck = $db->prepare("SELECT surface FROM parcelle WHERE id = :id");
        $this->deleteById = $db->prepare("DELETE FROM parcelle WHERE id = :id");


    }

    public function insert($idIlot, $libelle, $surface) {
        $r = true;
        $this->insert->execute(array(':idIlot'=>$idIlot, ':libelle'=>$libelle, ':surface'=>$surface));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }

    
    public function selectByUtilisateur($email){
        $this->selectByUtilisateur->execute(array(':email'=>$email));
        if ($this->selectByUtilisateur->errorCode()!=0){
            print_r($this->selectByUtilisateur->errorInfo());
        }
        return $this->selectByUtilisateur->fetchAll();
    }

    public function selectSurfaceCheck($id){
        $this->selectSurfaceCheck->execute(array(':id'=>$id));
        if ($this->selectSurfaceCheck->errorCode()!=0){
            print_r($this->selectSurfaceCheck->errorInfo());
        }
        return $this->selectSurfaceCheck->fetchAll();
    }

    public function deleteById($id){
        $this->deleteById->execute(array(':id'=>$id));
        if ($this->deleteById->errorCode()!=0){
            print_r($this->deleteById->errorInfo());
        }
        return $this->deleteById->fetch();
    }

}