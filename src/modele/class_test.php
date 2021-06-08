<?php
class Test{
    private $db;
    private $insert;
    private $update;
    private $selectById;
    private $delete;
    private $select;
    private $selectLimit;
    private $selectCount;
    private $selectByNb;

    public function __construct($db){
        $this->db=$db;
        $this->select = $db->prepare("select * from test");
        $this->selectByNb = $db->prepare("SELECT dateCreation, t.nom,t.id, COUNT(q.intitule) as nbQuestion FROM test t, question q WHERE q.idTest = t.id GROUP BY t.nom ORDER BY 3");
        $this->insert = $db->prepare('insert into test(dateCreation,nom) values (NOW(),:nom)');
        $this->update = $db->prepare("update test t set nom=:nom WHERE t.id=:id");
        $this->selectById = $db->prepare("select t.nom from test t where t.id = :id");
        $this->delete= $db->prepare("delete from test where id = :id ");
        $this->selectLimit = $db->prepare("select * from test order by nom limit :inf,:limite ");
        $this->selectCount = $db->prepare("select count(*) as nb from test");
    }

    public function insert($nom) {
        $r = true;
        $this->insert->execute(array(':nom'=>$nom));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }

    public function selectById($id){
        $liste = $this->selectById->execute(array(':id'=>$id));
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function update($nom,$id){
        $r = true;
        $this->update->execute(array(':nom'=>$nom,':id'=>$id));
        if ($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
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

    public function selectByNb(){
        $liste = $this->selectByNb->execute();
        if ($this->selectByNb->errorCode()!=0){
            print_r($this->selectByNb->errorInfo());
        }
        return $this->selectByNb->fetchAll();
    }
}
