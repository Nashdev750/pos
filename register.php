<?php
session_start();

if(isset($_SESSION['user'])){
    header("location:index");
}


// echo  password_hash('1234',PASSWORD_DEFAULT);
?>




<!DOCTYPE html>
<html lang="en" class="h-100">

<!-- Mirrored from motaadmin.dexignlab.com/xhtml/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Aug 2021 14:52:34 GMT -->
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
	
    <link href="css/style.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
	
</head>
<body class="h-100" style=" background-color: #1E2746 !important;box-shadow: none !important;">

<div class="authincation h-100">

        <div class="container h-100">
        <center><img src="images/favicon.png" style="height: 60px; margin-top: 60px;" alt=""></center>
            <div class="row justify-content-center h-100 align-items-center" style="flex-direction: column;margin-top: -50px;">
            
                <div class="col-md-6">
                    <div class="authincation-content#">
                        <div class="row no-gutters">
                            
                            <div class="col-xl-12">
                                
                                <div class="auth-form" style=" background-color: #1E2746 !important;box-shadow: none !important;border: 1px solid #4e5364; ">
                                    <h4 class="text-center mb-4" style="color: whitesmoke;">Register</h4>
                                   
                                   
                                    <div class="error"></div>
                                    <form onsubmit="return false" id="frm" method="post">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="username" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Mật khẩu</strong></label>
                                            <input type="password" name="pass" class="form-control">
                                        </div>
                                        <!-- <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label" for="basic_checkbox_1">Nhớ tôi</label>
												</div>
                                            </div>
                                            <div class="form-group">
                                            </div>
                                        </div> -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success btn-block btn-r">Sign Up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <a href="login">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="js/login.js"></script>

</body>


<!-- Mirrored from motaadmin.dexignlab.com/xhtml/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Aug 2021 14:52:34 GMT -->
</html>