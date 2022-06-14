<?php 

class Traitement{
    private $db;
    private $insert;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into travail_du_sol(idParcelle, nom, date_intervention, description, cout) values(:idParcelle, :nom, :date_intervention, :description, :cout)");

    }

    public function insert($idParcelle, $nom, $date_intervention, $description, $cout) {
        $r = true;
        $this->insert->execute(array(':idParcelle'=>$idParcelle, ':nom'=>$nom, ':date_intervention'=>$date_intervention, ':description'=>$description, ':cout'=>$cout));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }
}