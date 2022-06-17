<?php 

class Semis{
    private $db;
    private $insert;    
    private $semenceByID;

    public function __construct($db){
        $this->db=$db;
        $this->insert = $db->prepare("insert into travail_du_sol(idParcelle, nom, date_intervention, description, cout) values(:idParcelle, :nom, :date_intervention, :description, :cout)");
        $this->semenceByID = $db->prepare("SELECT semence.variete from semence, parcelle, ilots, utilisateur where semence.idParcelle = parcelle.id AND parcelle.idIlot = ilots.id AND ilots.idUtilisateur = utilisateur.id  AND utilisateur.id = :id");
    }

    public function insert($idParcelle, $nom, $date_intervention, $description, $cout) {
        $r = true;
        $this->insert->execute(array(':idParcelle'=>$idParcelle, ':nom'=>$nom, ':date_intervention'=>$date_intervention, ':description'=>$description, ':cout'=>$cout));
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
        return $this->semenceByID->fetch();
    }

}