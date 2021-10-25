<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Beneficiary</title>
<link href="style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="main">
<div class="mainwrp">

<?php
include("head.php");	
?>

<div class="mainin">
		<?php
include("nav.php");	
?>
        <div class="rgt">  
        <h1>Add New Beneficiary</h1>
<?php
//including the database connection file
include_once("connection.php");

if(isset($_POST['Submit'])) {	
	$name = $_POST['name'];
	$pan = $_POST['pan'];
	$accnum = $_POST['accnum'];
	$sc = $_POST['sc'];
	$iban = $_POST['iban'];	
	$country = $_POST['country'];
	$bank = $_POST['bank'];
	$badd = $_POST['badd'];
	$loginId = $_SESSION['id'];
		
	// checking empty fields
	if(empty($name) || empty($pan) || empty($accnum) || empty($sc) || empty($iban) || empty($country) || empty($bank) || empty($badd)) {
				
		if(empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		if(empty($pan)) {
			echo "<font color='red'>Platform Account Number field is empty.</font><br/>";
		}
		if(empty($accnum)) {
			echo "<font color='red'>Account number field is empty.</font><br/>";
		}
		if(empty($sc)) {
			echo "<font color='red'>Swift Ccode field is empty.</font><br/>";
		}
		if(empty($iban)) {
			echo "<font color='red'>IBAN No field is empty.</font><br/>";
		}
		if(empty($country)) {
			echo "<font color='red'>Country field is empty.</font><br/>";
		}
		
		if(empty($bank)) {
			echo "<font color='red'>Bank field is empty.</font><br/>";
		}
		if(empty($badd)) {
			echo "<font color='red'>Bank address field is empty.</font><br/>";
		}
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$result = mysqli_query($mysqli, "INSERT INTO beneficiary(name, pan, accnum, sc, iban, country, bank, badd, login_id) VALUES('$name', '$pan', '$accnum','$sc','$iban','$country','$bank', '$badd', '$loginId')");
		
		//display success message
		echo "<font color='green'>Beneficiary Added successfully.";
		echo "<br/>";
		echo "<br/>";
		echo "<br/><a href='view-beneficiary.php'>View Beneficiary</a>";
	}
}
?>
 </div>   
	
</div>
   
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>
