<?php

session_start(); 
require_once('recaptchalib.php');
$publickey = "6Lc6KPMSAAAAAJ-yzoW7_KCxyv2bNEZcLImzc7I8";
$privatekey = "6Lc6KPMSAAAAANrIJ99zGx8wxzdUJ6SwQzk1BgXX";

$resp = null;
$error = null;

if (isset($_POST["recaptcha_response_field"])) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        if ($resp->is_valid) {
				
        } else {
				@header("Location: login.php?error=11#regForm");
				exit;
        }
}

if(isset($_POST['name'])){$name = $_POST['name'];if($name == ''){@header("Location: login.php?error=4#regForm");exit;}}else{@header("Location: login.php?error=4#regForm");exit;}

if(isset($_POST['email']))
{
	$email = $_POST['email'];
	if($email == '')
	{
		@header("Location: login.php?error=5#regForm");
		exit;
	}
	else
	{
		if(!(preg_match("/.*\@[a-zA-Z0-9\.]+\.[a-zA-Z0-9\.]+/", $email)))
		{
			@header("Location: login.php?error=10#regForm");
			exit;
		}
	}
}
else
{
	@header("Location: login.php?error=5#regForm");
	exit;
}

/*
if(isset($_POST['info'])){$info = $_POST['info'];if($info == ''){@header("Location: login.php?error=6#regForm");exit;}}else{@header("Location: login.php?error=6#regForm");exit;}
*/
if(isset($_POST['info'])){$info = $_POST['info'];}else{$info = '';}
if(isset($_POST['password'])){$pwd = $_POST['password'];if($pwd == ''){@header("Location: login.php?error=7#regForm");exit;}}else{@header("Location: login.php?error=7#regForm");exit;}
if(isset($_POST['cpassword'])){$cpassword = $_POST['cpassword'];if($cpassword == ''){@header("Location: login.php?error=8#regForm");exit;}}else{@header("Location: login.php?error=8#regForm");exit;}
if($pwd != $cpassword)
{
	@header("Location: login.php?error=9#regForm");
	exit;
}

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Natarang</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/indexstyle.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    	$( "#triggerRegistration" ).click(function(){
            $( "#registration" ).toggleClass( "hide" );
            $(window).scrollTop($("#registration").offset().top - 20);
        })
    })
</script>
</head>
<body>

<div class="page">
	<div class="header">		
		<div class="flow">
			<img src="images/nt1.png" alt="" />
		</div>
		<div class="sa">
			<img src="images/logo.png" alt="Natarang Logo" class="logo"/>
		</div>
		<div class="title">
			<p>नटरंग</p>
			<p class="sml">भारतीय रंगमंच का त्रैमासिक</p>
		</div>
	</div>
	<div class="mainpage">';

include("connect.php");

$query_l2 = "select count(*) from details where email='$email'";
$result_l2 = mysql_query($query_l2);
$row_l2=mysql_fetch_assoc($result_l2);
$num=$row_l2['count(*)'];

if($num == 0)
{
	$salt = "shankara";
	$pwd = sha1($salt.$pwd);
	$query = "INSERT INTO details values('$name','$email','$info','$pwd','','','0','1','')";
	$result = mysql_query($query);

	if($result)
	{
		$_SESSION['email'] = $email;
		$_SESSION['valid'] = 1;
		
		echo "<p class=\"fgentium small clr\">Registration Successful!</p>";		
		echo "<div class=\"fgentium small regs\" style=\"text-align: left\">";
		echo "<p>Thank you for registering!</p>";
		echo "<p class=\"clr2\"><a href=\"volumes.php\">Click here to continue browsing</a></p>";
		echo "</div>";
	}
}
else
{
	echo '<p class="fgentium small clr">This e-mail id seems to be already registered with us. Try logging in or use another id.</p>
		<form method="post" action="login_confirm.php">
		<div class="registration">
			<div class="otherp">
				<ul>
					 <li>
						<h2 class="clr2 required_notification"><?php echo $err_str;?></h2>
						<h2 class="big clr2">Login</h2>
					</li>
					<li>
						<label for="lemail">Email&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="text" name="lemail" id="lemail" />
					</li>
					<li>
						<label for="lpassword">Password&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="password" name="lpassword" id="lpassword" />
					</li>
                    <li id="pr_email_show">
						<label for="pr_email" class="clr2">Enter your email address</label><br />
						<input class="rinput" type="text" name="pr_email" id="pr_email" />
 					</li>
					<li id="regForm">
						<input class="rsubmit" type="submit" name="submit" value="submit"/>
                        <p class="forgotPassword flright clr2"><a href="javascript:void(0);" onclick="$(\'#lemail\').prop(\'disabled\', true);$(\'#lpassword\').prop(\'disabled\', true);$(\'#regForm h2\').hide();$(\'#pr_email_show\').show();">Forgot your password?</a></p>
						<h2 class="clr2" style="margin-top: 2em;"><a href="javascript:void(0);" id="triggerRegistration">Click here to register, if you are a first time user</a></h2>
					</li>
				</ul>
			</div>
		</div>
		</form>
		<form method="post" action="register.php" id="registration" class="hide">
		<div class="registration">
			<div class="otherp">
				<ul>
					 <li>
						<h2 class="clr2 required_notification"><?php echo $err_str_registration; ?></h2>
						<h2 class="big clr2">Registration</h2>
					</li>
					<li>
						<label for="name">Name&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="text" name="name" />
					</li>
					<li>
						<label for="email">Email&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="text" name="email" />
					</li>
					<li>
						<label for="info">Information about yourself</label><br />
						<textarea class="rinput tinput" name="info" placeholder="Please tell us your background, interests and anything else you would like to share with us"></textarea>
					</li>
					<li>
						<label for="password">Password&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="password" name="password" />
					</li>
					<li>
						<label for="cpassword">Confirm Password&nbsp;<span class="clr2">*</span></label><br />
						<input class="rinput" type="password" name="cpassword" />
					</li>
					<li>';
require_once('recaptchalib.php');
$publickey = "6Lc6KPMSAAAAAJ-yzoW7_KCxyv2bNEZcLImzc7I8";
$privatekey = "6Lc6KPMSAAAAANrIJ99zGx8wxzdUJ6SwQzk1BgXX";
echo recaptcha_get_html($publickey);

echo '					</li>
					<li>
						<input class="rsubmit" type="submit" name="submit" value="submit"/>
					</li>
				</ul>
			</div>
		</div>
		</form>';
}

?>
	</div>
</body>
</html>
