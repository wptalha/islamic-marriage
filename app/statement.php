<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Transaction</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="print.css" rel="stylesheet" type="text/css" media="print">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="main">
<div class="mainwrp">
<?php
include("head.php");	
?>
<?php

if(isset($_POST['Submit'])) {	
  
	
	
	$currency = $_POST['currency'];
	

	
	
}
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
    
    <div style="width:100%" id="rgt" class="rgt">
      <div class="hide-from-page" style=""> 
      
      <div style="float:left; width:100%;"><img width="200" height="auto" alt="HK Investments" src="hk-logo.png" ><br /></div>
      <div style="float:left; width:100%; padding: 20px 0; font-size:13px;"> <?php $result = mysqli_query($mysqli, "SELECT * FROM login WHERE id=".$_SESSION['id']." ORDER BY id DESC");
		while($res = mysqli_fetch_array($result)) {		
			
			
			echo "Company Name: ".$res['cname']."<br />";
			echo "Contact Name: ".$res['conname']."<br />";
			echo "Address: ".$res['address'].", ";
			echo "".$res['city']." ,";
			echo "".$res['country']."<br />";
			echo "Customer Platform Account No.: ".$res['cpan']."<br />";
			//echo "Opening Balance: ".$res['cpan']."<br />";
			
			
		} ?>
        Opening Balance:  <?php echo $currency ?><?php $result = mysqli_query($mysqli, "Select cr from transfer WHERE currency='$currency' AND benid='0' AND login_id=".$_SESSION['id']." order by id asc Limit 1 ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['cr']."<br>";	
			
			
		}

 ?>
        
       Closing Balance: <?php echo $currency ?><?php $result = mysqli_query($mysqli, "Select sum(cr) - sum(dr) as tcr from transfer WHERE currency='$currency' AND benid='0' AND login_id=".$_SESSION['id']." ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['tcr']."";	
			
			
		}

 ?>
        </div>
      </div>
      <table width='100%' border=0>
        <tr class="hdr" >
         <!-- <td>SI</td>-->
           <td>Trans. Date</td>
            <td>Reference</td>
          <td>Description</td>          
         
          <td>Debit</td>
          <td>Credit</td>     
          <td>Balance</td>           
           
        </tr>
        <?php 
		
		


		
		//$result = mysqli_query($mysqli, "SELECT * from transfer WHERE login_id=".$_SESSION['id']."");
		$result = mysqli_query($mysqli, "SELECT 
    t.dte, t.descrip,t.ref,t.dr, t.cr,t.currency,
    @b := @b + t.cr - t.dr AS balance
FROM
    (SELECT @b := 0) AS dummy 
CROSS JOIN
    transfer AS t
WHERE currency='$currency' AND benid='0' AND login_id=".$_SESSION['id']."
ORDER BY
    id ASC");
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			//echo "<td>id</td>";
			echo "<td>".$res['dte']."</td>";
			echo "<td>".$res['ref']."</td>";
			echo "<td>".$res['descrip']."</td>";
			
			//echo "<td>".$res['currency']."</td>";	
			//echo "<td>".$res['purpose']."</td>";
			//echo "<td>".$res['ref']."</td>";	
			echo "<td>".$res['currency'].$res['dr']."</td>";	
			echo "<td>".$res['currency'].$res['cr']."</td>";	
			echo "<td>".$res['currency'].$res['balance']."</td>";	
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
</div>
<!--mainwrp-->
</body>
</html>
