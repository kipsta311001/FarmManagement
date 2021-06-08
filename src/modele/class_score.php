<?php

Class Score{
    private $db;
    private $select;
    private $selectByEmail;
    private $insert;
    private $update;
    private $deleteByUtilisateur;
    private $deleteByTest;


    public function __construct($db){
        $this->db=$db;
        $this->select=$db->prepare("select u.Nom, u.Prenom, t.nom, s.score from score s, test t, utilisateur u where s.idUtilisateur = u.id and s.idTest = t.id and u.email = :email and t.id = :idTest  ");
        $this->selectByEmail=$db->prepare("select t.nom,s.score,COUNT(q.intitule) as nbQuestion from score s,test t, utilisateur u,question q where s.idUtilisateur = u.id and s.idTest = t.id and u.email = :email and q.idTest = t.id GROUP BY t.nom ORDER BY 3 DESC");
        $this->insert=$db->prepare("INSERT INTO score(idUtilisateur, idTest, score) VALUES ((SELECT u.id FROM utilisateur u where u.email =:email),:idTest,:score)");
        $this->update=$db->prepare("UPDATE `score` SET `idUtilisateur`=(SELECT u.id FROM utilisateur u where u.email =:email),`idTest`=:idTest,`score`=:score");
        $this->deleteByUtilisateur=$db->prepare("delete s.* from score s,utilisateur u where u.id=:id and s.idUtilisateur = u.id");
        $this->deleteByTest=$db->prepare("delete s.* from score s,test t where t.id=:id and s.idTest = t.id");
    }

    public function select($email,$idTest){
        $liste = $this->select->execute(array(':email'=> $email,':idTest'=>$idTest));
        if ($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function insert($email,$idTest,$score) {
        $r = true;
        $this->insert->execute(array(':email'=> $email,':idTest'=>$idTest,':score'=>$score));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }


    public function update($email,$idTest,$score){
        $r = true;
        $this->update->execute(array(':email'=> $email,':idTest'=>$idTest,':score'=>$score));
        if ($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function selectByEmail($email){
        $liste = $this->selectByEmail->execute(array(':email'=> $email));
        if ($this->selectByEmail->errorCode()!=0){
            print_r($this->selectByEmail->errorInfo());
        }
        return $this->selectByEmail->fetchAll();
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

    public function deleteByTest($id){
        $r = true;
        $this->deleteByTest->execute(array(':id'=>$id));
        if ($this->deleteByTest->errorCode()!=0){
            print_r($this->deleteByTest->errorInfo());
            $r=false;
        }
        return $r;
    }
}