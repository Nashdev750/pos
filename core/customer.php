<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;

if(isset($_GET['card'])){
    if(empty($_SESSION['card'])){
        $card = array(
          
            'name'=>$_POST['name'],
            'bank'=>$_POST['bank'],
            'number'=>trim($_POST['number']),
            'date'=>$_POST['sdate'],
            'note'=>$_POST['note'],
            'file'=>(empty($_FILES['files']['name']))?"":$db->upload($_FILES['files'],'../images/files/'),
            'fl'=>$_FILES['files']
           
        
        );
        array_push($_SESSION['card'],$card);
        echo json_encode($_SESSION['card']);
    }else{
        $ck=false;
       foreach($_SESSION['card'] as $cc){
            if($cc['number'] == trim($_POST['number'])){
             $ck = true;
            }
       } 
       if($ck){
        echo json_encode($_SESSION['card']);
       }else{
        $card = array(
           
            'name'=>$_POST['name'],
            'bank'=>$_POST['bank'],
            'number'=>trim($_POST['number']),
            'date'=>$_POST['sdate'],
            'note'=>$_POST['note'],
            'file'=>(empty($_FILES['files']['name']))?"":$db->upload($_FILES['files'],'../images/file/'),
            'fl'=>$_FILES['files']
           
        
        );
        array_push($_SESSION['card'],$card);
        echo json_encode($_SESSION['card']);
       }
    }
  
   
}

if(isset($_GET['cust'])){
    $cid = intval($_GET['cust']);
    $sql = "INSERT INTO `customers`(`fullname`, `phone`, `address`, `debt`, `note`) 
    VALUES (:nam, :phone, :adres, :d, :note)";
      $sq1= 'INSERT INTO `card`(`cid`, `number`, `name`, `bank`, `sdate`, `note`, `file`)
      VALUES (:id,:number,:name,:bank,:date,:note,:file)';
   if($cid > 0){
       $id = $cid;
       $sql = "UPDATE `customers` SET `fullname`=:nam,`phone`=:phone,
       `address`=:adres,`debt`=:d,
       `note`=:note WHERE `id`={$id}";
       $sq1 = "UPDATE `card` SET `cid`=:id,`number`=:number,`name`=:name,`bank`=:bank,`sdate`=:date,`note`=:note,`file`=:file WHERE `id`=:idd";
   }
   
    $arr = array(
        'nam'=>$_POST['name'],
        'phone'=>$_POST['number'],
        'adres'=>$_POST['adres'],
        'd'=>"0",
        'note'=>$_POST['note']
    );
    $id = $db->writedb($sql,$arr);
   $id =  ((int)$cid>0)?$cid:$id;
    if(!empty($_SESSION['card'])){
        $sq2= 'INSERT INTO `card`(`cid`, `number`, `name`, `bank`, `sdate`, `note`, `file`)
        VALUES (:id,:number,:name,:bank,:date,:note,:file)';
          foreach($_SESSION['card'] as $card){
        
            $data = array(
                'id'=>$id,
                'number'=>empty($card['number'])?'null':$card['number'],
                'name'=>empty($card['name'])?'null':$card['name'],
                'bank'=>empty($card['bank'])?'null':$card['bank'],
                'date'=>empty($card['date'])?'null':$card['date'],
                'note'=>empty($card['note'])?'null':$card['note'],
                'file'=>empty($card['file'])?'null':$card['file']
               );
               if(isset($_SESSION['c']) && !empty($_SESSION['c'])){
                $data = array(
                    'id'=>$id,
                    'number'=>empty($card['number'])?'null':$card['number'],
                    'name'=>empty($card['name'])?'null':$card['name'],
                    'bank'=>empty($card['bank'])?'null':$card['bank'],
                    'date'=>empty($card['date'])?'null':$card['date'],
                    'note'=>empty($card['note'])?'null':$card['note'],
                    'file'=>empty($card['file'])?'null':$card['file'],
                    'idd'=>$card['id']
                   );
                   $id2= $db->writedb($sq1,$data);
               }else{
                $id2= $db->writedb($sq2,$data);
               }
               
               
              
           
          }
          echo $id;
        
         
          
    }
}
$cc = array('data'=>array());
if(isset($_GET['loadc'])){
    $sql = "SELECT * FROM `customers` ORDER BY `pubat` DESC"; 
    $custs = $db->readdb($sql);
    //`fullname`, `phone`, `address`, `debt`, `note`, `pubat`,
    foreach($custs as $data){
        array_push($cc['data'],array(
            'id'=>$data['id'],
            'fullname'=>$data['fullname'],
            'phone'=>$data['phone'],
            'address'=>$data['address'],
            'debt'=>$data['debt'],
            'note'=>$data['note'],
            'pubat'=>$data['pubat'],
            'act'=>'<button class="btn btn-success btn-xs sharp" onclick ="return edit('.$data["id"].')"><i class="fa fa-pencil"></i></button>
            <button class="btn btn-danger btn-xs sharp" onclick ="return remove('.$data["id"].')"><i class="fa fa-trash"></i></button>
              ',
        ));
    }
    echo json_encode($cc);   
}
if(isset($_GET['d'])){
 $sql = "DELETE FROM `customers` WHERE `id`=:id";
 $db->writedb($sql,array('id'=>trim($_GET['d'])));
 $sql = "DELETE FROM `card` WHERE cid=:id";
 $db->writedb($sql,array('id'=>trim($_GET['d'])));
}
if(isset($_GET['del'])){
    unset($_SESSION['card'][(int)$_GET['del']]);
    $_SESSION['card'] = array_values($_SESSION['card']);
    echo json_encode($_SESSION['card']);
}

if(isset($_GET['pr'])){
    $cust = $db->readdbone("SELECT * FROM `customers` WHERE `id`={$_GET['pr']}");
    echo json_encode($cust);
}
if(isset($_GET['g'])){
    $sql = "SELECT * FROM `card` WHERE `cid`={$_GET['g']}";
    $custs = $db->readdb($sql);
    // `number`, `name`, `bank`, `sdate`, `note`, `file`
   if(!empty($custs)){
foreach($custs as $cust){
    $card = array(
        'id'=>$cust['id'],
        'name'=>$cust['name'],
        'bank'=>$cust['bank'],
        'number'=>$cust['number'],
        'date'=>$cust['sdate'],
        'note'=>$cust['note'],
        'file'=>$cust['file'],
        'fl'=>''
    );
    array_push($_SESSION['card'],$card);
}
    
    echo json_encode($_SESSION['card']);
   }else{
    echo json_encode($_SESSION['card']);  
   }
}

if(isset($_GET['ecard'])){
    $_SESSION['card'][intval($_GET['ecard'])][$_GET['col']] = $_GET['t'];
    $_SESSION['c'] = $_GET['id'];
    // $sql = "UPDATE `card` SET `".$_GET['col']."`='".$_GET['t']."' WHERE `id`={$_GET['ecard']}";
    // $db->writedb($sql);
    echo  $_SESSION['card'][intval($_GET['ecard'])][$_GET['col']];
    var_dump($_SESSION['card']);
}
if(isset($_GET['kill'])){
    $_SESSION['card'] = array();
    $_SESSION['c']='';
}