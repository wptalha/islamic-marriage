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
 
  <div class="mainin">
       <?php
include("nav.php");	
?>
    <div class="rgt">
      <div style="width:400px; margin:0 auto">
      <form action="statement.php" method="post" name="form1">
	<select name="currency" required>  
                <option value="">Select Currency</option>
                <option value="£">GBP</option>
                <option value="$">USD</option>
                <option value="€">EURO</option>
               
                
                </select>
				<input class="aded" type="submit" name="Submit" value="View Statement">
			
	</form>
    </div>
    </div>
  </div>
  <?php
include("footer.php");	
?>
</div>
<!--mainwrp-->
</body>
</html>
