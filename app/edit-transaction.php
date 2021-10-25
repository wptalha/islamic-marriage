<?php
// including the database connection file
include_once("connection.php");

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	
	$benid = $_POST['benid'];
	$amount = $_POST['amount'];
	$currency = $_POST['currency'];	
	$purpose = $_POST['purpose'];	
	$ref = $_POST['ref'];	
	$status = $_POST['status'];	
	
	if(empty($benid) || empty($amount) || empty($currency) || empty($purpose) || empty($ref)) {
				
		if(empty($benid)) {
			echo "<font color='red'>Account field is empty.</font><br/>";
		}
		
		if(empty($amount)) {
			echo "<font color='red'>Amount field is empty.</font><br/>";
		}
		
		if(empty($currency)) {
			echo "<font color='red'>Currency field is empty.</font><br/>";
		}
		
		if(empty($purpose)) {
			echo "<font color='red'>Purpose field is empty.</font><br/>";
		}
		if(empty($ref)) {
			echo "<font color='red'>Ref. field is empty.</font><br/>";
		}	
	} else {	
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE transfer SET benid='$benid', amount='$amount', currency='$currency' , ref='$ref' , status='$status'  WHERE id=$id");
		
		//redirectig to the display page. In our case, it is view.php
		header("Location: view-transaction.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM transfer WHERE id=$id");

while($res = mysqli_fetch_array($result))
{
	$benid = $res['benid'];
	$amount = $res['amount'];
	$currency = $res['currency'];	
	$purpose = $res['purpose'];	
	$ref = $res['ref'];	
	$status = $res['status'];	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Transaction</title>
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
	<h1>Edit Transfer</h1>
	<form name="form1" method="post" action="edit-transaction.php">
		<table border="0">
			<tr> 
				<td>Select Account</td>
				
                				<td><select name="accnum">
<?php

$result1 = mysqli_query($mysqli, "SELECT * FROM transfer WHERE login_id=".$_SESSION['id']."");
?><option value="<?php echo $benid;?>"><?php echo $benid;?></option>
            <?php while($row1 = mysqli_fetch_array($result1)):;?>

            <option value="<?php echo $row1[1]; echo " - " ; echo $row1[2];?>"><?php echo $row1[1]; echo " - " ; echo $row1[2];?></option>

            <?php endwhile;?>

        </select></td>
			</tr>
			<tr> 
				<td>Amount</td>
				<td><input type="text" name="amount" value="<?php echo $amount;?>" required></td>
			</tr>
			<tr> 
				<td>Currency</td>
				<td><select name="currency">  
                <option value="<?php echo $currency;?>" required><?php echo $currency;?></option>
                <option value="GBP">GBP</option>
                <option value="USD">USD</option>
                <option value="Euro">Euro</option>
                <option value="HKD">HKD</option>
                
                </select></td>
			</tr>
            <tr> 
				<td>Purpose</td>
				<td><input type="text" name="purpose" value="<?php echo $purpose;?>" required></td>
			</tr>
            <tr> 
				<td>Reference</td>
				<td><input type="text" name="ref" value="<?php echo $ref;?>" required></td>
			</tr>
            <tr> 
				<td>Status</td>
				<td>
                
                
                <select name="status" required>  
                <option value="<?php echo $status;?>" required><?php echo $status;?></option>
                <option value="GBP">Approved</option>
                <option value="USD">Declined</option>
                <option value="Euro">Processing</option>
                
                
                </select>
                
                
                
                </td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
                </td>
				<td><input class="aded" type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</div> 
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>
