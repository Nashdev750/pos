<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;

$cust = array();
$order = array();
$day = array();

$stp = intval(date('d'));
 

for ($i=1; $i <=$stp ; $i++) { 
    $r = ($i<10)?"0".$i:strval($i);
    $d = date("Y-m-").$r;
    $sql = "SELECT * FROM `order` WHERE `order_date`='{$d}'";
    $num = $db->readdbrow($sql);
    $sql2 = "SELECT * FROM `customers` WHERE `pubat`='{$d}'";
    $num2 = $db->readdbrow($sql2);
    array_push($cust,$num2);
    array_push($order,$num);
    array_push($day,$i."/30");

}
$all= array('customer'=>$cust,'order'=>$order,'day'=>$day);
echo json_encode($all);