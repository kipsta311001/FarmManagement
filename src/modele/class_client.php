<?php

class Client{
    private $db;
    private $insert;
    private $select;
    private $selectById;
    private $delete;
    private $update;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("INSERT into client(nom, adresse, codePostal, ville, tvaIntra) values(:nom, :adresse, :codePostal, :ville, :tvaIntra)");
        $this->select = $db->prepare("SELECT * from client");
        $this->selectById = $db->prepare("SELECT * from client where idClient = :id");
        $this->delete = $db->prepare("DELETE from client where idClient = :id");
        $this->update = $db->prepare("UPDATE client SET nom = :nom, adresse = :adresse, codePostal = :codePostal, ville = :ville, tvaIntra= :tvaIntra WHERE idClient = :id");

    }

    public function insert($nom, $adresse, $codePostal, $ville, $tvaIntra) { // Étape 3
        $r = true;
        $this->insert->execute(array(':nom' => $nom, ':adresse' => $adresse, ':codePostal' => $codePostal, ':ville' => $ville, ':tvaIntra' => $tvaIntra));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }

    public function update($id, $nom, $adresse, $codePostal, $ville, $tvaIntra) { // Étape 3
        $r = true;
        $this->update->execute(array(':id' => $id, ':nom' => $nom, ':adresse' => $adresse, ':codePostal' => $codePostal, ':ville' => $ville, ':tvaIntra' => $tvaIntra));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        } return $r;
    }

    public function select(){
        $this->select->execute(array());
        if ($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectById($id){
        $this->selectById->execute(array(':id'=>$id));
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }
    public function delete($id){
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
        }
        return $this->delete->fetch();
    }
    

}