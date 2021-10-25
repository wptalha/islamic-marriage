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
		<div class="lft"> 
        </div>
        <div class="rgt">  
<h1>Account Transaction</h1>
<?php
//including the database connection file
//include_once("connection.php");

if(isset($_POST['Submit'])) {	
    $ref = $_POST['ref'];
	$login_id = $_POST['lid'];
	$descrip = $_POST['descrip'];
	$dte = $_POST['dte'];
	$currency = $_POST['currency'];
	
	$drcr = $_POST['drcr'];
	//$cr = $_POST['amnt'];
	$type = $_POST['type'];
	if ($type=="debit") {
	//echo "debited <br>";
	//echo "$ref <br>";
		//echo "$login_id <br>";
			//echo "$desc <br>";
				//echo "$dte <br>";
					//echo "$drcr <br>";
					
					$result = mysqli_query($mysqli, "INSERT INTO transfer(ref,login_id,descrip, dte, dr,currency) VALUES('$ref','$login_id','$descrip','$dte','$drcr','$currency')");
					//print_r ($result);
	//or die("."); 
	echo "Account Debited";
	}
	else {  
	//$result = mysqli_query($mysqli, "INSERT INTO transfer(ref,login_id,descrip, dte, cr) VALUES('$ref','$login_id','$descrip','$dte','$drcr')");
	$result = mysqli_query($mysqli, "INSERT INTO transfer(ref,login_id,descrip, dte, cr,currency) VALUES('$ref','$login_id','$descrip','$dte','$drcr','$currency')");
					//print_r ($result);
	//or die("."); 
	echo "Account Credited";
	}
	//mysqli_query($mysqli, "INSERT INTO transfer(ref,login_id, desc, dte, dr) VALUES('1', '20,'123','2018-05-08','100')");
	//or die(".");
	//$loginId = $_SESSION['id'];
		
	// checking empty fields
	
}
?>
 </div> 
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>
