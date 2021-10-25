<?php session_start(); 

	if(isset($_SESSION['valid'])) {			
		include("connection.php");					
		$result = mysqli_query($mysqli, "SELECT * FROM login");
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>HK Payment Solutions Internet Banking</title>
	<link href="style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="main">
<div class="mainwrp">
<?php
include("head.php");	
?>

<div class="mainin">
		
        <div style="width:100%" class="rgt">  
        
        
        <h1>Latest Transfer</h1>
        
        	<table width='100%' border=0>
        <tr class="hdr" >
          <td>Account Name</td>
           <td>Account Number</td>
          <td>Beneficiary Platform Account #</td>
          <td>Amount</td>
          <td>Currency</td>
           <td>Transaction Ref.</td>
          <td>Reference</td>
           <td>Status</td>
           <td>User</td>
        </tr>
        <?php 
		
		


		
		$result = mysqli_query($mysqli, "SELECT beneficiary.name,  beneficiary.accnum, beneficiary.pan ,transfer.id, transfer.amount, transfer.currency ,transfer.purpose,transfer.ref,transfer.status,login.lname FROM transfer JOIN beneficiary ON beneficiary.id = transfer.benid  JOIN login ON transfer.login_id=login.id");
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['accnum']."</td>";
			echo "<td>".$res['pan']."</td>";
			echo "<td>".$res['amount']."</td>";
			echo "<td>".$res['currency']."</td>";	
			echo "<td>".$res['purpose']."</td>";
			echo "<td>".$res['ref']."</td>";	
			echo "<td>".$res['status']."</td>";	
			echo "<td>".$res['lname']."</td>";
			
			echo "<td class='mbl'><a href=\"transfer-details.php?id=$res[id]\">Details</a> <a href=\"edit-transaction.php?id=$res[id]\">Edit</a> <a href=\"delete-transaction.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";	
			echo "</tr>";	
		}
		
		
		
		?>
      </table>
		<br><br>
		 <a class="aded" href='view-transaction.php'>View All Transfer</a> 
		<br/><br/>
	<?php	
	} else {
		header('Location: login.php');		
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
