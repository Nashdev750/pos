<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;



if(isset($_GET['add'])){
    $sql = "INSERT INTO `pos`(`posname`, `account`, `note`, `data`)
     VALUES (:pos,:acc,:note,:dat)";
  if((int)$_GET['add']>0){
    $sql="UPDATE `pos` SET `posname`=:pos,`account`=:acc,`note`=:note,`data`=:dat WHERE `id`={$_GET['add']}";
  }
     $cc = 'null';
     if(!empty($_SESSION['cardtype'])){
        $_SESSION['cardtype']= array_values($_SESSION['cardtype']);
        $cc  = json_encode($_SESSION['cardtype']);
     }
     $data = array(
         'pos'=>$_POST['name'],
         'acc'=>$_POST['account'],
         'note'=>$_POST['note'],
         'dat'=>$cc
     );
     $id = $db->writedb($sql,$data);
     $_SESSION['cardtype'] = array();
     echo ((int)$_GET['add']>0)?5:$id;
}








if(isset($_GET['load'])){
    $bank = $db->readdb("SELECT * FROM `pos`");
$data = array('data'=>array());
foreach($bank as $item){
  
   //`id`, `posname`, `account`, `note`, `data`

    $one = array(
       'id'=>$item['id'],
       'posname'=>$item['posname'],
       'account'=>$item['account'],
       'note'=>$item['note'],
       "act" =>' 
       <a onclick="return edit('.$item['id'].')" class="btn btn-success shadow btn-xs sharp"><i class="fa fa-pencil"></i></a>
       <a onclick="return delet('.$item['id'].')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
       '
    );
    
    array_push($data['data'],$one);
}    

echo json_encode($data);
}

if(isset($_GET['delete'])){
    $sql="DELETE FROM `pos` WHERE id={$_GET['delete']}";
    $id = $db->writedb($sql);
    echo $id;


}

if(isset($_GET['addcard'])){
  array_push($_SESSION['cardtype'],array('cardtype'=>$_POST['cardtype'],'fee'=>$_POST['fee']));
  echo json_encode(array_values($_SESSION['cardtype']));

}
if(isset($_GET['index'])){
  
    $ind = trim($_GET['index']);
    $_SESSION['cardtype']= array_values($_SESSION['cardtype']);
    unset($_SESSION['cardtype'][intval($ind)]);
    $_SESSION['cardtype']= array_values($_SESSION['cardtype']);
    echo json_encode($_SESSION['cardtype']);
  
  }
  if(isset($_GET['edit'])){
      $data  = $db->readdbone("SELECT * FROM `pos` WHERE id = {$_GET['edit']}");
      $data['data'] = json_decode($data['data'],true);
      
      foreach($data['data'] as $cc){
        array_push($_SESSION['cardtype'],array('cardtype'=>$cc['cardtype'],'fee'=>$cc['fee']));
      }
      echo json_encode($data);
  }