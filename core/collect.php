<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;
if(isset($_GET['in'])){
  $sql = "INSERT INTO `revenue`(`account`, `amount`, `quantity`, `day`,`note`, `status`)
   VALUES ('{$_POST['account']}','{$_POST['amount']}','{$_POST['qty']}','{$_POST['day']}','{$_POST['note']}','{$_POST['c']}')";
   if(!empty($_GET['id']) && intval($_GET['id'])>0){
       $sql = "UPDATE `revenue` SET `account`='{$_POST['account']}',
       `amount`='{$_POST['amount']}',`quantity`='{$_POST['qty']}',
       `day`='{$_POST['day']}',`note`='{$_POST['note']}',`status`='{$_POST['c']}' WHERE id={$_GET['id']}";
   }
 
 $id = $db->writedb($sql);
  echo $id;

}
if(isset($_GET['del'])){
  $db->writedb("DELETE FROM `revenue` WHERE `id`={$_GET['del']}");
}
if(isset($_GET['edit'])){
    $data = $db->readdbone("SELECT * FROM `revenue` WHERE `id`={$_GET['edit']}");
    echo json_encode($data);
  }