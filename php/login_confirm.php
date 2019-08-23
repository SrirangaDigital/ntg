<?php

include("common.php");
require_once("connect.php");
require_once('includes/class.phpmailer.php');

if(isset($_POST['pr_email']))
{
    if($_POST['pr_email'] != '')
    {
        $pr_email = $_POST['pr_email'];

        if(!(preg_match("/.*\@[a-zA-Z0-9\.]+\.[a-zA-Z0-9\.]+/", $pr_email)))
		{
			 @header("Location: reset_password.php?status=4");
            exit;
		}
        
        $to = $pr_email;

        $query_l2 = "select password,name,email from details where email='$pr_email'";
        $result_l2 = $mysqli->query($query_l2);
        $num_rows_l2 = $result_l2->num_rows;
        if($num_rows_l2 > 0)
        {
            $row_l2=$result_l2->fetch_assoc();

            $pwd=$row_l2['password'];
            $name=$row_l2['name'];
            $email=$row_l2['email'];
            $tstamp = time();

            $hash = sha1($pwd.$name.$email.$tstamp);
            
            $query_l3 = "INSERT INTO reset values('$hash','$email','$name','$pwd','$tstamp',0)";
            $result_l3 = $mysqli->query($query_l3);
            
            $from = $supportEmail;
            
            $message = "Dear $name,<br /><br />Use the following link within the next 24 hours to reset your password:<br /><a href=\"http://192.155.224.66/stage/ntg/php/reset_password.php?reset=$hash\">http://192.155.224.66/stage/ntg/php/reset_password.php?reset=$hash</a><br /><br />Thanks,<br />Team Natarang";
            $mail = new PHPMailer();
            $mail->isSendmail();
            $mail->isHTML(true);
            $mail->WordWrap = 50;                           
            $mail->IsHTML(true);
            $mail->setFrom($from, 'Natarang Pratishthan');
            $mail->addReplyTo($from, 'Natarang Pratishthan');
            $mail->addAddress($to, $name);
            $mail->addBCC($from);
            $mail->Subject = '[Natarang Pratishthan] Password reset';
            $mail->Body = $message;

            if($mail->send())
            {
                @header("Location: reset_password.php?status=1");
                exit;
            }
            else
            {
                @header("Location: reset_password.php?status=2");
                exit;
            }
        }
        else
        {
            @header("Location: reset_password.php?status=3");
            exit;
        }
    }
}

if(isset($_POST['lemail']))
{
	$lemail = $_POST['lemail'];
	if($lemail == '')
	{
		@header("Location: login.php?error=1");
		exit;
	}
}
else
{
	@header("Location: login.php?error=1");
	exit;
}

if(isset($_POST['lpassword']))
{
	$lpassword = $_POST['lpassword'];
	if($lpassword == '')
	{
		@header("Location: login.php?error=2");
		exit;
	}
}
else
{
	@header("Location: login.php?error=2");
	exit;
}

VerifyCredentials($lemail, $lpassword);

?>
