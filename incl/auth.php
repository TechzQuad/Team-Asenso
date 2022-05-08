<?php
$expire = 2678400; // We choose a one year duration
ini_set('session.gc_maxlifetime', $expire);
session_start(); //We start the session 
setcookie(session_name(),session_id(),time()+$expire);
//Set a session cookies to the one year duration
    if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
        header("location: login.php");
    }
?>