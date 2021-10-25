<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
// including the database connection file
include_once("connection.php"); 
//$query = "SELECT name FROM `beneficiary`";
//$result1 = mysqli_query($connect, $query);

//$result1 = mysqli_query($mysqli, "SELECT name FROM beneficiary WHERE login_id=".$_SESSION['id']."");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Transaction</title>
<link href="style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="main">
<div class="mainwrp">

<?php
include("head.php");	
?>

<div class="mainin">
		<div class="lft"> <a href="view-transaction.php">View All Transaction</a><br> <br>
        <a href="add-transaction.php">Request New Transfer</a><br><br>
        <a href="add-benficiary.php">Add New Beneficiary</a><br><br>
        <a href="view-beneficiary.php">View All Beneficiary</a><br><br>
        </div>
        <div class="rgt">  
<h1>Request New Transfer</h1>
<?php
//including the database connection file
//include_once("connection.php");

if(isset($_POST['Submit'])) {	
	//$accnum = $_POST['accnum'];
	//$bpn = $_POST['bpn'];
	$benid = $_POST['benid'];
	$amount = $_POST['amount'];
	$currency = $_POST['currency'];
	$purpose = $_POST['purpose'];
	
	$loginId = $_SESSION['id'];
		
	// checking empty fields
	if(empty($amount) || empty($currency) || empty($purpose)) {
				
		
		
		if(empty($amount)) {
			echo "<font color='red'>Amount field is empty.</font><br/>";
		}
		
		if(empty($currency)) {
			echo "<font color='red'>Currency field is empty.</font><br/>";
		}
		
		if(empty($purpose)) {
			echo "<font color='red'>Purpose field is empty.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$result = mysqli_query($mysqli, "INSERT INTO transfer(benid, amount, currency, purpose, login_id) VALUES('$benid', '$amount','$currency','$purpose',  '$loginId')");
		
		//display success message
		echo "<font color='green'>New Transfer Request Sent Successfully.";
		echo "<br/>";
		echo "<br/>";
		echo "<br/><a href='view-transaction.php'>View Transfer</a>";
	}
}
?>
 </div> 
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>
