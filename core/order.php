<?php
 session_start();
 spl_autoload_register(function($class){
     include $class.".php";
 });
 
 $db = new db;

 if(isset($_GET['deposit'])){
     // `orderid`, `account`, `amount`, `orderdate`, `note
    $data =  array(
         'orderid'=>"",
         'accountname'=>$db->readname("SELECT * FROM `bankaccounts` WHERE `id` ='{$_POST['daccount']}'",'bankname'),
         'account'=>trim($_POST['daccount']),
         'amount'=>trim($_POST['damount']),
         'orderdate'=>trim($_POST['ddate']),
         'note'=>trim($_POST['dnote'])
     );
     array_push($_SESSION['deposite'],$data);
     echo json_encode($_SESSION['deposite']);
 }
if(isset($_GET['post'])){
    // `orderid`, `post`, `posttype`, `amount`, `smallfee`,
    // `moneystatus`, `swipeday`, `backday`, `note`
    $data = array(
        'orderid'=>"",
        'post'=>trim($_POST['pcard']),
        'postname'=>$db->readname("SELECT * FROM `pos` WHERE `id` ='{$_POST['pcard']}'",'posname'),
        'posttype'=>explode('-',$_POST['ptype'])[1],
        'amount'=>trim($_POST['pamount']),
        'smallfee'=>trim($_POST['psmallfee']),
        'moneystatus'=>trim($_POST['moneystatus']),
        'swipeday'=>trim($_POST['swipeday']),
        'backday'=>intval($_POST['moneystatus'])==2?"":date('Y-m-d'),
        'note'=>trim($_POST['pnote'])
    );
    array_push($_SESSION['post'],$data);
    echo json_encode($_SESSION['post']);
}



if(isset($_GET['food'])){
    // `orderid`, `account`, `amount`, `day`, `note
  $data =  array(
    'orderid'=>"",
    'accountname'=>$db->readname("SELECT * FROM `bankaccounts` WHERE `id` ='{$_POST['raccount']}'",'bankname'),
    'account'=>trim($_POST['raccount']),
    'amount'=>trim($_POST['ramount']),
    'day'=>trim($_POST['actualday']),
    'note'=>trim($_POST['rnote'])
   );
   array_push($_SESSION['food'],$data);
   echo json_encode($_SESSION['food']);
}



if(isset($_GET['rdepo'])){
   unset($_SESSION['deposite'][intval(trim($_GET['rdepo']))]);
   $_SESSION['deposite']= array_values($_SESSION['deposite']);
   echo json_encode(array_values($_SESSION['deposite']));
}
if(isset($_GET['rfood'])){
    unset($_SESSION['food'][intval(trim($_GET['rfood']))]);
    $_SESSION['food']=  array_values($_SESSION['food']);
    echo json_encode(array_values($_SESSION['food']));
 }
 if(isset($_GET['rpost'])){
    unset($_SESSION['post'][intval(trim($_GET['rpost']))]);
    $_SESSION['post']= array_values($_SESSION['post']);
    echo json_encode(array_values($_SESSION['post']));
 }
if(isset($_GET['reset'])){
    $_SESSION['post']= array();
$_SESSION['deposite']= array();
$_SESSION['food']= array();
}

if(isset($_GET['action'])){
    $id =0;
    $type = ((int)$_GET['action']==0)?0:1;
    $sql = "INSERT INTO `order`(`cid`,
    `card_id`, `total`, `deposit`, `withdrawal`,
     `collection_fee`, `shipping_fee`,`food`,`bankfee`, `order_date`,
      `note`,`type`) VALUES (:cid,:cardid,:total,:deposit,:withdraw,
      :collectionf,:ship,:food,:bankfee,:odate,:note,:typ)";
      $s = date("d");
      $d=date("Y-m-d");
      
      if((int)$_GET['id']!=0){
          $id = $_GET['id'];
          $sql = "UPDATE `order` SET `cid`=:cid,`card_id`=:cardid,`total`=:total,
          `deposit`=:deposit,`withdrawal`=:withdraw,`collection_fee`=:collectionf,
          `shipping_fee`=:ship,`food`=:food,`bankfee`=:bankfee,`order_date`=:odate,`note`=:note,`type`=:typ WHERE id={$id}";
      }
    
      $c=$_POST['customer'];
      $cd=$_POST['card'];
      preg_match('!\d+!',$c,$cust);
      preg_match('!\d+!',$cd,$card);
     
     
     $data = array(
       'cid'=>$cust[0],
       'cardid'=>$card[0],
       'total'=>$_POST['total'],
       'deposit'=>$_POST['deposit'],
       'withdraw'=>$_POST['withdrawal'],
       'collectionf'=>$_POST['collectionfee'],
       'ship'=>$_POST['shippingfee'],
       'food'=>$_POST['food'],
       'bankfee'=>$_POST['bankfee'],
       'odate'=>$_POST['orderdate'],
       'note'=>$_POST['note'],
       'typ'=>$type
      
     );
     $id = $db->writedb($sql,$data);
     if($id || (int)$_GET['id'] ==0){
     $qr = "UPDATE `card` SET `status`= 1,`date`='{$_POST['orderdate']}' WHERE `id`='{$card[0]}'";
     $db->writedb($qr);
     }
     if((int)$_GET['id'] !=0){
        $id =$_GET['id'];
    
        $db->writedb("DELETE FROM `deposits` WHERE `orderid`={$id}");
        $db->writedb("DELETE FROM `post` WHERE `orderid`={$id}");
        $db->writedb("DELETE FROM `realfood` WHERE `orderid`={$id}");
      }

       if(!empty($_SESSION['post'])){
        
        $sql1 = "INSERT INTO `post`(`orderid`, `post`, `posttype`, 
        `amount`, `smallfee`, `moneystatus`,
         `swipeday`, `backday`, `note`) VALUES (:orderid,:post,
        :posttype,:amount,:smallfee,:moneystatus,:swipeday,:backday,:note )";
          foreach($_SESSION['post'] as $post){
            if(array_key_exists("id",$post)){
                unset($post['id']);
                
             }
             unset($post['postname']);
             var_dump($post);
              $post['orderid']= $id;
              $db->writedb($sql1,$post);   
          }

       }
       if(!empty($_SESSION['deposite'])){
        
         $sql2 = "INSERT INTO `deposits`(`orderid`, `account`, `amount`, `orderdate`, `note`) VALUES (
            :orderid, :account,:amount,:orderdate,:note
         )";
        foreach($_SESSION['deposite'] as $post){
            if(array_key_exists("id",$post)){
                unset($post['id']);
                
             }
             unset($post['accountname']);
             var_dump($post);
            $post['orderid']= $id;
            
            $db->writedb($sql2,$post);   
        }
       }
       if(!empty($_SESSION['food'])){
       
         $sql3 = "INSERT INTO `realfood`(`orderid`, `account`, `amount`, `day`, `note`)
          VALUES (:orderid,:account,:amount,:day,:note)";
           foreach($_SESSION['food'] as $post){
            if(array_key_exists("id",$post)){
                unset($post['id']);
                
             }
             unset($post['accountname']);
             var_dump($post);
            $post['orderid']= $id;
            $db->writedb($sql3,$post);   
        }
       }
       
        echo $id;
    }
     

if(isset($_GET['norder'])){
    $qr = "UPDATE `card` SET `status`= 2 WHERE `id`='{$_GET['norder']}'";
    $db->writedb($qr);
    echo $_GET['norder'];
}