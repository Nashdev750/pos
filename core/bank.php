<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;
if(isset($_GET['del'])){
    $db->writedb("DELETE FROM `deposits` WHERE id= {$_GET['del']}");
}
