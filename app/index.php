<?php session_start(); ?>
<html>
<head>
	<title>HK Payment Solutions Internet Banking</title>
	<link href="style.css" rel="stylesheet" type="text/css"><meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="hm login-page">
<div class="mainwrp">
	<img src="hk-logo.png" ><br><br>
		<h3>Welcome to HK Payment Solutions Internet Banking</h3>
	
	<?php
	if(isset($_SESSION['valid'])) {			
		include("connection.php");					
		$result = mysqli_query($mysqli, "SELECT * FROM login");
	?>
				
		Welcome <?php echo $_SESSION['name'] ?> ! <a href='logout.php'>Logout</a><br/>
		<br/>
		<a class="aded" href='view-beneficiary.php'>Add/view Beneficiary</a> <a class="aded" href='view-transaction.php'>View/add Transfer</a> 
		<br/><br/>
	<?php	
	} else {
		echo "You must be logged in to view this page.<br/><br/>";
		echo "<a class='aded' href='login.php'>Login</a> <a class='aded' href='apply.php'>Apply Now </a>";
	}
	?>
<?php
include("footer.php");	
?>    </div>
</body>
</html>
