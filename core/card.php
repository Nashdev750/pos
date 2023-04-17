<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;

if(isset($_GET['loadc'])){
    $data = array();
    $sql = "SELECT * FROM `card`"; 
    if(trim($_GET['loadc']) !=''){
        $key = trim($_GET['loadc']);
        
    $sql = "SELECT * FROM `card` WHERE `name` LIKE '%{$key}%' OR `number` LIKE '%{$key}%' OR `bank` LIKE '%{$key}%' OR `sdate` LIKE '%{$key}%'";
    }
    //`number`, `name`, `bank`, `sdate`
    $custs = $db->readdb($sql);
    foreach($custs as $card){
        $name = $db->readname("SELECT * FROM `customers` WHERE id={$card['cid']}","fullname");
        $phn = $db->readname("SELECT * FROM `customers` WHERE id={$card['cid']}","phone");
        array_push($data,array('id'=>$card['id'],'cid'=>$card['cid'],'number'=>$card['number'],'name'=>$card['name'],
        'bank'=>$card['bank'],'date'=>$card['sdate'],'cname'=>$name,'phone'=>$phn));
    }
    echo json_encode($data);   
}