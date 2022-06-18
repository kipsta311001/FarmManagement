
<?php

class Intervention{
    private $db;
    private $selectAllByIdParcelle;
    private $delete;
    private $update;


    public function __construct($db){
        $this->db=$db;
        $this->selectAllByIdParcelle = $db->prepare("SELECT * from (SELECT id, idParcelle, produit, quantite_ha, date_intervention, cout, NULL as nom, NULL as description, NULL as rendement, NULL as prix_vente, null as variete, iType, isActive FROM phyto
        UNION ALL 
        SELECT id, idParcelle, NULL as produit, NULL as quantite_ha, date_intervention, cout, nom, description, NULL AS rendement, NULL AS prix_vente, null as variete, iType, NULL AS isActive FROM travail_du_sol
        UNION ALL 
        SELECT id, idParcelle,  NULL AS produit,  quantite_ha, date_intervention, cout, nom, NULL AS description, NULL AS rendement, NULL AS prix_vente, null as variete, iType, NULL AS isActive FROM engrais_org    
         UNION ALL 
        SELECT id, idParcelle,  NULL AS produit,  quantite_ha, date_intervention, cout, nom, NULL AS description, NULL AS rendement, NULL AS prix_vente, null as variete, iType, NULL AS isActive FROM engrais_min           
        UNION ALL 
        SELECT id, idParcelle,  NULL AS produit,  null as quantite_ha, date_intervention, cout, NULL AS nom, NULL AS description, rendement, prix_vente, null as variete, iType, NULL AS isActivee FROM recolte    
        UNION ALL
        SELECT id, idParcelle,  NULL AS produit,  null as quantite_ha, date_intervention, cout, NULL AS nom, NULL AS description, null as rendement, null as prix_vente, variete, iType, NULL AS isActive FROM semence    
        UNION ALL          
        SELECT id, idParcelle,  NULL AS produit,  NULL AS quantite_ha, date_intervention, cout, nom, NULL AS description, null as rendement, null as prix_vente, null as variete, iType, NULL AS isActive FROM culture_intermediaire)
        as intervention WHERE idParcelle = :idParcelle order by date_intervention
        ");
        $this->delete = $db->prepare("DELETE FROM phyto WHERE id = :id");
        $this->update = $db->prepare("UPDATE phyto SET isActive = 0, date_intervention = :currentDate  WHERE id = :id");
    }


    public function selectAllByIdParcelle($idParcelle){
        $this->selectAllByIdParcelle->execute(array(':idParcelle'=>$idParcelle));
        if ($this->selectAllByIdParcelle->errorCode()!=0){
            print_r($this->selectAllByIdParcelle->errorInfo());
        }
        return $this->selectAllByIdParcelle->fetchAll();
    }

    public function delete($id){
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
        }
        return $this->delete->fetch();
    }

    public function update($id, $currentDate){
        $this->update->execute(array(':id'=>$id, ':currentDate'=>$currentDate));
        if ($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
        }
        return $this->update->fetch();
    }
}

