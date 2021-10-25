<?php session_start(); ?>
<html>
<head>
	<title>HK Payment Solutions Internet Banking</title>
	<link href="style.css" rel="stylesheet" type="text/css"><meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="hm login-page">
<div class="mainwrp">
	<img src="hk-logo.png" ><br><br>
		<h3>HK Payment Solutions Internet Banking</h3>
        <h3>Admin Panel</h3>
	
	<?php
	if(isset($_SESSION['valid'])) {			
		include("connection.php");					
		$result = mysqli_query($mysqli, "SELECT * FROM login");
	?>
				
		Welcome <?php echo $_SESSION['name'] ?> ! <a href='logout.php'>Logout</a><br/>
		<br/>
		<a class="aded" href='main.php'>Click here to Manage </a> 
		<br/><br/>
	<?php	
	} else {
		echo "You must be logged in to view this page.<br/><br/>";
		echo "<a class='aded' href='main.php'>Click here to Manage</a> ";
	}
	?>
<?php
include("footer.php");	
?>    </div>
</body>
</html>
