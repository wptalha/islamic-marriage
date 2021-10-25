<?php session_start(); include_once("connection.php");

if(!isset($_SESSION['valid'])) {
	echo "<script language='javascript' type='text/javascript'> location.href='login.php' </script>";
}
?>
<div class="hd">

<div class="lgo">
<img width="150" height="auto" alt="HK Investments" src="hk-logo.png" >
</div> 

<div class="usrss" style="text-align:right;">


 <?php $result = mysqli_query($mysqli, "SELECT * FROM login WHERE id=".$_SESSION['id']." ORDER BY id DESC");
		while($res = mysqli_fetch_array($result)) {		
			
			
			echo "<b>Company name:</b> ".$res['cname']."<br />";
			echo "<b>Contact name:</b> ".$res['conname']."<br />";
			echo "<b>Address:</b> ".$res['address'].",". $res['city'].",".$res['country']."<br />";
			//echo "".$res['city']."<br />";
			//echo "".$res['country']."<br />";
			echo "<b>Customer Platform Account No:</b> ".$res['cpan']."<br />";
			
			
		} ?>

<a style="text-decoration:none; color:#FF0000; font-weight:600;" href='logout.php'>Logout</a><br /><br />
</div>

</div>

<div style="text-align: center;float: left;width: 100%;" class="mainhdl">

<div class="thirt" style=" padding-left:20px; padding-right:20px;" > <?php echo date('l jS F, Y '); ?></div>

<div class="thirt act" > <a href="add-transaction.php">Request  New Transfer</a></div>
<div class="thirt vact"> <a href="view-transaction.php">Account Transaction </a></div>
<div class="thirt vact"> <a href="view-balance.php">View Balance</a></div>

		
		


     

<div class="thirt vact" style="float: right;padding-right: 50px;">Balance: $<?php $result = mysqli_query($mysqli, "Select sum(cr) - sum(dr) as tcr from transfer WHERE currency='$' AND login_id=".$_SESSION['id']." ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['tcr']."";	
			
			
		}

 ?>, &pound;<?php $result = mysqli_query($mysqli, "Select sum(cr) - sum(dr) as tcr from transfer WHERE currency='£' AND login_id=".$_SESSION['id']." ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['tcr']."";	
			
			
		}

 ?>, &euro;<?php $result = mysqli_query($mysqli, "Select sum(cr) - sum(dr) as tcr from transfer WHERE currency='€' AND login_id=".$_SESSION['id']." ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['tcr']."";	
			
			
		}

 ?></div>


</div>