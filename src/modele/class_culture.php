<?php 

class Culture{
    private $db;
    private $insert;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into culture_intermediaire(idParcelle, nom, date_intervention, cout) values(:idParcelle, :nom, :date_intervention, :cout)");

    }

    public function insert($idParcelle, $nom, $date_intervention, $cout) {
        $r = true;
        $this->insert->execute(array(':idParcelle'=>$idParcelle, ':nom'=>$nom, ':date_intervention'=>$date_intervention, ':cout'=>$cout));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }
}