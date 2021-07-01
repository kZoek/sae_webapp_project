<?php
require_once("../core/init.php");
// destroy session and change array back, if the user logs out
if(isset($_SESSION['userId'])){
    $mainnav[4]['text'] = 'Login';
    $mainnav[4]['link'] = 'register_login.php';
    array_pop($mainnav);
    session_unset();
    session_destroy();
    header("location: ../register_login.php");
}else{
    echo "lol";
}
?>