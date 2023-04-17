<?php
 session_start();
spl_autoload_register(function($class){
    include $class.".php";
});

$db = new db;



if(isset($_GET['add'])){
    $sql = "INSERT INTO `bankaccounts`(`bankname`, `accountnumber`, `accountname`, `note`)
     VALUES (:bank,:account,:name,:note)";
     if((int)$_GET['add']>0){
         $sql = "UPDATE `bankaccounts` SET `bankname`=:bank,`accountnumber`=:account,`accountname`=:name,`note`=:note WHERE `id`={$_GET['add']}";
     }
     $data = array(
         'bank'=>$_POST['name'],
         'account'=>$_POST['number'],
         'name'=>$_POST['account'],
         'note'=>$_POST['note']
     );
     $id = $db->writedb($sql,$data);
     echo ((int)$_GET['add']>0)?5:$id;
}
if(isset($_GET['edit'])){
 $data = $db->readdbone("SELECT * FROM `bankaccounts` WHERE `id`={$_GET['edit']}");
 echo json_encode($data);
}







if(isset($_GET['load'])){
    $bank = $db->readdb("SELECT * FROM `bankaccounts`");
$data = array('data'=>array());
foreach($bank as $item){
  
   //`id`, `bankname`, `accountnumber`, `accountname`, `note`

    $one = array(
        'id'=>"<span style='margin-left:20px'>".$item['id']."</span>",
       'bankname'=>$item['bankname'],
       'accountnumber'=>$item['accountnumber'],
       'accountname'=>$item['accountname'],
       'col'=>'<label class="checkbox-inline">
       <input type="checkbox" data-toggle="toggle">
     </label>',
       'real'=>'<label class="checkbox-inline">
       <input type="checkbox" data-toggle="toggle">
     </label>',
       'order'=>"0",
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
    $sql="DELETE FROM `bankaccounts` WHERE id={$_GET['delete']}";
    $id = $db->writedb($sql);
    echo $id;


}