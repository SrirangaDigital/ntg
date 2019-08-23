<?php

session_start();

include("connect.php");
require_once("common.php");
require_once('recaptchalib.php');
require_once('includes/class.phpmailer.php');
$publickey = "6Lc6KPMSAAAAAJ-yzoW7_KCxyv2bNEZcLImzc7I8";
$privatekey = "6Lc6KPMSAAAAANrIJ99zGx8wxzdUJ6SwQzk1BgXX";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Natarang</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/indexstyle.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/nav.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<div class="page">
    <div class="header">        
        <div class="flow">
            <img src="images/nt1.png" alt="" />
        </div>
        <div class="sa">
            <a href="../index.html"><img src="images/logo.png" alt="Natarang Logo" class="logo"/></a>
        </div>
        <div class="title">
            <p>नटरंग</p>
            <p class="sml">भारतीय रंगमंच का त्रैमासिक</p>
        </div>
    </div>
    <div class="mainpage">
<?php

if(isset($_GET['status']))
{
    $status_message = array("1"=>"An email has been sent to your address. Use the link given there within the next 24 hours to reset your password.<br />If you have not received the email yet, check in your spam folder.","2"=>"Error encountered in resetting the password.<br /><br /><a href=\"login.php\">Click here to try again.</a>","3"=>"It seems the email entered is not registered with us!<br /><br /><a href=\"login.php#regForm\">Click here to register yourself.</a>","4"=>"Invalid email!<br /><br /><a href=\"login.php\">Click here to try again.</a>");
    $status_str = "&nbsp;";
    $status_str = $status_message{$_GET['status']};
    echo "<p class=\"fgentium small clr\">$status_str</p>";
}
elseif(isset($_GET['reset']))
{
    $reset = $_GET['reset'];
    
    $error_val = 0;
    $error_message = array("0"=>"","1"=>"New Password field empty<br />","2"=>"Confirm new password field empty<br />","3"=>"Passwords not in confirmation<br />","4"=>"Invalid CAPTCHA! Please try again<br />");
    if(isset($_POST['cpassword'])){$cpwd = $_POST['cpassword'];if($cpwd == ''){$error_val = 4;}}else{$cpwd = '';}
    if(isset($_POST['password'])){$pwd = $_POST['password'];if($pwd == ''){$error_val = 5;}}else{$pwd = '';}
    if($pwd != $cpwd){$error_val = 3;}
    
    $resp = null;
    $error = null;
    
    $isfirst = 1;
    if($error_val == 0)
    {
        
        if(!isset($_POST['g-recaptcha-response'])) {
                
            $error_val = 4;
        }
        else{
            
            $isfirst = 0;
            $secretKey = "6LcI9TUUAAAAANBORusXxUGtUEJ_NQA0JFl3eZ1N";
            $ip = $_SERVER['REMOTE_ADDR'];
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=". $_POST['g-recaptcha-response'] . "&remoteip=".$ip);
            $responseKeys = json_decode($response,true);

            if(intval($responseKeys["success"])){

            }
            else{

                $error_val = 4;
            }
        }
    }
    
    if(hasResetExpired($reset))
    {
       echo "<p class=\"fgentium small clr\">Password reset link has expired.<br /><br /><a href=\"login.php\">Click here try to again.</a></p>";
    }
    elseif(($error_val == 0) && ($isfirst == 0))
    {
        $salt = "shankara";
        $npwd = sha1($salt.$pwd);
        
        $query_aux = "select * from reset where hash='$reset'";
        $result_aux = $mysqli->query($query_aux);        
        $num_rows_aux = $result_aux->num_rows;
        
        if($num_rows_aux > 0)
        {
            $row_aux=$result_aux->fetch_assoc();

            $email=$row_aux['email'];
            $name=$row_aux['name'];        
            $pwd=$row_aux['password'];        
        
            $query = "UPDATE details set password='$npwd' where email='$email' and name='$name'";
            $result = $mysqli->query($query);
            
            if(($result) || ($npwd == $pwd))
            {
                $query = "DELETE from reset where hash='$reset' and email='$email' and name='$name'";
                $result = $mysqli->query($query);
            
                echo "<p class=\"fgentium small clr\">Password sucessfully reset.<br /><br /><a href=\"login.php\">Click here to login.</a></p>";
                $from = $supportEmail;
                
                $message = "Dear $name,<br /><br />Your password has been sucessfully reset.<br /><br />Thanks,<br />Team Natarang";
                $mail = new PHPMailer();
                $mail->isSendmail();
                $mail->isHTML(true);
                $mail->WordWrap = 50;
                $mail->IsHTML(true);
                $mail->setFrom($from, 'Natarang Pratishthan');
                $mail->addReplyTo($from, 'Natarang Pratishthan');
                $mail->addAddress($email, $name);
                $mail->addBCC($from);
                $mail->Subject = '[Natarang Pratishthan] Password reset';
                $mail->Body = $message;

                $mail->send();
            }
            else
            {
                echo "<p class=\"fgentium small clr\">Error encountered in resetting the password.<br /><br /><a href=\"login.php\">Click here try to again.</a></p>";
            }
        }
        else
        {
            echo "<p class=\"fgentium small clr\">Password reset link has expired.<br /><br /><a href=\"login.php\">Click here try to again.</a></p>";
        }
    }
    else
    {
        $err_str = $error_message{$error_val};
?>

    <p class="fgentium small clr">Reset your password</p>
<?php
    echo "<form method=\"post\" action=\"reset_password.php?reset=$reset\">";
?>
        <div class="registration">
            <div class="otherp">
                <ul>
                    <li>
						<h2 class="clr2 required_notification"><?php echo $err_str;?></h2>
						<h2 class="big clr2">Login</h2>
					</li>
                   <li>
						<label for="password">New password&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="password" name="password" />
					</li>
					<li>
						<label for="cpassword">Confirm new password&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="password" name="cpassword" />
					</li>
					<li>
                        <div class="g-recaptcha" data-sitekey="6LcI9TUUAAAAAL32HwFrer1FGoG1NkFrvNKjCzgI"></div>
					</li>
                    <li>
						<input class="rsubmit" type="submit" name="submit" value="submit"/>
					</li>
                </ul>
            </div>
        </div>
        </form>
<?php
    }
}
?>
    </div>
    <div class="footer_inside">
        <p style="float: left;">
            नटरंग प्रतिष्ठान<br />
            ७०६, सुमॆरु अपार्टमेंट<br />
            इ डि एम् माल के समीप, कौशाम्बि<br />
            ग़ाज़ियाबाद, उत्तर प्रदेश २०१ ०१०<br />
            भारत.<br /><br />
            &copy; २०१५, नटरंग प्रतिष्ठान
        </p>
        <p style="float: right;">
            Natarang Pratishthan<br />
            706, Sumeru Apartments<br />
            Near EDM mall, Kaushambi<br />
            Ghaziabad, Uttar Pradesh 201 010<br />
            INDIA.<br /><br />
            &copy; 2015, Natarang Pratishthan
        </p>
    </div>
</div>
</body>
</html>
