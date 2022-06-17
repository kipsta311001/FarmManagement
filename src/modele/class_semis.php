<?php 

class Semis{
    private $db;
    private $insert;    
    private $semenceByID;

    public function __construct($db){
        $this->db=$db;
        $this->semenceByID = $db->prepare("SELECT semence.variete from semence, parcelle, ilots, utilisateur where semence.idParcelle = parcelle.id AND parcelle.idIlot = ilots.id AND ilots.idUtilisateur = utilisateur.id  AND utilisateur.id = :id");
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

  
    public function semenceByID($id){
        $this->semenceByID->execute(array(':id'=>$id));
        if ($this->semenceByID->errorCode()!=0){
            print_r($this->semenceByID->errorInfo());
        }
        return $this->semenceByID->fetchAll();
    }

}