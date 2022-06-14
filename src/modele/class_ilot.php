<?php

class Ilots{
    private $db;
    private $insert;
    private $selectByUtilisateur;
    private $selectCountById;
    private $delete;


    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into ilots(numIlot, idUtilisateur) values(:numIlot, :idUtilisateur)");
        $this->selectByUtilisateur = $db->prepare("SELECT i.* FROM ilots i WHERE idUtilisateur = :idUtilisateur");
        $this->selectSurfaceCheck = $db->prepare("SELECT surface FROM parcelle WHERE id = :id");
        $this->selectCountById = $db->prepare("SELECT COUNT(*) FROM parcelle WHERE idIlot = :idIlot GROUP BY idIlot");
        $this->delete = $db->prepare("DELETE FROM ilots WHERE id = :id");
    }

    public function insert($numIlot, $idUtilisateur){
        $r = true;
        $this->insert->execute(array(':numIlot'=>$numIlot, ':idUtilisateur'=>$idUtilisateur));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }

    
    public function selectByUtilisateur($idUtilisateur){
        $this->selectByUtilisateur->execute(array(':idUtilisateur'=>$idUtilisateur));
        if ($this->selectByUtilisateur->errorCode()!=0){
            print_r($this->selectByUtilisateur->errorInfo());
        }
        return $this->selectByUtilisateur->fetchAll();
    }

    public function selectCountById($idIlot){
        $this->selectCountById->execute(array(':idIlot'=>$idIlot));
        if ($this->selectCountById->errorCode()!=0){
            print_r($this->selectCountById->errorInfo());
        }
        return $this->selectCountById->fetchAll();
    }

    public function delete($id){
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
        }
        return $this->delete->fetch();
    }
}