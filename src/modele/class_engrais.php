<?php 

class Engrais{
    private $db;
    private $insert_min;
    private $insert_org;


    public function __construct($db){
        $this->db=$db;
        $this->insert_min = $db->prepare("insert into engrais_min(idParcelle, nom, date_intervention, quantite_ha, cout) values(:idParcelle, :nom, :date_intervention, :quantite, :cout)");
        $this->insert_org = $db->prepare("insert into engrais_org(idParcelle, nom, date_intervention, quantite_ha, cout) values(:idParcelle, :nom, :date_intervention, :quantite, :cout)");
}

    public function insert_min($idParcelle, $nom, $date_intervention, $quantite, $cout) {
        $r = true;
        $this->insert_min->execute(array(':idParcelle'=>$idParcelle, ':nom'=>$nom, ':date_intervention'=>$date_intervention, ':quantite'=>$quantite, ':cout'=>$cout));
        if ($this->insert_min->errorCode() != 0) {
            print_r($this->insert_min->errorInfo());
            $r = false;
        } return $r;
    }

    public function insert_org($idParcelle, $nom, $date_intervention, $quantite, $cout) {
        $r = true;
        $this->insert_org->execute(array(':idParcelle'=>$idParcelle, ':nom'=>$nom, ':date_intervention'=>$date_intervention, ':quantite'=>$quantite, ':cout'=>$cout));
        if ($this->insert_org->errorCode() != 0) {
            print_r($this->insert_org->errorInfo());
            $r = false;
        } return $r;
    }
}