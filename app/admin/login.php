<?php session_start(); ?>
<html>
<head>
	<title>Login</title><link href="style.css" rel="stylesheet" type="text/css"><meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="hm login-page"><div class="mainwrp">
<img src="hk-logo.png" ><br><br>
	
<?php
include("connection.php");

if(isset($_POST['submit'])) {
	$user = mysqli_real_escape_string($mysqli, $_POST['username']);
	$pass = mysqli_real_escape_string($mysqli, $_POST['password']);

	if($user == "" || $pass == "") {
		echo "Either username or password field is empty.";
		echo "<br/>";
		echo "<a href='login.php'>Go back</a>";
	} else {
		$result = mysqli_query($mysqli, "SELECT * FROM login WHERE username='$user' AND power='9' AND password='$pass'")
					or die("Could not execute the select query.");
		
		$row = mysqli_fetch_assoc($result);
		
		if(is_array($row) && !empty($row)) {
			$validuser = $row['username'];
			$_SESSION['valid'] = $validuser;
			$_SESSION['name'] = $row['name'];
			$_SESSION['id'] = $row['id'];
		} else {
			echo "Invalid username or password.";
			echo "<br/>";
			echo "<a href='login.php'>Go back</a>";
		}

		if(isset($_SESSION['valid'])) {
          echo "<script language='javascript' type='text/javascript'> location.href='main.php' </script>";
			//header('Location: main.php');		
          
		}
	}
} else {
?>
	<p><font size="+2">Login</font></p>
	<form class="lgn" name="form1" method="post" action="">
		<table width="100%" border="0">
			<tr> 
				<td width="10%">Username</td>
				<td><input type="text" name="username" placeholder="type username" required></td>
			</tr>
			<tr> 
				<td>Password</td>
				<td><input type="password" name="password" placeholder="type password" required></td>
			</tr>
			<tr> 
				<td>&nbsp;</td>
				<td><input class="aded" type="submit" name="submit" value="Submit"></td>
			</tr>
		</table>
	</form>
    
<?php
}
?>
</div>
</body>
</html>
