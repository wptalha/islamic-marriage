<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>HK Payment Solutions Internet Banking</title>
	<link href="style.css" rel="stylesheet" type="text/css">
    <link href="print.css" rel="stylesheet" type="text/css" media="print">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="main">
<div class="mainwrp">
<?php
include("head.php");	
?>
<script>
		function printDiv(rgt){
			var printContents = document.getElementById(rgt).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
	</script>
    <button style="float:right; background:#000000"  class="aded" onclick="printDiv('rgt')">Print Statement</button>
<div class="mainin">
<?php
include("nav.php");	
?>
<div id="rgt" class="rgt">  
        <div class="hide-from-page" style=""> 
      
      <div style="float:left; width:40%;"><img width="150" height="auto" alt="HK Investments" src="hk-logo.png" ><br /></div>
      <div style="float:right; width:60%; text-align:right; font-size:13px;"> <?php $result = mysqli_query($mysqli, "SELECT ((SELECT SUM(cr) FROM transfer) - (SELECT SUM(dr) FROM transfer)) AS theSum WHERE id=".$_SESSION['id']." ");
		while($res = mysqli_fetch_array($result)) {		
			//SELECT ((SELECT SUM(cr) FROM transfer) - (SELECT SUM(dr) FROM transfer)) AS theSum
			
			echo "".$res['theSum']."<br />";
			
			
			
		} ?></div>
      </div>
        
       <!-- <h2>Transfer Request</h2>-->
        
        	<?php $result1 = mysqli_query($mysqli, "SELECT * FROM transfer ORDER BY id DESC");


	?>
				<table width='100%' border=0>
        <tr class="hdr" >
          <td>Account Name</td>
           <td>Account Number</td>
          <td>Beneficiary Platform Account #</td>
          <td>Amount</td>
         
           <td>Transaction Ref.</td>
          <td>Reference</td>
           <td>Status</td>
        </tr>
        <?php 
		
		


		
		$result = mysqli_query($mysqli, "SELECT beneficiary.name,  beneficiary.accnum, beneficiary.pan ,transfer.id, transfer.amount, transfer.currency ,transfer.purpose,transfer.ref,transfer.status,login.lname FROM transfer JOIN beneficiary ON beneficiary.id = transfer.benid  JOIN login ON transfer.login_id=login.id WHERE login.id=".$_SESSION['id']."");
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['accnum']."</td>";
			echo "<td>".$res['pan']."</td>";
			echo "<td>".$res['currency'].$res['amount']."</td>";
			//echo "<td>".$res['currency']."</td>";	
			echo "<td>".$res['purpose']."</td>";
			echo "<td>".$res['ref']."</td>";	
			echo "<td>".$res['status']."</td>";	
			//echo "<td class='mbl'><a href=\"edit-transaction.php?id=$res[id]\">Edit</a> | <a href=\"delete-transaction.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";	
			echo "</tr>";
		}
		
		
		
		?>
      </table>
		
        
        </div>
        
</div> 
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>