<?php

class Intervention{
    private $db;
    private $insert;
    private $select;
    private $selectByClient;
    private $delete;
    private $update;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("INSERT into interventions(idClient, idPrestation, ha, heure, intervenant, dateIntervention, statut, dateFacturation) values(:idClient, :idPrestation, :ha, :heure, :intervenant, :dateIntervention, :statut, :dateFacturation)");
        $this->select = $db->prepare("SELECT * from interventions");
        $this->selectByClient = $db->prepare("SELECT * from interventions i INNER JOIN prestations p ON p.idPrestation = i.idPrestation where idClient = :id ORDER BY  i.dateIntervention ");
        $this->delete = $db->prepare("DELETE from client where idClient = :id");
        $this->update = $db->prepare("UPDATE client SET nom = :nom, adresse = :adresse, codePostal = :codePostal, ville = :ville, tvaIntra= :tvaIntra WHERE idClient = :id");

    }

    public function insert($idClient, $idPrestation, $ha, $heure, $intervenant, $dateIntervention, $statut, $dateFacturation) { // Étape 3
        $r = true;
        $this->insert->execute(array(':idClient' => $idClient, ':idPrestation' => $idPrestation,  ':ha' => $ha, ':heure' => $heure, ':intervenant' => $intervenant, ':dateIntervention' => $dateIntervention, ':statut' => $statut , ':dateFacturation' => $dateFacturation));
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

    public function selectByClient($id){
        $this->selectByClient->execute(array(':id'=>$id));
        if ($this->selectByClient->errorCode()!=0){
            print_r($this->selectByClient->errorInfo());
        }
        return $this->selectByClient->fetchAll();
    }
    public function delete($id){
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
        }
        return $this->delete->fetch();
    }
    

}