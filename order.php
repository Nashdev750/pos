<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location:login");
}
$_SESSION['card']= array();

spl_autoload_register(function($class){
    include "core/".$class.".php";
});

$db = new db;

$order = $db->readdb("SELECT * FROM `order`");


$accounts = $db->readdb("SELECT * FROM `bankaccounts`");
$pos = $db->readdb("SELECT * FROM `pos`");
$customer = $db->readdb("SELECT * FROM `customers`");
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
    <link href="css/main.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../../cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

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
    
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #fff;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: .5em 1em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    *cursor: hand;
    color: #333 !important;
    border: 1px solid transparent;
    color: whitesmoke !important;
    border-radius: 2px;
}
tr td.plus{
    position: relative;
    cursor: pointer;
}
tr td.plus::before{
    top: 12px;
    left: 4px;
    height: 14px;
    width: 14px;
    display: block;
    position: absolute;
    color: white;
    border: 2px solid white;
    border-radius: 14px;
    box-shadow: 0 0 3px #444;
    box-sizing: content-box;
    text-align: center;
    text-indent: 0 !important;
    font-family: 'Courier New', Courier, monospace;
    line-height: 14px;
    content: '+';
    background-color: #0275d8;
} 
tr td.active::before {  
    
    content: '-';
    background-color: red;
}
.disp{
    display: none;
}
    </style>
</head>

<body data-page = "order">

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
                                           <h4 class="card-title">Quản lý đơn hàng</h4>
                                           <div>
                                               
                                               <button class="btn btn-success" onclick="return exportdata()">Xuất Excel</button>
                                           </div>
                                    </div>
                                    
                                    </div>
                                 
                                    <div class="form-row" style="width: 100%; margin-top: 25px;">
                                    <div class="form-group col-md-2">
                                    <div class="form-group mb-0" style="padding: 10px 30px; ">
                                            <label class="radio-inline mr-3" style="cursor: pointer;"><input type="radio" name="m" id="month"> Tháng</label><br><br>
                                            <label class="radio-inline mr-3" style="cursor: pointer;"><input type="radio" name="m" id="day" checked> Ngày</label>    
                                 </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                                <label>Từ</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="start" id="start" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Đến ngày</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="stop" id="stop" class="form-control">
                                               
                                            </div>
                                          <div class="form-group col-md-2">
                                                <label>Khách hàng</label>
                                                <select name="client" id="client" class="form-control" >
                                                    <option value="">Tất cả</option>
                                                    <?php
                                                      foreach($customer as $client){
                                                    ?>
                                                    <option value="<?=$client['id']?>"><?=$client['fullname'].' - '.$client['phone']?></option>
                                                    <?php
                                                      }
                                                      ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Status</label>
                                                <select name="status" id="statuses" class="form-control" >
                                                    <option value="">Tất cả</option>
                                                    <option value="default">Chưa xong</option>
                                                    <option value="yellow">Còn nợ</option>
                                                    <option value="red">Nợ khách hàng</option>
                                                    <option value="green">Đã xong</option>
                                                </select>
                                            </div>
                                          
                                            <div class="form-group col-md-2">
                                              
                                                <button class="btn btn-success btn-xs" style="margin-top: 24px;" id="calender">Tìm kiếm</button>
                                                <a href="order" style="margin-top: 25px;" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-refresh"></i></a>
                                            </div>
                                       </div>
                                
                                    <hr>
                                    <div class="card-body">
                                          <div class="table-responsive">
                                            <table class="table table-responsive-sm mb-0" id="datat">
                                                <thead>
                                                <tr>
                                                        <th style="min-width:150px;"><strong>#</strong></th>
                                                        <th style="min-width:150px;"><strong>KHÁCH HÀNG</strong></th>
                                                        <th><strong>TỔNG GỬI</strong></th>
                                                        <th><strong>TỔNG THU</strong></th>
                                                        <th><strong>PHÍ</strong></th>
                                                        <th><strong>THỰC THU</strong></th>
                                                        <th><strong>LỢI NHUẬN</strong></th>
                                                        <th><strong>ĐÃ THU</strong></th>
                                                        <th><strong>CÔNG NỢ</strong></th>
                                                        <th style="min-width:85px;"><strong></strong></th>
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
    <div class="pop">
        <div class="popbody" style="margin: 0 auto;">
 
          <div class="card">
                            <div class="card-header" style="width: 100% !important;position: relative;">
                                <div class="row" style="width:100%">
                                    <div class="col-md-2">
                                    <h4 class="card-title">Thêm mới</h4>
                                    </div>
                                    <div class="col-md-9">
                                    <div class="form-group mb-0">
                                            <label class="radio-inline mr-3"><input type="radio" name="n" id="expire" checked>Đáo hạn</label>
                                            <label class="radio-inline mr-3"><input type="radio" name="n" id="other" > Rút tiền</label>    
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
                                                <input type="text" value="0" name="remaining" id="remaining" class="form-control clv" readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Tổng tiền gửi</label>
                                                <input type="text" value="<?=!empty($o)?$o['deposit']:0?>" name="deposit" id="deposit" class="form-control clv" readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Tổng tiền rút</label>
                                                <input type="text" value="<?=!empty($o)?$o['withdrawal']:0?>" name="withdrawal" id="withdrawal" class="form-control clv"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí ngân hàng</label>
                                                <input type="text" value="0" name="bankfee" id="bankfee" class="form-control"readonly style="background-color: #010a3a47 !important;">
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí thu (%)</label>
                                                <input type="number" value="<?=!empty($o)?$o['collection_fee']:0?>" name="collectionfee" id="collectionfee" class="form-control" >
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí ship</label>
                                                <input type="text" value="<?=!empty($o)?$o['shipping_fee']:0?>" name="shippingfee" id="shippingfee" class="form-control clv">
                                               
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
                                     <div class="form-row w d">
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
                                   <button class="btn btn-success" data-id="<?=$id?>" id = "comfirm" style="float: right;margin-top:20px">Cập nhật</button>
                                                
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
                                                <label>Ngày đặt hàng</label>
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
                                                <input type="text" value="0" name="pamount" id="pamount" class="form-control clv" placeholder="0" readonly>
                                               
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Phí POS</label>
                                                <input type="text" value="0" name="psmallfee" id="psmallfee" class="form-control" placeholder="0" readonly>
                                               
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
                                                <input type="date" id="backday" value="<?=date("Y-m-d")?>" name="backday" class="form-control">
                                               
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
                                    <th>PHÍ POS</th>
                                    <th>TRẠNG THÁI</th>
                                    <th>NGÀY QUẸT</th>
                                    <th>NGÀY TIỀN VỀ</th>
                                    <th>GHI CHÚ</th>
                                   </tr>
                                   <tbody id="rows2p">
                                  
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
                                  
                                   </tbody>
                                </table>
                                </div>
                                  </div>
                                <!-- tab -->
                                </div>
                                <button class="btn btn-danger clse" style="float: right; margin-top: 20px; margin-left: 10px;" >Đóng</button>
                                
                                   
                                   
                            </div>
                        </div>
     </div>
      
    </div>
                              
                       
    <div class="errorpop">
        <span></span>
    </div>
    <iframe style="visibility: hidden;" id="download" frameborder="0"></iframe>
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
<!-- <script src="js/Cleave.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
   
    
    
    

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
       const statuses = document.querySelector('#statuses')
       const data = document.querySelector('#datat')
       statuses.addEventListener('change',filter)
       function filter(){
           if(this.value==""){
            data.querySelectorAll('tbody tr').forEach(tr=>tr.classList.remove('disp')) 
           }else{ 

                data.querySelectorAll('tbody tr').forEach(tr=>tr.classList.add('disp'))
               data.querySelectorAll(`tbody tr .${this.value}`).forEach(p=>p.parentNode.parentNode.classList.remove('disp'))
             }
               //console.log(p[0].parentNode.parentNode)

       }
      
    </script>
    
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/order.js"></script>
    <script src="js/card.js"></script>
    <script>
   
    </script>
</body>

<!-- Mirrored from motaadmin.dexignlab.com/xhtml/index-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Aug 2021 14:50:02 GMT -->

</html>