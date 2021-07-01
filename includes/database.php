<?php
// generate a new DPO Class instance
try{
    $pdo = new PDO(
        'mysql:host=;dbname=;charset=utf8',
        '',''
    ); 
}catch(PDOException $e){
    echo "Die Verbindung zur Datenbank konnte nicht hergestellt werden.";
    die();
}
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>