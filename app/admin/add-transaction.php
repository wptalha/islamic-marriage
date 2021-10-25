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
<h1>Debit / Credit Account</h1>
	<form action="add-trans.php" method="post" name="form1">
		<table border="0">
        <tr> 
				<td>Date</td>
				<td><input type="date" name="dte" required></td>
			</tr>
			<tr> 
				<td>Select User</td>
			  <td><select name="lid" required>
<?php

$result1 = mysqli_query($mysqli, "SELECT * FROM login where id!='1'");
?><option value="">Select</option>
            <?php while($row1 = mysqli_fetch_array($result1)):;?>

            <option value="<?php echo $row1[0];?>"><?php echo $row1[3]; echo " - " ; echo $row1[10];?></option>

            <?php endwhile;?>

        </select>  </td>
			</tr>
            <!--<tr> 
				<td>Beneficiary Platform Account # </td>
				<td><input type="text" name="bpn" required></td>
			</tr>-->
            
            <tr> 
				<td>Transaction Type</td>
				<td><select name="type" required>  
                <option value="">Select</option>
                <option value="debit">Debit</option>
                <option value="credit">Credit</option>
                
                
                </select></td>
			</tr>
            
			<tr> 
				<td>Amount</td>
				<td><input type="number" name="drcr" required></td>
			</tr>
            <tr> 
				<td>Currency</td>
				<td><select name="currency" required>  
                <option value="">Select</option>
                <option value="£">GBP</option>
                <option value="$">USD</option>
                <option value="€">EURO</option>
               
                
                </select></td>
			</tr>
			<tr> 
				<td>Reference</td>
				<td><input type="text" name="ref" required></td>
			</tr>
			<tr> 
            <tr> 
				<td>Description</td>
				<td><input type="text" name="descrip" ></td>
			</tr>
			<tr> 
				<td></td>
				<td><input class="aded" type="submit" name="Submit" value="Add Transaction"></td>
			</tr>
		</table>
	</form>
</div>
        
        
        
	

    </div> 
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>

