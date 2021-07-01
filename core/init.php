<?php
session_start();
// $_SESSION['status'] = false;
// session_unset();
// DB Connection
require_once  __DIR__."/../includes/database.php";
// array for the main navigation, to create it dynamic
$mainnav = array(
    array('link' => 'index.php','text' => 'Home'),
    array('link' => 'about.php','text' => 'About'),
    array('link' => 'game.php','text' => 'Game'),
    array('link' => 'tutorial.php','text' => 'Tutorial'),
    array('link' => 'register_login.php','text' => 'Login')
);
if(isset($_SESSION['status'])){
   //modify the navigation array after login
    $mainnav[4]['text'] = 'Profile';
    $mainnav[4]['link'] = 'profile.php';
    $mainnav[]=array('link' => 'includes/logout.php','text' => 'Logout');
}
// autoload for classes
spl_autoload_register(function($class){
    require_once  __DIR__."/../classes/$class.php";
});
// creating a new instance from DB connection, so every site has access
$content = new DBfunctions($pdo);
// require the sanitize function, so we don't have to require it all the time
require_once( __DIR__.'/../includes/sanitize.php');


?>