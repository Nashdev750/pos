<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location:login");
}
$_SESSION['card']= array();
$_SESSION['c']=0;
spl_autoload_register(function($class){
    include "core/".$class.".php";
});

$db = new db;
$sq = "SELECT * FROM `revenue`";
if(isset($_POST['search'])){
   $sq = "SELECT * FROM `revenue` WHERE `day` BETWEEN '{$_POST['start']}' AND '{$_POST['stop']}'";
   if(!empty($_POST['status'])) {
    $sq = "SELECT * FROM `revenue` WHERE `status`='{$_POST['status']}' AND `day` BETWEEN '{$_POST['start']}' AND '{$_POST['stop']}'"; 
   }
}
$rev = $db->readdb($sq);
$accounts = $db->readdb("SELECT * FROM `bankaccounts`");
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
               <!-- content here -->
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                        <div class="card">
                                    <div class="card-header border-0 pb-0" style="display: flex;flex-direction: column;">
                                       <div class="top">
                                           <h4 class="card-title">Quản lý thu chi</h4>
                                           <div>
                                               <button class="btn btn-success btn-sm" onclick="return showmodal()">Thêm mới</button>
                                               
                                           </div>
                                    </div>
                                    <form method="POST" style="width: 100%;">
                                    <div class="form-row" style="width: 100%; margin-top: 25px;">
                                    
                                    <div class="form-group col-md-2">
                                                <label>Từ</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="start" id="start" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Đến ngày</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="stop" id="stop" class="form-control">
                                               
                                            </div>
                                         
                                            <div class="form-group col-md-2">
                                                <label>Loại</label>
                                                <select name="status" id="status" class="form-control" >
                                                    <option value="">Tất cả</option>
                                                    <option value="1">Thu</option>
                                                    <option value="2">Chi</option>
                                                    
                                                </select>
                                            </div>
                                          
                                            <div class="form-group col-md-2">
                                                <label for=""></label>
                                                <button style="margin-top: 24px;" class="btn btn-success btn-xs" type="submit" name="search" id="calender">Tìm kiếm</button>
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
                                                        <th><strong>#</strong></th>
                                                        <th><strong>KIỂU</strong></th>
                                                        <th><strong>TÀI KHOẢN</strong></th>
                                                        <th><strong>SỐ TIỀN</strong></th>
                                                        <th><strong>SỐ LƯỢNG</strong></th>
                                                        <th><strong>TIỀN VÀO</strong></th>
                                                        <th><strong>NGÀY</strong></th>
                                                        <th><strong>GHI CHÚ</strong></th>

                                                        <th style="width:85px;"><strong></strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $c = 0;
                                                    setlocale(LC_MONETARY,'en_US');
                                                    foreach($rev as $cust){
                                                         $a = doubleval($cust['amount'])*doubleval($cust['quantity']);
                                                         $ac = $db->readdbone("SELECT * FROM `bankaccounts` WHERE `id`='{$cust['account']}'");
                                                        // `fullname`, `phone`, `address`, `debt`, `note`, `pubat`,
                                                        //`id`, `account`, `amount`, `quantity`, `day`, `note`, `status
                                                    ?>
                                                      
                                                      <tr>
                                                          <td><?=++$c?></td>
                                                        <td><?=intval($cust['status'])==1?"Collect":"Spend"?></td>
                                                        <td><?=$ac['bankname']."--".$ac['accountnumber']?></td>
                                                        <td><?=number_format(doubleval($cust['amount']))?></td>
                                                        <td><?=$cust['quantity']?></td>
                                                        <td><?=number_format(round($a))?></td>
                                                        <td><?=$cust['day']?></td>
                                                        <td><?=$cust['note']?></td>
                                                        
                                                        <td>
                                                        <button class="btn btn-success btn-xs sharp" onclick ="return edit(<?=$cust['id']?>)"><i class="fa fa-pencil"></i></button>
                                                        <button class="btn btn-danger btn-xs sharp" onclick ="return remove(<?=$cust['id']?>)"><i class="fa fa-trash"></i></button>
                                                            
                                                    </td>
                                                    </tr>
                                                     <?php
}
                                                     ?>
                                                
                                                    
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
    <div class="pop" style="overflow-y: auto;">
        <div class="popbody" style="max-width: 70%;">
 
          <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" style="width: 100%;">Thêm <small class="clse" style="float: right;cursor: pointer;">Đóng</small></h4>
                            </div>
                            <div class="alert" id="err" style="margin:10px"></div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form method="POST" id="rev" onsubmit="return false">

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                            <div class="form-group mb-0">
                                            <label class="radio-inline mr-3"><input type="radio" name="c" value="1" id="collect" checked>Thu</label>
                                            <label class="radio-inline mr-3"><input type="radio" name="c" value="2" id="spend" > Chi</label>    
                                        </div>
                                            </div>
                                            
                                            <div class="form-group col-md-10"></div>
                                            <div class="form-group col-md-6">
                                                <label>Ngày</label>
                                                <input type="date" value="<?=date("Y-m-d")?>" name="day" id="day" class="form-control">
                                               
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Số tiền</label>
                                                <input type="text" value="0" name="amount" id="amount" class="form-control clv">
                                               
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label>Tài khoản</label>
                                                <select name="account" id="account" class="form-control" >
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
                                            <div class="form-group col-md-6">
                                                <label>Số lượng</label>
                                                <input type="text" value="1" name="qty" id="qty" class="form-control clv">
                                               
                                            </div>
                                           
                                            <div class="form-group col-md-6">
                                                <label>Ghi chú</label>
                                                <textarea name="note" id="" class="form-control" cols="30" rows="3"></textarea>
                                               
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Thành tiền</label>
                                                <input type="text" value="0" name="inamount" id="inamount" class="form-control clv" readonly>
                                               
                                            </div>
                                           
                                       
                                       
                                    </form>
                                </div>
                 
                              
                                <button class="btn btn-danger clse" style="float: right; margin-top: 20px; margin-left: 10px;" >Đóng</button>
                                <button type="submit" id="save" style="float: right; margin-top: 20px;" class="btn btn-success">Thêm</button>
                              
                            </div>
                        </div>
     </div>
      
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    *************************
    **********-->
 
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script src="js/collection.js"></script>
    
    

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
          $(document).ready(function(){
            $('#datat').DataTable()
        })
    </script>
     <!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
       <script type="text/javascript">
    googleTranslateElementInit()
        function googleTranslateElementInit() {
            $.when(
                new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'es',
                    layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT}, 'google_translate_element')
            ).done(function(){
                var select = document.getElementsByClassName('goog-te-combo')[0];
                select.selectedIndex = 105;
                select.addEventListener('click', function () {
                    select.dispatchEvent(new Event('change'));
                });
                select.click();
            });
        } -->
    </script>
</body>

<!-- Mirrored from motaadmin.dexignlab.com/xhtml/index-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Aug 2021 14:50:02 GMT -->

</html>