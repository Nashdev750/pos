<?php
session_start();
spl_autoload_register(function($class){
  include $class.".php";
});
$db = new opendb;

$db->loginadmin($_POST['username'],$_POST['pass']);

if(!isset($_SESSION['user'])){
    echo '<div class="alert alert-danger">Chi tiết đăng nhập không hợp lệ!</div>'; 
}else{
   echo 'access';
}