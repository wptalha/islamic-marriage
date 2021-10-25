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
<?php
include("nav.php");	
?>
        <div class="rgt">  
<h1>Request New Transfer</h1>
	<form action="transaction.php" method="post" name="form1">
		<table border="0">
			<tr> 
				<td>Beneficiary Account</td>
			  <td><select name="benid" required>
<?php

$result1 = mysqli_query($mysqli, "SELECT * FROM beneficiary WHERE login_id=".$_SESSION['id']."");
?><option value="">Select</option>
            <?php while($row1 = mysqli_fetch_array($result1)):;?>

            <option value="<?php echo $row1[0];?>"><?php echo $row1[1]; echo " - " ; echo $row1[3];?></option>

            <?php endwhile;?>

        </select>  </td><td><a class="aded mbl" href="add-benficiary.php">Add New Beneficiary</a></td>
			</tr>
            <!--<tr> 
				<td>Beneficiary Platform Account # </td>
				<td><input type="text" name="bpn" required></td>
			</tr>-->
			<tr> 
				<td>Amount</td>
				<td><input type="number" name="amount" required></td>
			</tr>
            <tr> 
				<td>Currency</td>
				<td><select name="currency">  
                <option value="">Select</option>
                <option value="£">GBP</option>
                <option value="$">USD</option>
                <option value="€">EURO</option>
               
                
                </select></td>
			</tr>
			<tr> 
				<td>Transaction Reference</td>
				<td><input type="text" name="purpose" required></td>
			</tr>
			<tr> 
            <!--<tr> 
				<td>Reference</td>
				<td><input type="text" name="ref"></td>
			</tr>-->
			<tr> 
				<td></td>
				<td><input class="aded" type="submit" name="Submit" value="Request Transfer"></td>
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

