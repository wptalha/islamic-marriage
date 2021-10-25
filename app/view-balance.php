<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Balance</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="print.css" rel="stylesheet" type="text/css" media="print">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
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
    <div style=" background:#5E5F5F; color:#fff; font-size:20px; line-height:30px; padding:30px 50px;  float:left; margin-right:20px;">
      
      $<?php $result = mysqli_query($mysqli, "Select sum(cr) - sum(dr) as tcr from transfer WHERE currency='$' AND login_id=".$_SESSION['id']." ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['tcr']."";	
			
			
		}

 ?></div>   <div style=" background:#5E5F5F; color:#fff; font-size:20px; line-height:30px; padding:30px 50px;  float:left; margin-right:20px;">&pound;<?php $result = mysqli_query($mysqli, "Select sum(cr) - sum(dr) as tcr from transfer WHERE currency='£' AND login_id=".$_SESSION['id']." ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['tcr']."";	
			
			
		}

 ?></div>  <div style=" background:#5E5F5F; color:#fff; font-size:20px; line-height:30px; padding:30px 50px;  float:left; margin-right:20px;">&euro;<?php $result = mysqli_query($mysqli, "Select sum(cr) - sum(dr) as tcr from transfer WHERE currency='€' AND login_id=".$_SESSION['id']." ");



while($res = mysqli_fetch_array($result)) {		
			
			
			
			//echo "<td>".$res['dr']."</td>";	
			//echo "<td>".$res['cr']."</td>";	
			echo "".$res['tcr']."";	
			
			
		}

 ?></div>
    </div>
  </div>
  <?php
include("footer.php");	
?>
</div>
<!--mainwrp-->
</body>
</html>
