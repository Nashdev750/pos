<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location:login");
}
$_SESSION['card']= array();

spl_autoload_register(function($class){
    include "core/".$class.".php";
});
$_SESSION['post']= array();
$_SESSION['deposite']= array();
$_SESSION['food']= array();

$db = new db;


// card
$data = array();
$arrid = array();
$sl = "989";
$sql = "SELECT * FROM `card` ORDER BY `status` ASC"; 
if(isset($_POST['search'])){
    if(!empty($_POST['start']) && !empty($_POST['stop'])){
        $st =$_POST['start'];
        $p =$_POST['stop'];
       // $d = date("Y-m-d");
        $sql = "SELECT * FROM `card` WHERE `sdate` BETWEEN {$st} AND {$p} ORDER BY `status` ASC";
       if(!empty($_POST['date'])){
           $sl = "SELECT * FROM `order` WHERE `order_date` LIKE '{$_POST['date']}%'";
            $ids = $db->readdb($sl);
            foreach($ids as $da){
                array_push($arrid,$da['card_id']);
            }
       }
    }
}
    
    $custs = $db->readdb($sql);
    foreach($custs as $card){
        
        $name = $db->readname("SELECT * FROM `customers` WHERE id={$card['cid']}","fullname");
        $phn = $db->readname("SELECT * FROM `customers` WHERE id={$card['cid']}","phone");
        array_push($data,array('id'=>$card['id'],'cid'=>$card['cid'],'number'=>$card['number'],'name'=>$card['name'],
        'bank'=>$card['bank'],'sdate'=>$card['date'],'date'=>$card['sdate'],'cname'=>$name,'phone'=>$phn,'status'=>$card['status']));
    } 

// end
$accounts = $db->readdb("SELECT * FROM `bankaccounts`");
$pos = $db->readdb("SELECT * FROM `pos`");
$bts = "";
$shw = "";
$chl = "";
$id = "";
$ty= 0;
$o = array();
if(isset($_GET['id'])){
    $bts  ="bts";
    $id = trim($_GET['id']);
    $shw = "sho";
    $chl = "sh";
    $o = $db->readdbone("SELECT * FROM `order` WHERE id=:id",array('id'=>base64_decode($id)));
    $c = $db->readdbone("SELECT * FROM `customers` WHERE id=:id",array('id'=>$o['cid']));
    $cd = $db->readdbone("SELECT * FROM `card` WHERE id=:id",array('id'=>$o['card_id']));
    $_SESSION['deposite'] = $db->readdb("SELECT * FROM `deposits` WHERE orderid=:id",array('id'=>base64_decode($id)));
    $_SESSION['post'] = $db->readdb("SELECT * FROM `post` WHERE orderid=:id",array('id'=>base64_decode($id)));
    $_SESSION['food'] = $db->readdb("SELECT * FROM `realfood` WHERE orderid=:id",array('id'=>base64_decode($id)));
    $ty = (int)$o['type'];
}





?>


<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MotaAdmin - Bootstrap Admin Dashboard" />
    <meta property="og:title" content="MotaAdmin - Bootstrap Admin Dashboard" />
    <meta property="og:description" content="MotaAdmin - Bootstrap Admin Dashboard" />
    <meta property="og:image" content="social-image.png" />
    <meta name="format-detection" content="telephone=no">
 <!-- PAGE TITLE HERE -->
 <title>QUẢN LÝ - AN TÂM TÀI CHÍNH PHÁT TRIỂN TƯƠNG LAI</title>

<!-- FAVICONS ICON -->
<link rel="shortcut icon" type="image/png" href="images/ss.png" />

    <link href="vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/chartist/css/chartist.min.css">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../../cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <style>
        .d .col-md-2 input,.d .col-md-2 label{
           display: none;
        }
        .dds{
            background-color: pink !important;
        }
        .bts{
            display: none;
        }
    </style>
  
       
          
         
       
</head>

<body data-page="card">


    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
        <a href="index" class="brand-logo">
            <img class="logo-abbr" src="images/favicon.png" alt="">
                <img class="logo-compact" src="images/logo-white.png" alt="">
                <img class="brand-title" src="images/logo-white.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Chat box start
        ***********************************-->
        <div class="chatbox">
            <div class="chatbox-close"></div>
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#notes">Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#alerts">Alerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#chat">Chat</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="chat" role="tabpanel">
                        <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
                            <div class="card-header chat-list-header text-center">
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/><rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/></g></svg></a>
                                <div>
                                    <h6 class="mb-1">Chat List</h6>
                                    <p class="mb-0">Show All</p>
                                </div>
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dz-scroll  " id="DZ_W_Contacts_Body">
                                
                            
                            
                            
                            
                            
                            </div>
                        </div>
                        <div class="card chat dz-chat-history-box d-none">
                            <div class="card-header chat-list-header text-center">
                                <a href="#" class="dz-chat-history-back">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><polygon points="0 0 24 0 24 24 0 24"/><rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000) " x="14" y="7" width="2" height="10" rx="1"/><path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) "/></g></svg>
                                </a>
                                <div>
                                    <h6 class="mb-1">Chat with Khelesh</h6>
                                    <p class="mb-0 text-success">Online</p>
                                </div>
                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><i class="fa fa-user-circle text-primary mr-2"></i> View profile</li>
                                        <li class="dropdown-item"><i class="fa fa-users text-primary mr-2"></i> Add to close friends</li>
                                        <li class="dropdown-item"><i class="fa fa-plus text-primary mr-2"></i> Add to group</li>
                                        <li class="dropdown-item"><i class="fa fa-ban text-primary mr-2"></i> Block</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body msg_card_body dz-scroll" id="DZ_W_Contacts_Body3">
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        Hi, how are you samim?
                                        <span class="msg_time">8:40 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Hi Khalid i am good tnx how about you?
                                        <span class="msg_time_send">8:55 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        I am good too, thank you for your chat template
                                        <span class="msg_time">9:00 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        You are welcome
                                        <span class="msg_time_send">9:05 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        I am looking for your next templates
                                        <span class="msg_time">9:07 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Ok, thank you have a good day
                                        <span class="msg_time_send">9:10 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        Bye, see you
                                        <span class="msg_time">9:12 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        Hi, how are you samim?
                                        <span class="msg_time">8:40 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Hi Khalid i am good tnx how about you?
                                        <span class="msg_time_send">8:55 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        I am good too, thank you for your chat template
                                        <span class="msg_time">9:00 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        You are welcome
                                        <span class="msg_time_send">9:05 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        I am looking for your next templates
                                        <span class="msg_time">9:07 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Ok, thank you have a good day
                                        <span class="msg_time_send">9:10 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                                    </div>
                                    <div class="msg_cotainer">
                                        Bye, see you
                                        <span class="msg_time">9:12 AM, Today</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer type_msg">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Type your message..."></textarea>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success"><i class="fa fa-location-arrow"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="alerts" role="tabpanel">
                        <div class="card mb-sm-3 mb-md-0 contacts_card">
                            <div class="card-header chat-list-header text-center">
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg></a>
                                <div>
                                    <h6 class="mb-1">Notications</h6>
                                    <p class="mb-0">Show All</p>
                                </div>
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/><path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/></g></svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dz-scroll" id="DZ_W_Contacts_Body1">
                              
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="notes">
                        <div class="card mb-sm-3 mb-md-0 note_card">
                            <div class="card-header chat-list-header text-center">
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/><rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/></g></svg></a>
                                <div>
                                    <h6 class="mb-1">Notes</h6>
                                    <p class="mb-0">Add New Nots</p>
                                </div>
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/><path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/></g></svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dz-scroll" id="DZ_W_Contacts_Body2">
                      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Chat box End
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <?php include "partials/header.php"   ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
       <?php include "partials/sidebar.php"   ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
               <!-- content here -->
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                        <div class="card">
                                    <div class="card-header border-0 pb-0" style="display: flex;flex-direction: column;">
                                       <div class="top">
                                           <h4 class="card-title">Danh sách thẻ</h4>
                                           <div>
                                              
                                               <button class="btn btn-success">Xuất Excel</button>
                                           </div>
                                    </div> <hr>
                                    <form method="POST" class="form-row" style="width: 100%;">
                                    <div class="form-row" style="width: 100%;">
                                    <div class="form-group col-md-4">
                                   
                                    </div>
                                    <div class="form-group col-md-2">
                                                <label>Tháng</label>
                                                <input type="month" value="<?=isset($_POST['date'])?$_POST['date']:''?>" name="date" id="start" class="form-control">
                                               
                                            </div>
                                    <div class="form-group col-md-2">
                                                <label>Bắt đầu</label>
                                                <input type="number" value="<?=isset($_POST['start'])?$_POST['start']:0?>" name="start" id="start" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Đến nay</label>
                                                <input type="number" value="<?=isset($_POST['stop'])?$_POST['stop']:0?>" name="stop" id="stop" class="form-control">
                                               
                                            </div>
                                         
                                        
                                          
                                            <div class="form-group col-md-2">
                                                <label for=""></label>
                                               
                                                <button style="margin-top: 24px;" class="btn btn-success btn-xs" type="submit" name="search" id="calender">Tìm kiếm</button>
                                                <?php
                                                if(isset($_POST['search'])){
                                                    ?>
              <a href="card" style="margin-top: 25px;" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-refresh"></i></a>
                                                    <?php
                                                }

?>
                                            </div>
                                       </div>
                                       </form>
                                    
                                    </div>
                                    <div class="card-body">
                                          <div class="table-responsive">
                                            <table class="table table-responsive-sm mb-0" id="datat">
                                                <thead>
                                                    <tr>
                                                        <!-- <th style="width:20px;">
                                                            <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                                                <label class="custom-control-label" for="checkAll"></label>
                                                            </div>
                                                        </th> -->
                                                        <th style="visibility:hidden;width:10px"></th>
                                                        <th><strong>#</strong></th>
                                                        <th><strong>SỐ THẺ</strong></th>
                                                        <th><strong>TÊN THẺ</strong></th>
                                                        <th><strong>NGÂN HÀNG</strong></th>
                                                        <th><strong>NGÀY SAO KÊ</strong></th>
                                                        <th><strong>TÊN KHÁCH HÀNG</strong></th>
                                                        <th><strong>ĐIỆN THOẠI</strong></th>
                                                        <th style="width: 100px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="card">
                                                    
                                                      <?php
                                                      // array_push($data,array('id'=>$card['id'],'cid'=>$card['cid'],'number'=>$card['number'],'name'=>$card['name'],
        //'bank'=>$card['bank'],'date'=>$card['sdate'],'cname'=>$name,'phone'=>$phn));
                                                      $count  = 0;                                    
                                                        
                                                      foreach($data as $card){
                                                         $cna = empty($card['name'])?"Card":$card['name'];
                                                         $na =  $card['cname']?$card['cname']:'Customer';
                                                         $d = date("Y-m-d");
                                                         $c = 0;
                                                         $st = date("Y-m-")."00";
                                                         $c = $db->readdbrow("SELECT * FROM `order` WHERE `card_id` = '{$card['id']}' AND  `order_date` BETWEEN '{$st}' AND '{$d}'");
                                                         
                                                          ?>
                                                           <tr class="<?=isset($_POST['search'])?(!empty($arrid)?(in_array($card['id'],$arrid)?'ordered':''):''):(($c)?'ordered':'')?> <?=(intval($card['status'])==2)?'red':''?>">
                                                               <td style="visibility:hidden;width:10px"class="sorting sorting_desc" aria-label=": activate to sort column descending"><?=$card['sdate']?></td>
                                                               <td><?=++$count?></td>
                                                               <td><?=$card['number']?></td>
                                                               <td><?=$card['name']?></td>
                                                               <td><?=$card['bank']?></td>
                                                               <td><?=$card['date']?></td>
                                                               <td><?=$card['cname']?></td>
                                                               <td><?=$card['phone']?></td>
                                                               <td>
                                                               <a onclick="return norder(<?=$card['id']?>)" style="visibility: <?=(intval($card['status'])==0)?'':'hidden'?>;"  class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-refresh"></i></a>
                                                                  
                                                               <button class="btn btn-success btn-xs" onclick="return showmodal(<?=$card['id']?>, <?=$card['cid']?>, '<?=$na?>', '<?=$cna?>')">Order</button>
                                                               </td>
                                                           </tr>
                                                          <?php
                                                      }


?>
                                                
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    
                            </div>
                        </div>
                    </div>
               <!-- end -->
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
           
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <div class="pop<?=empty($shw)?"":" ".$shw?>">
        <div class="popbody<?=empty($shw)?"":" ".$chl?>">
 
          <div class="card">
                            <div class="card-header" style="width: 100% !important;position: relative;">
                                <div class="row" style="width:100%">
                                    <div class="col-md-2">
                                    <h4 class="card-title">Thêm mới</h4>
                                    </div>
                                    <div class="col-md-9">
                                    <div class="form-group mb-0">
                                            <label class="radio-inline mr-3"><input type="radio" name="n" id="expire" <?=($ty)?'':'checked'?>>Đáo hạn</label>
                                            <label class="radio-inline mr-3"><input type="radio" name="n" id="other" <?=($ty)?'checked':''?>> Rút tiền</label>    
                                 </div>
                                    </div>
                                    <div class="col-md-1">
                                    <h5 class="clse" style="cursor: pointer;color: whitesmoke;position: absolute !important;right: 10px;top:10px">Đóng</h5>
                                    </div>
                                </div>
                          
                                
                              
                            </div>
                            <div class="alert" id="err" style="margin:10px"></div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form method="POST" id="order" onsubmit="return false">

                                        <div class="form-row">
                                    
                                                <input type="hidden" name="customer" value="<?=!empty($c)?$c['fullname']."(".$c['id'].")":''?>" id="customer" class="form-control" readonly>
                                                
                                            <div class="form-group col-md-3" id="newtest">
                                                
                                            </div>
                                            
                                                <input type="hidden" name="card" value="<?=!empty($cd)?$cd['name']."(".$cd['id'].")":''?>" id="selectedcard" class="form-control" readonly>
                                             
                                            <div class="form-group col-md-3" id="newtest2">
                                                
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label id="tt">Tổng tiền phải làm</label>
                                                <input type="text" value="<?=!empty($o)?$o['total']:0?>" name="total" id="total" class="form-control clv">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Tổng tiền còn lại</label>
                                                <input type="text" value="0" name="remaining" id="remaining" class="form-control" readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Tổng tiền gửi</label>
                                                <input type="text" value="0" name="deposit" id="deposit" class="form-control" readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Tổng tiền rút</label>
                                                <input type="text" value="<?=!empty($o)?$o['withdrawal']:0?>" name="withdrawal" id="withdrawal" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí ngân hàng</label>
                                                <input type="text" value="0" name="bankfee" id="bankfee" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí thu(%)</label>
                                                <input type="number" value="<?=!empty($o)?$o['collection_fee']:0?>" name="collectionfee" id="collectionfee" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí ship</label>
                                                <input type="text" value="<?=!empty($o)?$o['shipping_fee']:0?>" name="shippingfee" id="shippingfee" class="form-control clv" style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí khách trả</label>
                                                <input type="text" value="0" name="charge" id="charge" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                       
                                       </div>
                                       <div class="form-row">
                                               <div class="form-group col-md-3">
                                                <label>Thực thu</label>
                                                <input type="text" name="food" value="<?=!empty($o)?$o['food']:0?>" id="realfood" class="form-control" readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Lợi nhuận</label>
                                                <input type="text" value="0" id="profit" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ngày đặt hàng</label>
                                                <input type="date" value="<?=!empty($o)?$o['order_date']:date("Y-m-d")?>" name="orderdate" id="orderdate" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ghi chú</label>
                                                <textarea name="note" id="note" class="form-control" cols="30" rows="2"><?=!empty($o)?$o['note']:''?></textarea>
                                                
                                            </div>
                                       </div>
                                     <div class="form-row w <?=($ty)?'':'d'?>">
                                       <iv class="col-md-3"></iv>
                                     
                                       <div class="form-group col-md-2">
                                                <label>Phải trả lại</label>
                                                <input type="text" value="0" id="mustreturn" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Đã trả</label>
                                                <input type="text" value="0" id="paid" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Còn lại</label>
                                                <input type="text" value="0" id="remain" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                   <button class="btn btn-success <?=empty($bts)?" bts":""?>" data-id="<?=$id?>" id = "comfirm" style="float: right;margin-top:20px">Cập nhật</button>
                                                
                                           </div>
                                     </div>
                                    </form>
                                 
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="tabs">
                                        <div class="active" data-t="0"><span>Tiền gửi</span></div>
                                        <div class="" data-t="1"><span>POS</span></div>
                                        <div class="" data-t="2"><span>Đã thu</span></div>
                                    </div>
                                </div>
                            <div class="row tab">
                                <!-- tab -->
                                <div class="col-md-12 ts act">
                                   <form onsubmit="return false" id="depo" method="POST">
                                     <div class="form-row">
                                        <div class="form-group col-md-3">
                                                <label>Tài khoản</label>
                                                <select name="daccount" id="daccount" class="form-control" >
                                                    <option value="">Chọn tài khoản</option>
                                                    <?php
                                                      foreach($accounts as $ac){
                                                    ?>
                                                         <option value="<?=$ac['id']?>"><?=$ac['bankname']?>--<?=$ac['accountnumber']?></option>
                                                    <?php
}
                                                    ?>
                                                  
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Số tiền</label>
                                                <input type="text" value="0" name="damount" id="damount" class="form-control clv" placeholder="0">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ngày gửi</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="ddate" id="ddate" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ghi chú</label>
                                                <textarea name="dnote" id="dnote" class="form-control" cols="30" rows="2"></textarea>
                                                
                                            </div>
                                            <div class="form-group col-md-1">
                                               
                                            </div>
                                            <div class="form-group col-md-11">
                                               
                                                <button class="btn btn-success" id="fdeposit" style="float: right;">Thêm</button>
                                            </div>
                                     </div>
                                 </form>   
                                <div class="table-responsive">
                                  <table class="table table-responsive-sm mb-0" id="cdt" style="min-width:100%">
                                   <tr>
                                   <th>TÀI KHOẢN</th>
                                    <th>SỐ TIỀN</th>
                                    <th>NGÀY GỬI</th>
                                    <th>GHI CHÚ</th>
                                    <th></th>
                                   </tr>
                                   <tbody id="rows1d">
                                   <?php
                                    if(!empty($_SESSION['deposite'])){
                                        foreach($_SESSION['deposite'] as $d){
                                        ?>
                                       <tr>
                                        <th><?=$d['account']?></th>
                                        <th><?=$d['amount']?></th>
                                        <th><?=$d['orderdate']?></th>
                                        <th><?=$d['note']?></th>
                                    
                                        <td onclick ="return remove(<?=$d['id']?>,'rdepo')"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <?php
                                    }}

?>
                                   </tbody>
                                </table>
                                </div>
                                  </div>
                                <!-- tab -->
                                    <!-- tab 2-->
                                    <div class="col-md-12 ts">
                                 <form onsubmit="return false" method="POST" id="post">
                                     <div class="form-row">
                                           <div class="form-group col-md-3">
                                                <label>POS</label>
                                                <select name="pcard" id="ppos" class="form-control" >
                                                    <option value="">Chọn POS</option>
                                                    <?php
                                                      foreach($pos as $ac){
                                                    ?>
                                                         <option value="<?=$ac['id']?>"><?=$ac['posname']?></option>
                                                    <?php
}
                                                    ?>
                                                  
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Loại POS</label>
                                                <select name="ptype" id="ptype" class="form-control" >
                                                    <option value="">Chọn loại POS</option>
                                                    <?php
                                                      foreach($pos as $ac){
                                                          $data = json_decode($ac['data'],true);
                                                          foreach($data as $type){
                                                    ?>
                                                         <option class="" id="id_<?=$ac['id']?>"  value="<?=$type['cardtype']."-".$type['fee']?>"><?=$type['cardtype']?>--<?=$type['fee']?></option>
                                                    <?php
}}
                                                    ?>
                                                  
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Số tiền</label>
                                                <input type="text" value="0" name="pamount" id="pamount" class="form-control clv" placeholder="0">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí POS</label>
                                                <input type="text" value="0" name="psmallfee" id="psmallfee" class="form-control clv" placeholder="0" readonly>
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Trạng thái tiền về</label>
                                                <select name="moneystatus" id="moneystatus" class="form-control" >
                                                    <option value="">Trạng thái tiền về</option>
                                                    <option value="1">Đã về</option>
                                                    <option value="2" selected>Chưa về</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ngày quẹt POS</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="swipeday" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ngày tiền về</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="backday" id="backday" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ghi chú</label>
                                                <textarea name="pnote" id="" class="form-control" cols="30" rows="2"></textarea>
                                                
                                            </div>
                                            <div class="form-group col-md-1">
                                               
                                               </div>
                                            <div class="form-group col-md-11">
                                                <button class="btn btn-success" id="pbtn" style="float: right;">Thêm</button>
                                            </div>
                                     </div>
                                 </form>   
                                <div class="table-responsive">
                                  <table class="table table-responsive-sm mb-0" id="cdt" style="min-width:100%">
                                   <tr>
                                   <th>POS</th>
                                    <th>LOẠI POS</th>
                                    <th>SỐ TIỀN</th>
                                    <th>KHOẢN PHÍ NHỎ</th>
                                    <th>TRẠNG THÁI</th>
                                    <th>NGÀY QUẸT</th>
                                    <th>NGÀY VỀ</th>
                                    <th>GHI CHÚ</th>
                                   </tr>
                                   <tbody id="rows2p">
                                   <?php
                                    if(!empty($_SESSION['post'])){
                                        foreach($_SESSION['post'] as $d){
                                        ?>
                                       <tr>
                                        <th><?=$d['post']?></th>
                                        <th><?=$d['posttype']?></th>
                                        <th><?=$d['amount']?></th>
                                        <th><?=$d['smallfee']?></th>
                                        <th><?=$d['moneystatus']?></th>
                                        <th><?=$d['swipeday']?></th>
                                        <th><?=$d['backday']?></th>
                                        <th><?=$d['note']?></th>
                                        <td onclick ="return remove(<?=$d['id']?>,'rpost')"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <?php
                                    }}

?>
                                   </tbody>
                                </table>
                                </div>
                                  </div>
                                <!-- tab -->
                                    <!-- tab 3-->
                                    <div class="col-md-12 ts">
                                 <form onsubmit="return false" id="real">
                                     <div class="form-row">
                                     <div class="form-group col-md-3">
                                                <label>Tài khoản thu</label>
                                                <select name="raccount" id="realc" class="form-control" >
                                                    <option value="">Chọn tài khoản</option>
                                                    <?php
                                                      foreach($accounts as $ac){
                                                    ?>
                                                         <option value="<?=$ac['id']?>"><?=$ac['bankname']?>--<?=$ac['accountnumber']?></option>
                                                    <?php
}
                                                    ?>
                                                  
                                                 
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Số tiền thu</label>
                                                <input type="text" value="0" name="ramount" class="form-control clv" placeholder="0">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ngày thu</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="actualday" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Ghi chú</label>
                                                <textarea name="rnote" id="" class="form-control" cols="30" rows="2"></textarea>
                                                
                                            </div>
                                            <div class="form-group col-md-1">
                                               
                                               </div>
                                            <div class="form-group col-md-11">
                                                <button class="btn btn-success" id="realbtn" style="float: right;">Thêm</button>
                                            </div>
                                     </div>
                                 </form>   
                                <div class="table-responsive">
                                  <table class="table table-responsive-sm mb-0" id="cdt" style="min-width:100%">
                                   <tr>
                                   <th>TÀI KHOẢN</th>
                                    <th>SỐ TIỀN</th>
                                    <th>NGÀY THU</th>
                                    <th>GHI CHÚ</th>
                                    <th></th>
                                   </tr>
                                   <tbody id="rows3re">
                                   <?php
                                    if(!empty($_SESSION['food'])){
                                        foreach($_SESSION['food'] as $d){
                                        ?>
                                       <tr>
                                        <th><?=$d['account']?></th>
                                        <th><?=$d['amount']?></th>
                                        <th><?=$d['day']?></th>
                                        <th><?=$d['note']?></th>
                                    
                                        <td onclick ="return remove(<?=$d['id']?>,'rfood')"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <?php
                                    }}

?>
                                   </tbody>
                                </table>
                                </div>
                                  </div>
                                <!-- tab -->
                                </div>
                                <button class="btn btn-danger clse" style="float: right; margin-top: 20px; margin-left: 10px;" >Đóng</button>
                             <button type="submit" data-id="0" id="comfirm" style="float: right; margin-top: 20px;" class="btn btn-success<?=empty($bts)?"":" bts"?>">Xác nhận</button>
                              
                            </div>
                        </div>
     </div>
      
    </div>
    <div class="errorpop">
        <span></span>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script src="js/order.js"></script>
    <script src="js/card.js"></script>
   
    
    
    <!-- Apex Chart -->
    <script src="vendor/apexchart/apexchart.js"></script>

    <!-- Vectormap -->
    <!-- Chart piety plugin files -->
    <script src="vendor/peity/jquery.peity.min.js"></script>

    <!-- Chartist -->
    <script src="vendor/chartist/js/chartist.min.js"></script>

    <!-- Dashboard 1 -->
    <script src="js/dashboard/dashboard-1.js"></script>
    <!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>

    <script>
        function getUrlParams(dParam) {
            var dPageURL = window.location.search.substring(1),
                dURLVariables = dPageURL.split('&'),
                dParameterName,
                i;

            for (i = 0; i < dURLVariables.length; i++) {
                dParameterName = dURLVariables[i].split('=');

                if (dParameterName[0] === dParam) {
                    return dParameterName[1] === undefined ? true : decodeURIComponent(dParameterName[1]);
                }
            }
        }

        (function($) {
            "use strict"

            var direction = getUrlParams('dir');
            if (direction != 'rtl') {
                direction = 'ltr';
            }

            var dezSettingsOptions = {
                typography: "roboto",
                version: "light",
                layout: "vertical",
                headerBg: "color_1",
                navheaderBg: "color_3",
                sidebarBg: "color_1",
                sidebarStyle: "full",
                sidebarPosition: "fixed",
                headerPosition: "fixed",
                containerLayout: "wide",
                direction: direction
            };

            new dezSettings(dezSettingsOptions);

            jQuery(window).on('resize', function() {

                var sidebar = 'full';
                var screenWidth = jQuery(window).width();
                if (screenWidth < 600) {
                    sidebar = 'overlay';
                } else if (screenWidth > 600 && screenWidth < 1199) {
                    sidebar = 'mini';
                }

                dezSettingsOptions.sidebarStyle = sidebar;

                new dezSettings(dezSettingsOptions);
            });

        })(jQuery);
     
    </script>
      <script src="js/jquery.dataTables.min.js"></script>
      <?php
        $ord = 'desc';
         if(isset($_POST['search'])){
          $ord = 'asc';
         }
      ?>
    <script>
          $(document).ready(function(){
            $('#datat').DataTable({
                "order":[[0,"desc"]]
            });
        });
    </script>

</body>

<!-- Mirrored from motaadmin.dexignlab.com/xhtml/index-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Aug 2021 14:50:02 GMT -->

</html>