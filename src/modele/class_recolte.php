<?php 

class Recolte{
    private $db;
    private $insert;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into recolte(idParcelle, rendement, date_intervention, prix_vente, cout, iType) values(:idParcelle, :rendement, :date_intervention, :prix_vente, :cout, :iType)");

    }

    public function insert($idParcelle, $rendement, $date_intervention, $prix_vente, $cout, $idType) {
        $r = true;
        $this->insert->execute(array(':idParcelle'=>$idParcelle, ':rendement'=>$rendement, ':date_intervention'=>$date_intervention, ':prix_vente'=>$prix_vente, ':cout'=>$cout , ':iType'=>$iType));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }
}