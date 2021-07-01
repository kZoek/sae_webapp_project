<?php
class DBfunctions{
    // attributes 
    private $pdo;


    // DB Connection on instance
    public function __construct(PDO $pdo){
    $this->pdo = $pdo;
    }

    // read functions
    public function fetchAll($sql,$params = array()){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function fetchSingle($sql,$params = array()){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result;
    }

    // create and update function
    public function createDBcontent($sql,$params = array()){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
   
    // delete function 
    public function deleteTask($sql,$params = array()){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }  
}