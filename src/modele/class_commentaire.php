<?php

class Commentaire{
    private $db;
    private $insert;
    private $select;
    private $selectLimit;
    private $selectCount;
    private $deleteByUtilisateur;


    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into commentaire(idUtilisateur,message,note,dateCom) values((select id from utilisateur where email = :email),:message,:note,NOW())");
        $this->select = $db->prepare("select c.dateCom,c.message,c.note,u.email, u.nom as nomUtilisateur from commentaire c, utilisateur u where c.idutilisateur = u.id order by dateCom desc");
        $this->selectLimit = $db->prepare("select c.dateCom,c.message,c.note,u.email, u.nom as nomUtilisateur from commentaire c, utilisateur u where c.idutilisateur = u.id order by dateCom desc limit :inf,:limite ");
        $this->selectCount = $db->prepare("select count(*) as nb from commentaire");
        $this->deleteByUtilisateur = $db->prepare("delete c.* from commentaire c, utilisateur u where c.idUtilisateur = u.id and u.id = :id");
    }

    public function insert($email,$message,$note){
        $r = true;
        $this->insert->execute(array(':email' => $email,':message'=>$message,':note'=>$note));

        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }


    public function select(){
        $this->select->execute() ;
        if ($this->select->errorCode() !=0){
            print_r($this->select->errorInfo()) ;
        }
        return $this->select->fetchAll() ;
    }

    public function selectLimit($inf, $limite)
    {
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if ($this->selectLimit->errorCode() != 0) {
            print_r($this->selectLimit->errorInfo());
        }
        return $this->selectLimit->fetchAll();
    }

    public function selectCount(){
        $this->selectCount->execute();
        if ($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo());
        }
        return $this->selectCount->fetch();
    }

    public function deleteByUtilisateur($id){
        $r = true;
        $this->deleteByUtilisateur->execute(array(':id'=>$id));
        if ($this->deleteByUtilisateur->errorCode()!=0){
            print_r($this->deleteByUtilisateur->errorInfo());
            $r=false;
        }
        return $r;
    }

}

