<?php 

class Semis{
    private $db;
    private $insert;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into semence(idParcelle, variete, date_intervention, quantite_ha, cout) values(:idParcelle, :variete, :date_intervention, :quantite, :cout)");

    }

    public function insert($idParcelle, $variete, $date_intervention, $quantite, $cout) {
        $r = true;
        $this->insert->execute(array(':idParcelle'=>$idParcelle, ':variete'=>$variete, ':date_intervention'=>$date_intervention, ':quantite'=>$quantite, ':cout'=>$cout));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }
}