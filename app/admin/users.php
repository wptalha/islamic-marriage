<?php session_start(); ?>
<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>
<?php
//including the database connection file
include_once("connection.php");

//fetching data in descending order (lastest entry first)

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View users</title>
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
    
    <div style="width:100%" id="rgt" class="rgt">
      <div class="hide-from-page" style=""> 
      
      <div style="float:left; width:40%;"><img width="150" height="auto" alt="HK Investments" src="hk-logo.png" ><br /></div>
      <div style="float:right; width:60%; text-align:right; font-size:13px;">  </div>
      </div>
      <table width='100%' border=0>
        <tr class="hdr" >
          <td>Name</td>
           <td>Comp. name</td>
          <td>Cont. name</td>
          <td>Phone</td>
          <td>Address</td>
           <td>Country</td>
          <td>City</td>
         <td>Cust. Platform #</td>
           <td>User</td>
           <!--<td>Balance</td>-->
        </tr>
        <?php 
		
		


		
		$result = mysqli_query($mysqli, "SELECT * from login ORDER BY id DESC");
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['lname']."</td>";
			echo "<td>".$res['cname']."</td>";
			echo "<td>".$res['conname']."</td>";
			echo "<td>".$res['phone']."</td>";
			echo "<td>".$res['address']."</td>";	
			echo "<td>".$res['country']."</td>";
			echo "<td>".$res['city']."</td>";	
			echo "<td>".$res['cpan']."</td>";
			echo "<td>".$res['username']."</td>";
			//echo "<td>".$res['bal']."</td>";				
			echo "<td class='mbl'><a href=\"edit-user.php?id=$res[id]\">Edit</a> | <a href=\"delete-user.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";	
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
