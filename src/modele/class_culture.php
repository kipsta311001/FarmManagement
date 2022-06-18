<?php 

class Culture{
    private $db;
    private $insert;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into culture_intermediaire(idParcelle, nom, date_intervention, cout, iType) values(:idParcelle, :nom, :date_intervention, :cout, :iType)");

    }

    public function insert($idParcelle, $nom, $date_intervention, $cout, $iType) {
        $r = true;
        $this->insert->execute(array(':idParcelle'=>$idParcelle, ':nom'=>$nom, ':date_intervention'=>$date_intervention, ':cout'=>$cout, ':iType'=>$iType));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }
}