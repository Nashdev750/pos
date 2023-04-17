<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location:login");
    
}
// $expr = strtotime($_SESSION['user']['expiry']);
// $now = strtotime(date('Y-m-d'));
// if($now > $expr){
//     header("location:subscription");
// }
$_SESSION['card']= array();
$_SESSION['post']= array();
$_SESSION['deposite']= array();
$_SESSION['food']= array();


$_SESSION['card']= array();

spl_autoload_register(function($class){
    include "core/".$class.".php";
});
$d = date('Y-m-d');
$st = date('Y-m-')."1";
$sp = date('Y-m-')."30";
setlocale(LC_MONETARY,'en_US');
$db = new db;
$strm = $db->readdb("SELECT * FROM `order` WHERE `order_date`='{$d}'");
$mstrm = $db->readdb("SELECT * FROM `order` WHERE `order_date` BETWEEN '{$st}' AND '{$sp}'");
$cust =  $db->readdbrow("SELECT * FROM `customers`");
$newcust =  $db->readdbrow("SELECT * FROM `customers` WHERE `pubat`='{$d}'");
$order =  $db->readdbrow("SELECT * FROM `order`");
$neworder =  $db->readdbrow("SELECT * FROM `order` WHERE `order_date`='{$d}'");
$s=0;
foreach($strm as $o){
  $s+=round(doubleval(str_replace(',','',$o['deposit'])));    
}
$ms=0;
foreach($mstrm as $o){
  $ms+=round(doubleval(str_replace(',','',$o['deposit'])));    
}



?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from motaadmin.dexignlab.com/xhtml/index-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Aug 2021 14:50:02 GMT -->

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
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <link href="../../cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

    
</head>

<body>

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
                <div class="row">
                    <div class="col-xl-9 col-xxl-12">
                        <div class="row">
                            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body pb-0 px-4 pt-4">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="mb-1"><?=$cust?> Customers</h5>
                                                <span class="text-success"><?=$newcust?> new today</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper">
                                        <canvas id="areaChart_2" class="chartjs-render-monitor" height="90"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                                <div class="card bg-success	overflow-hidden">
                                    <div class="card-body pb-0 px-4 pt-4">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="text-white mb-1"><?=$order?> Đặt hàng</h5>
                                                <span class="text-white"><?=$neworder?> Ngay moi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper" style="width:100%">
                                        <span class="peity-line" data-width="100%">6,2,8,4,3,8,4,3,6,5,9,2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body pb-0 px-4 pt-4">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="mb-1"><strong><?=number_format($s)?></strong></h5><br>
                                                <span class="text-success">Luồng hôm nay</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper">
                                        <canvas id="areaChart_2" class="chartjs-render-monitor" height="90"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body pb-0 px-4 pt-4">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="mb-1"><strong><?=number_format($ms)?></strong></h5><br>
                                                <span class="text-success">Luồng của tháng này</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper">
                                        <canvas id="areaChart_2" class="chartjs-render-monitor" height="90"></canvas>
                                    </div>
                                </div>
                            </div>
                          
                            <!--  -->
                            <!-- <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-header border-0 pb-0">
                                        <h4 class="card-title">Timeline</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="DZ_W_TimeLine1" class="widget-timeline dz-scroll style-1" style="height:250px;">
                                            <ul class="timeline">
                                                <li>
                                                    <div class="timeline-badge primary"></div>
                                                    <a class="timeline-panel text-muted" href="#">
                                                        <span>10 minutes ago</span>
                                                        <h6 class="mb-0">Youtube, a video-sharing website <strong class="text-primary">$500</strong>.</h6>
                                                    </a>
                                                </li>
                                                <li>
                                                    <div class="timeline-badge info">
                                                    </div>
                                                    <a class="timeline-panel text-muted" href="#">
                                                        <span>20 minutes ago</span>
                                                        <h6 class="mb-0">New order placed <strong class="text-info">#XF-2356.</strong></h6>
                                                        <p class="mb-0">Quisque a consequat ante Sit...</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <div class="timeline-badge danger">
                                                    </div>
                                                    <a class="timeline-panel text-muted" href="#">
                                                        <span>30 minutes ago</span>
                                                        <h6 class="mb-0">john just buy your product <strong class="text-warning">Sell $250</strong></h6>
                                                    </a>
                                                </li>
                                                <li>
                                                    <div class="timeline-badge success">
                                                    </div>
                                                    <a class="timeline-panel text-muted" href="#">
                                                        <span>15 minutes ago</span>
                                                        <h6 class="mb-0">StumbleUpon is acquired by eBay. </h6>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="col-xl-8 col-xxl-8 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-header border-0 pb-0">
                                        <h4 class="card-title">Recent Payments Queue</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-responsive-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20px;">
                                                            <div class="custom-control custom-checkbox checkbox-primary check-lg mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                                                <label class="custom-control-label" for="checkAll"></label>
                                                            </div>
                                                        </th>
                                                        <th><strong>STATUS.</strong></th>
                                                        <th><strong>NAME</strong></th>
                                                        <th><strong>DATE</strong></th>
                                                        <th><strong>STATUS</strong></th>
                                                        <th style="width:85px;"><strong>EDIT</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox check-lg mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                                                <label class="custom-control-label" for="customCheckBox2"></label>
                                                            </div>
                                                        </td>
                                                        <td><b>$542</b></td>
                                                        <td>Dr. Jackson</td>
                                                        <td>01 August 2021</td>
                                                        <td class="recent-stats d-flex align-items-center"><i class="fa fa-circle text-success mr-1"></i>Successful</td>
                                                        <td>
                                                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox check-lg mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customCheckBox3" required="">
                                                                <label class="custom-control-label" for="customCheckBox3"></label>
                                                            </div>
                                                        </td>
                                                        <td><b>$2000</b></td>
                                                        <td>Dr. Jackson</td>
                                                        <td>01 August 2021</td>
                                                        <td class="recent-stats d-flex align-items-center"><i class="fa fa-circle text-danger mr-1"></i>Canceled</td>
                                                        <td>
                                                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox check-lg mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customCheckBox4" required="">
                                                                <label class="custom-control-label" for="customCheckBox4"></label>
                                                            </div>
                                                        </td>
                                                        <td><b>$300</b></td>
                                                        <td>Dr. Jackson</td>
                                                        <td>01 August 2021</td>
                                                        <td class="recent-stats d-flex align-items-center"><i class="fa fa-circle text-warning mr-1"></i>Pending</td>
                                                        <td>
                                                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox check-lg mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customCheckBox5" required="">
                                                                <label class="custom-control-label" for="customCheckBox5"></label>
                                                            </div>
                                                        </td>
                                                        <td><b>$2000</b></td>
                                                        <td>Dr. Jackson</td>
                                                        <td>01 August 2021</td>
                                                        <td class="recent-stats d-flex align-items-center"><i class="fa fa-circle text-danger mr-1"></i>Canceled</td>
                                                        <td>
                                                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- <div class="col-xl-3 col-xxl-4 col-lg-12 col-md-12">
                        <div class="card bg-primary text-white">
                            <div class="card-header pb-0 border-0">
                                <h4 class="card-title text-white">TOP PRODUCTS</h4>
                            </div>
                            <div class="card-body">
                                <div class="widget-media">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media mr-2">
                                                    <img alt="image" width="50" src="images/avatar/1.jpg">
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-1 text-white">Dr Sultads Send You</h5>
                                                    <small class="d-block">29 July 2021 - 02:26 PM</small>
                                                </div>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
														<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
													</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media mr-2 media-info">
                                                    KG
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-1 text-white">Resport created</h5>
                                                    <small class="d-block">29 July 2021 - 02:26 PM</small>
                                                </div>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
														<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
													</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media mr-2 media-success">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-1 text-white">Reminder : Treatment</h5>
                                                    <small class="d-block">29 July 2021 - 02:26 PM</small>
                                                </div>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
														<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
													</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <canvas id="lineChart_3Kk"></canvas>
                        </div>

                        <!-- <div class="col-lg-12 col-sm-12">
                                <div class="card bg-primary">
                                    <div class="card-header border-0 pb-0">
                                        <h4 class="card-title">Dual Line Chart</h4>
                                    </div>
                                    <div class="card-body">
                                       
                                    </div>
									 <canvas id="lineChart_3Kk"></canvas>
                                </div>
                            </div> -->
                    <!-- </div>
                    <div class="col-xl-3 col-xxl-4 col-lg-6 col-md-6">
                        <div class="card bg-info activity_overview">
                            <div class="card-header  border-0 pb-3 ">
                                <h4 class="card-title text-white">Activity</h4>
                            </div>
                            <div class="card-body pt-0">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs mb-2">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#sale">Sale</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " data-toggle="tab" href="#overview">Overview</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="sale">
                                            <canvas id="chart_widget_4"></canvas>
                                        </div>
                                        <div class="tab-pane fade " id="overview" role="tabpanel">
                                            <div class="pt-4 text-white">
                                                <h4 class="text-white">This is home title</h4>
                                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
                                                </p>
                                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-xl-3 col-xxl-4 col-lg-6 col-md-6">
                        <div class="card active_users">
                            <div class="card-header bg-success border-0 pb-0">
                                <h4 class="card-title text-white">Active Users</h4>
                            </div>
                            <div class="bg-success">
                                <canvas id="activeUser" height="200"></canvas>
                            </div>
                            <div class="card-body pt-0">
                                <div class="list-group-flush mt-4">
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1 font-weight-semi-bold border-top-0" style="border-color: rgba(255, 255, 255, 0.15)">
                                        <p class="mb-0">Top Active Pages</p>
                                        <p class="mb-0">Active Users</p>
                                    </div>
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1" style="border-color: rgba(255, 255, 255, 0.05)">
                                        <p class="mb-0">/bootstrap-themes/</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1" style="border-color: rgba(255, 255, 255, 0.05)">
                                        <p class="mb-0">/tags/html5/</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                    <div class="list-group-item bg-transparent d-xxl-flex justify-content-between px-0 py-1 d-none" style="border-color: rgba(255, 255, 255, 0.05)">
                                        <p class="mb-0">/</p>
                                        <p class="mb-0">2</p>
                                    </div>
                                    <div class="list-group-item bg-transparent d-xxl-flex justify-content-between px-0 py-1 d-none" style="border-color: rgba(255, 255, 255, 0.05)">
                                        <p class="mb-0">/preview/falcon/dashboard/</p>
                                        <p class="mb-0">2</p>
                                    </div>
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1" style="border-color: rgba(255, 255, 255, 0.05)">
                                        <p class="mb-0">/100-best-themes...all-time/</p>
                                        <p class="mb-0">1</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-xl-6 col-xxl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                               <canvas style="border: 1px solid transparent;" id="speedChart" width="1000" height="300"></canvas>
                            </div>
                            </div>
                    </div>
                    <div class="col-xl-6 col-xxl-12 col-lg-12 col-md-12">
                    <div class="card">
                                    <div class="card-header border-0 pb-0" style="display: flex;flex-direction: column;">
                                       <div class="top">
                                           <h4 class="card-title">POS</h4>
                                           <div>
                                               
                                               <!-- <button class="btn btn-success"></button> -->
                                           </div>
                                    </div> <hr>
                                    
                                    </div>
                                    <div class="card-body">
                                          <div class="table-responsive">
                                            <table class="table table-responsive-sm mb-0" id="datat">
                                                <thead>
                                                <tr>
                                                        <th><strong>#</strong></th>
                                                        <th><strong>ĐẶT HÀNG</strong></th>
                                                        <th><strong>NGÀY QUẸT</strong></th>
                                                        <th><strong>POS</strong></th>
                                                        <th><strong>SỐ TIỀN</strong></th>
                                                        <th><strong>NGÀY VỀ</strong></th>
                                                        <th><strong>TRẠNG THÁI</strong></th>
                                                        <th style="width:85px;"><strong>
                                                            
                                                        </strong></th>
                                                    </tr>
                                                        
                                                </thead>
                                                <tbody>
                                  
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                      
                                                        <th><strong></strong></th>
                                                        <th><strong></strong></th>
                                                        <th><strong></strong></th>
                                                        <th><strong></strong></th>
                                                        <th><strong></strong></th>
                                                        <th><strong></strong></th>
                                                        <th><strong></strong></th>
                                    

                                                        <th style="width:85px;"><strong></strong></th>
                                                    </tr>
                                                        
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    
                                       
                                    
                            </div>
                    </div>
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
    <script>
        let fm = Intl.NumberFormat('en-US')
        //   $(document).ready(function(){
        //     $('#datat').DataTable()
        // })
        function format ( d ) {
    //         "type" => $type ,
    //    "date" => $item['order_date'] ,
    //    "sdate" => $sdate ,
    //    "bankfee" => $fee ,
    //    "ship
    // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                    '<td>Small Fee:</td>'+
                    '<td>'+d.smallfee+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Money Back:</td>'+
                    '<td>'+ fm.format(Math.round(Number(d.amount.replace(/,/g,''))-Number(d.smallfee.replace(/,/g,''))))+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Notes:</td>'+
                    '<td>'+d.note+'</td>'+
                '</tr>'+
                
            '</table>';
}
 
$(document).ready(function() {
    var table = $('#datat').DataTable( {
        "ajax":{
            'url':'core/post.php?in'
        },
        "columns": [
            {
                "className":      'details-control plus',
                "orderable":      false,
                "data":           'id',
                "defaultContent": ''
            },
            
            { "data": "order" },
            { "data": "swipeday" },
            { "data": "post" },
            { "data": "amount" },
            { "data": "backday" },
            { "data": "moneystatus" },
            { "data": "act" }
        ],
        "order": [[1, 'asc']]
    } );
  
    $('#datat tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
         $('td.details-control').removeClass('active')
         $('tr').removeClass('shown');
        if ( row.child.isShown() ) {
            // This row is already open - close it
            $(this).removeClass('active')
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            $(this).addClass('active')
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );
function delet(id){
        let ok = confirm("Delete this item?")
        if(ok){
            fetch(`core/post.php?del=${id}`)
            .then(res=>res.text())
            .then(data=>{
                location.reload()
            })
        }
    }
    function comeback(id,s){
        let ok = confirm("Change mone status?")
        if(ok){
            fetch(`core/post.php?money=${id}&s=${s}`)
            .then(res=>res.text())
            .then(data=>{
                location.reload()
            })
        }
    }

    //chart
    getdata();
    function getdata(){
        fetch(`core/chart.php`)
            .then(res=>res.json())
            .then(data=>{
                console.log(data)
                chart(data.order,data.customer,data.day)
            })
    }

      function chart(order,customer,labl){
        var speedCanvas = document.getElementById("speedChart");

//Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var dataFirst = {
    label: "Orders",
    data: order,
    lineTension: 0,
    fill: false,
    borderColor: 'red'
  };

var dataSecond = {
    label: "Customer",
    data: customer,
    lineTension: 0,
    fill: false,
  borderColor: 'blue'
  };

var speedData = {
  labels: labl,
  datasets: [dataFirst, dataSecond]
};

var chartOptions = {
  legend: {
    display: true,
    position: 'top',
    labels: {
      boxWidth: 80,
      fontColor: 'whitesmoke'
    }
  }
};

var lineChart = new Chart(speedCanvas, {
  type: 'line',
  data: speedData,
  options: chartOptions
});
      }
    </script>
</body>

<!-- Mirrored from motaadmin.dexignlab.com/xhtml/index-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Aug 2021 14:50:02 GMT -->

</html>