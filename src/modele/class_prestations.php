<?php

class Prestation{
    private $db;
    private $insert;
    private $select;
    private $selectById;
    private $delete;
    private $update;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("INSERT into prestations(libelle, tarifHeure, tarifHa, TVA) values(:libelle,:tarifHeure,:tarifHa, :TVA)");
        $this->select = $db->prepare("SELECT * from prestations");
        $this->selectById = $db->prepare("SELECT * from prestations where idPrestation = :id");
        $this->delete = $db->prepare("DELETE from prestations where idPrestation = :id");
        $this->update = $db->prepare("UPDATE prestations SET libelle = :libelle, tarifHeure = :tarifHeure, tarifHa = :tarifHa, TVA = :TVA WHERE idPrestation = :id");

    }

    public function insert($libelle, $tarifHeure, $tarifHa, $TVA) { // Étape 3
        $r = true;
        $this->insert->execute(array(':libelle' => $libelle, ':tarifHeure' => $tarifHeure, ':tarifHa' => $tarifHa, ':TVA' => $TVA));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }

    public function update($id, $libelle, $tarifHeure, $tarifHa, $TVA) { // Étape 3
        $r = true;
        $this->update->execute(array(':id' => $id, ':libelle' => $libelle, ':tarifHeure' => $tarifHeure, ':tarifHa' => $tarifHa, ':TVA' => $TVA));
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