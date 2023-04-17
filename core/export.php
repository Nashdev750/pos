<?php
 session_start();
 spl_autoload_register(function($class){
     include $class.".php";
 });
 
 $db = new db;

$sql = "SELECT * FROM `order` ORDER BY `order_date` DESC";
$order = $db->readdb($sql);
$cid = '';
if(isset($_GET['start'])){
if(!empty($_GET['start']) && !empty($_GET['stop'])){
    $sql = "SELECT * FROM `order` WHERE `order_date` BETWEEN '{$_GET['start']}' AND '{$_GET['stop']}'";
    $order = $db->readdb($sql);
    $cid =  (int)trim($_GET['client']);
    if(!empty($cid)){  
        $sql = "SELECT * FROM `order` WHERE `cid`=$cid AND `order_date` BETWEEN '{$_GET['start']}' AND '{$_GET['stop']}'";
        $order = $db->readdb($sql);
    }
  
}}

$data = array();
setlocale(LC_MONETARY,'en_US');
foreach($order as $item){
    //`cid`, `card_id`, `total`, `deposit`, `withdrawal`, `collection_fee`, `shipping_fee`, `food`, `order_date`, `note`
   
 
    $chg = round(doubleval(str_replace(',','',$item['withdrawal'])) * (doubleval(str_replace(',','',$item['collection_fee']))/100));
    $profit = $chg - doubleval(str_replace(',','',$item['bankfee']));
    $food = $db->readdb("SELECT `amount` FROM `realfood` WHERE `orderid`={$item['id']}");
    $collected = 0;
    $name = $db->readname("SELECT * FROM `customers` WHERE id = {$item['cid']}","fullname");
    $card = $db->readname("SELECT * FROM `card` WHERE id = {$item['card_id']}","number");
    $sdate = $db->readname("SELECT * FROM `card` WHERE id = {$item['card_id']}","sdate");
    $type = ($item['type']=='0')?"Expire":"Withdrawal";
    $rem = doubleval(str_replace(',','',$item['total']))-doubleval(str_replace(',','',$item['deposit']));

    foreach($food as $f){
        $collected+=round(doubleval(str_replace(',','',$f['amount'])));
    }
    $debt = doubleval(str_replace(',','',$item['food']))-$collected;
    $one = array(
       $item['id'],
       $name,
       $card,
       $item['deposit'],
       number_format(round($rem)),
       number_format(round(doubleval(str_replace(',','',$item['total']))-doubleval(str_replace(',','',$item['deposit'])))),
       $item['collection_fee'],
       $item['food'],
       number_format($profit),
       number_format($collected),
       number_format($debt) ,
       $type ,
       $item['order_date'] ,
       $sdate ,
       $item['bankfee'] ,
       $item['shipping_fee'] ,
    );
    // $f = array("ID","CUSTOMER NAME","CARD NUMBER","DEPOSIT","REMAINING","Tong Thu","COLLECTION FEE","FOOD","PROFIT","COLLECTED","DEBT",
    // "TYPE","ORDER DATE","STATEMENT DATE","BANK FEE","SHIPPING FEE");
    array_push($data,$one);
}  

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
$fn = uniqid(time()).".csv";
$order = fopen("../csv/".$fn,"w");
$f = array("ID","CUSTOMER NAME","CARD NUMBER","DEPOSIT","REMAINING","Tong Thu","COLLECTION FEE","FOOD","PROFIT","COLLECTED","DEBT",
    "TYPE","ORDER DATE","STATEMENT DATE","BANK FEE","SHIPPING FEE");
    $flag = false;
foreach($data as $row) { 
       
   if(!$flag){
    $ss = str_replace("[","", json_encode($f));
    $ss = str_replace("]","", $ss);
    fwrite($order,$ss."\n"); 
    $flag = true; 
   }
    $str =  json_encode($row); 
    $ss = str_replace("[","", $str);
    $ss = str_replace("]","", $ss);
   
    fwrite($order,$ss."\n");
    
}
echo $fn;
//var_dump($data);
