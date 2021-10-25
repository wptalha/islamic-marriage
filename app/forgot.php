<html>
<head>
	<title>Forgot Password</title><link href="style.css" rel="stylesheet" type="text/css"><meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="hm login-page"><div class="mainwrp">
<img src="hk-logo.png" ><br><br>
<?php
		
		include("connection.php");
		
		//require('PHPMailer/PHPMailerAutoload.php');
if(isset($_POST) & !empty($_POST)){
	$username = mysqli_real_escape_string($mysqli, $_POST['username']);
	$sql = "SELECT * FROM `login` WHERE username = '$username'";
	$res = mysqli_query($mysqli, $sql);
	$count = mysqli_num_rows($res);
	if($count == 1){
		$r = mysqli_fetch_assoc($res);
		$password = $r['password'];
		$to = $r['email'];
		$subject = "Your Recovered Password";
 
		$message = "Please use this password to login " . $password;
		$headers = "From : info@hkinvestment.hk";
		if(mail($to, $subject, $message, $headers)){
			echo "Your Password has been sent to your email id";
		}else{
			echo "Failed to Recover your password, try again";
		}
 
	}else{
		echo "User name does not exist in database";
	}
}
 
 
 			
		
	?>
			
		<form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Password Recovery</h2>
        <div class="input-group">
	 
	  <input type="text" name="username" class="form-control" placeholder="Username" required>
	</div>
	<br />
        <button class="btn btn-lg btn-primary btn-block aded" type="submit" >Recover Password</button>
       
      </form>
    <a style="text-decoration:none; font-size:16px;" href="apply.php">Register</a> |  <a style="text-decoration:none; font-size:16px;" href="login.php">Login</a>

</div>
</body>
</html>
