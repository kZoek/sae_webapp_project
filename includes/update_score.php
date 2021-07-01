<?php
require_once(__DIR__."/../core/init.php");
$updateScore = new DBFunctions($pdo);
if(isset($_POST) && isset($_SESSION['userId'])){
    // echo $_POST['score'];
    // variable for score from JS
    $score = escape($_POST['score']);
    // update query, wich sums new points to the existing value
    /**
    * createDBcontent awaits 2 parameters - it is used for inster and update
    * @param $query -> query wich should be executed
    * @param $params -> array, with parameters for prepared statements
    */
    $updateScore->createDBContent("UPDATE `users` SET `score`= :score + $score WHERE `id` = :id",
    ['score'=> $score,'id'=>$_SESSION['userId']]);
}else{
    die();
}
?>