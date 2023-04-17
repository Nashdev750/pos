<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;

if(isset($_GET['load'])){
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

$data = array('data'=>array());
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
    $type = ($item['type']=='0')?"Đáo hạn":"Rút tiền";
    $rem = doubleval(str_replace(',','',$item['total']))-doubleval(str_replace(',','',$item['deposit']));

    foreach($food as $f){
        $collected+=round(doubleval(str_replace(',','',$f['amount'])));
    }
    $color = 'default';
    $debt = doubleval(str_replace(',','',$item['food']))-$collected;
    if(doubleval($debt)>0){
        $color = "yellow";
    }elseif(doubleval($debt)==0 && doubleval($item['total']) !=0  && doubleval($item['deposit']) !=0){
         $color = "green";
    }elseif(doubleval($debt)<0){
        $color = "red";
    }
    $one = array(
       "dd" =>"<p class='".$color."'><span style='margin-left:30px'>".$item['id']."</span><br><span>".$item['order_date']."</span></p>",
       "CLIENT" => "<p class='".$color."'><a href='customer'>".$name."<br><span'>".$card." <i class='fa fa-pencil'></i></span></a>"."</p>",
       "TOTALSEND" =>"<p class='".$color."'>".$item['deposit']."<br><span style='padding:20px'>Remaining: ".number_format(round($rem))."</span>"."</p>",
       "TOTALDRAW" =>"<p class='".$color."'>".number_format(round(doubleval(str_replace(',','',$item['total']))-doubleval(str_replace(',','',$item['deposit']))))."</p>",
       "FEES" =>"<p class='".$color."'>".$item['collection_fee']."%"."</p>",
       "RECEIVABLEDEPRECATE" =>"<p class='".$color."'>".$item['food']."</p>",
       "PROFIT" => "<p class='".$color."'>".number_format($profit)."</p>",
       "COLLECTED" => "<p class='".$color."'>".number_format($collected)."</p>",
       "DEBT" => "<p class='".$color."'>".number_format($debt)."</p>" ,
       "type" => "<p class='".$color."'>".$type."</p>" ,
       "date" => "<p class='".$color."'>".$item['order_date']."</p>" ,
       "sdate" => "<p class='".$color."'>".$sdate."</p>" ,
       "bankfee" => "<p class='".$color."'>".$item['bankfee']."</p>" ,
       "ship" => "<p class='".$color."'>".$item['shipping_fee']."</p>" ,
      
       "act" =>' <a onclick="return editorder('.$item['id'].')"  class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
       <a onclick="return delet('.$item['id'].')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
       '
    );
    
    array_push($data['data'],$one);
}    

echo json_encode($data);
}

if(isset($_GET['del'])){
    $dt = date('Y-m');
    $cardid = $db->readname("SELECT * FROM `order` WHERE `id`='{$_GET['del']}'", "card_id");
    $co = $db->readdbrow("SELECT * FROM `order` WHERE `card_id`='{$cardid}' AND `order_date` LIKE '%{$dt}%'");
    if(intval($co)<2){
        $qr = "UPDATE `card` SET `status`= 0 WHERE `id`='{$cardid}'";
        $db->writedb($qr);
    }
   
    $sql = "DELETE FROM `order` WHERE id='{$_GET['del']}'";
    $id = $db->writedb($sql);
  
}

if(isset($_GET['edit'])){
    $id = trim($_GET['edit']);
    $o = $db->readdbone("SELECT * FROM `order` WHERE id=:id",array('id'=>$id));
    $c = $db->readdbone("SELECT * FROM `customers` WHERE id=:id",array('id'=>$o['cid']));
    $cd = $db->readdbone("SELECT * FROM `card` WHERE id=:id",array('id'=>$o['card_id']));
    $deposites = $db->readdb("SELECT * FROM `deposits` WHERE orderid=:id",array('id'=>$id));
    $d = array();
    foreach($deposites as $deposite){
        $deposite['accountname']=$db->readname("SELECT * FROM `bankaccounts` WHERE `id` ='{$deposite['account']}'",'bankname');
        array_push($d,$deposite);
    }  
    $_SESSION['deposite'] =$d;

    $posts = $db->readdb("SELECT * FROM `post` WHERE orderid=:id",array('id'=>$id));
    $p = array();
    foreach($posts as $post){
        $post['postname']=$db->readname("SELECT * FROM `pos` WHERE `id` ='{$post['post']}'",'posname');
        array_push($p,$post);
    }  
    $_SESSION['post'] =$p;

 
    $foods= $db->readdb("SELECT * FROM `realfood` WHERE orderid=:id",array('id'=>$id));
    $f = array();
    foreach($foods as $food){
        $food['accountname']=$db->readname("SELECT * FROM `bankaccounts` WHERE `id` ='{$food['account']}'",'bankname');
        array_push($f,$food);
    }
    $_SESSION['food'] = $f;
    
    $data = array(
        'id'=>$id,
        'custmer'=> $c,
        'card'=> $cd,
        'total'=>$o['total'],
        'deposit'=>$o['deposit'],
        'withdrawal'=>$o['withdrawal'],
        'collection_fee'=>$o['collection_fee'],
        'food'=>$o['food'],
        'ship'=>$o['shipping_fee'],
        'order_date'=>$o['order_date'],
        'note'=>$o['note'],
        'type'=>$o['type']     
    );
    echo json_encode($data);
}
if(isset($_GET['post'])){
    echo json_encode($_SESSION['post']);
}
if(isset($_GET['deposit'])){
    echo json_encode($_SESSION['deposite']);
}
if(isset($_GET['food'])){
    echo json_encode($_SESSION['food']);
}

