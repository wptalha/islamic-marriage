<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Beneficiary</title>
<link href="style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="main">
<div class="mainwrp">

<?php
include("head.php");	
?>

<div class="mainin">
		
        <div style="width:100%;" class="rgt">  
       
	
	<table width="100%" border=0>
		<tr class="hdr" bgcolor='#5F5F5F'>
			<td>Name</td>
            <td>Platform Account #</td>
           	<td>Account Number</td>
            <td>Swift Ccode</td>
            <td>IBAN No</td>
			<td>Country</td>
			<td>Bank Name</td>
            <td>Bank Add</td>
		</tr>
		<?php $result = mysqli_query($mysqli, "SELECT * FROM beneficiary WHERE login_id=".$_SESSION['id']." ORDER BY id DESC");
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['pan']."</td>";
			echo "<td>".$res['accnum']."</td>";
			echo "<td>".$res['sc']."</td>";
			echo "<td>".$res['iban']."</td>";
			echo "<td>".$res['country']."</td>";	
			echo "<td>".$res['bank']."</td>";
			echo "<td>".$res['badd']."</td>";
			//echo "<td class='mbl'><a href=\"edit-benficiary.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
		}
		?>
	</table>	
</div> 
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>
