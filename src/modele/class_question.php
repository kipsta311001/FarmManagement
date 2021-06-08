<?php
class Question
{
    private $db;
    private $insert;
    private $select;
    private $selectByTest;
    private $selectById;
    private $update;
    private $deleteByTest;
    private $delete;
    private $selectLimit;
    private $selectCount;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert = $db->prepare('insert into question(intitule,reponse,idTest) values (:intitule,:reponse,:idTest)');
        $this->select = $db->prepare("select q.id,intitule, reponse, idTest,t.nom as nom from question q, test t where q.idTest=t.Id");
        $this->selectByTest = $db->prepare("select q.intitule, q.reponse from question q, test t where t.id=:idTest and t.id=q.idTest");
        $this->selectById = $db->prepare("select q.intitule,q.reponse from question q where q.id = :id");
        $this->update = $db->prepare("UPDATE question q SET intitule = :intitule, reponse = :reponse,idTest = :idTest WHERE q.id=:id");
        $this->deleteByTest = $db->prepare("delete q.* from question q,test t where t.id = :id and q.idTest = t.id");
        $this->delete = $db->prepare("delete q.* from question q where q.id=:id");
        $this->selectLimit = $db->prepare("select q.id,intitule, reponse, idTest,t.nom as nom from question q, test t where q.idTest=t.Id order by t.nom, intitule limit :inf,:limite ");
        $this->selectCount = $db->prepare("select count(*) as nb from question");

    }

    public function insert($intitule, $reponse, $idTest)
    {
        $r = true;
        $this->insert->execute(array(':intitule' => $intitule, ':reponse' => $reponse, ':idTest' => $idTest));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select()
    {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectByTest($idTest)
    {
        $liste = $this->selectByTest->execute(array(':idTest' => $idTest));
        if ($this->selectByTest->errorCode() != 0) {
            print_r($this->selectByTest->errorInfo());
        }
        return $this->selectByTest->fetchAll();
    }

    public function selectById($id)
    {
        $liste = $this->selectById->execute(array(':id' => $id));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function update($intitule, $reponse, $idTest, $id)
    {
        $r = true;
        $this->update->execute(array(':intitule' => $intitule, ':reponse' => $reponse, ':idTest' => $idTest, ':id' => $id));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function deleteByTest($id)
    {
        $r = true;
        $this->deleteByTest->execute(array(':id' => $id));
        if ($this->deleteByTest->errorCode() != 0) {
            print_r($this->deleteByTest->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function delete($id)
    {
        $r = true;
        $this->delete->execute(array(':id' => $id));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
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

}