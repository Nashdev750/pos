<?php
include 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
if(!isset($_SESSION['user'])){
    header("location:login");
    
}
$expr = strtotime($_SESSION['user']['expiry']);
$now = strtotime(date('Y-m-d'));
if($now < $expr){
    header("location:index");
}
if(isset($_POST['trial'])){
    sendEmail('Trial',$_POST['amount']);
}
if(isset($_POST['month'])){
    sendEmail('Monthly',$_POST['amount']);
}
if(isset($_POST['yearly'])){
    sendEmail('Annual',$_POST['amount']);
}


function sendEmail($type, $amount){
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    // Enable verbose debug output
    $mail->SMTPDebug = 2;
    
    // Set the SMTP server details
    $mail->isSMTP();
    $mail->Host = 'mothetindung247.one';
    $mail->SMTPAuth = true;
    $mail->Username = 'pos@mothetindung247.one';
    $mail->Password = 'your-email-password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    // Set the email details
    $mail->setFrom('pos@mothetindung247.one', 'POS');
    $mail->addAddress('nashdev750@gmail.com', $_SESSION['user']['username']);
    $mail->Subject = $type.' Subscription Request';
    $mail->Body = $_SESSION['user']['username'].' request '.$type.' Subscription @'.$amount;
    
    // Send the email
    if ($mail->send()) {
        echo 'Email sent successfully!';
    } else {
        echo 'An error occurred while sending the email: ' . $mail->ErrorInfo;
    }   
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request subscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="w-full flex justify-center items-center h-[100vh] gap-4 max-md:flex-col max-md:justify-start max-md:mt-4">
        <div class="w-[250px] shadow-md p-4 h-[300px] border rounded flex flex-col justify-between">
            <h3 class='font-bold text-[#2f1c6a]'>7 Days Free Trial</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius, accusamus asperiores facilis saepe doloribus omnis aut eum fugit eaque dolorem,.</p>
            <form method="post" class="w-full">
                <input type="hidden" name="trial">
                <input type="hidden" name="amount" value = "0.00">
              <button class='bg-[#673de6] text-[#fff] p-2 w-full font-bold uppercase rounded'>Request</button>
            </form>
        </div>
        <div class="w-[250px] shadow-md p-4 h-[300px] border rounded flex flex-col justify-between">
            <h3 class='font-bold text-[#2f1c6a]'>Monthly Subscription</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius, accusamus asperiores facilis saepe doloribus omnis aut eum fugit eaque dolorem,.</p>
            <div>
            <p>₫<strong class="text-[25px] text-[#2f1c6a] p-1">900,000</strong>/mon</p>
            <form method="post" class="w-full">
                <input type="hidden" name="month">
                <input type="hidden" name="amount" value = "900,000">
              <button class='bg-[#673de6] text-[#fff] p-2 w-full font-bold uppercase rounded'>Request</button>
            </form>
            </div>
            
        </div>
        <div class="w-[250px] shadow-md p-4 h-[300px] border rounded flex flex-col justify-between">
            <h3 class='font-bold text-[#2f1c6a]'>Annual Subscription</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius, accusamus asperiores facilis saepe doloribus omnis aut eum fugit eaque dolorem,.</p>
            <div>
            <p>₫<strong class="text-[25px] text-[#2f1c6a] p-1">9,000,000</strong>/year</p>
            <form method="post" class="w-full">
                <input type="hidden" name="yearly">
                <input type="hidden" name="amount" value = "9,000,000">
              <button class='bg-[#673de6] text-[#fff] p-2 w-full font-bold uppercase rounded'>Request</button>
            </form>
            </div>
            
        </div>
    </div>
</body>
</html>