<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;
if(isset($_GET['del'])){
    $db->writedb("DELETE FROM `post` WHERE id= {$_GET['del']}");
}
if(isset($_GET['money'])){
    $d =date("Y-m-d");
    $st = 1;
    if(intval($_GET['s'])==1){
        $d = "null";
        $st = 2;
    }
    $db->writedb("UPDATE `post` SET `backday`='{$d}',`moneystatus`='{$st}' WHERE `id`= {$_GET['money']}");
}

if(isset($_GET['load'])){
    $order = $db->readdb("SELECT * FROM `post`");
$data = array('data'=>array());
foreach($order as $item){
    //`orderid`, `post`, `posttype`, `amount`, `smallfee`, `moneystatus`, `swipeday`, `backday`, `note`
   
   $m = empty($item['backday'])?2:1;
    $one = array(
        'id'=>"<span style='margin-left:20px'>".$item['id']."</span>",
       'order'=>$item['orderid'],
       'swipeday'=>$item['swipeday'],
       'post'=>$db->readname("SELECT * FROM `pos` WHERE `id`='{$item['post']}'","posname"),
       'amount'=>$item['amount'],
       'backday'=>$item['backday'],
       'moneystatus'=>empty($item['backday'])?"Chưa về":"Đã về",
       'smallfee'=>$item['smallfee'],
       'moneyback'=>$item['amount'],
       'note'=>$item['note'],
       "act" =>' 
       <a onclick="return comeback('.$item['id'].','.$m.')" class="btn btn-success shadow btn-xs sharp"><i class="fa fa-refresh"></i></a>
       <a onclick="return delet('.$item['id'].')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
       '
    );
    
    array_push($data['data'],$one);
}    

echo json_encode($data);
}
if(isset($_GET['in'])){
    $order = $db->readdb("SELECT * FROM `post` WHERE `moneystatus`=2");
$data = array('data'=>array());
foreach($order as $item){
    //`orderid`, `post`, `posttype`, `amount`, `smallfee`, `moneystatus`, `swipeday`, `backday`, `note`
   
   $m = empty($item['backday'])?2:1;
    $one = array(
        'id'=>"<span style='margin-left:20px'>".$item['id']."</span>",
       'order'=>$item['orderid'],
       'swipeday'=>$item['swipeday'],
       'post'=>$db->readname("SELECT * FROM `pos` WHERE `id`='{$item['post']}'","posname"),
       'amount'=>$item['amount'],
       'backday'=>$item['backday'],
       'moneystatus'=>(int)$item['moneystatus']==1?"Đã về":"Chưa về",
       'smallfee'=>$item['smallfee'],
       'moneyback'=>$item['amount'],
       'note'=>$item['note'],
       "act" =>' 
       <a onclick="return comeback('.$item['id'].','.$m.')" class="btn btn-success shadow btn-xs sharp"><i class="fa fa-refresh"></i></a>
       <a onclick="return delet('.$item['id'].')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
       '
    );
    
    array_push($data['data'],$one);
}    

echo json_encode($data);
}