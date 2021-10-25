<?php
// including the database connection file
include_once("connection.php");

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	
	$name = $_POST['name'];
	$accnum = $_POST['accnum'];
	$country = $_POST['country'];
	$bank = $_POST['bank'];
	
	// checking empty fields
	if(empty($name) || empty($accnum) || empty($country) || empty($bank)) {
				
		if(empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if(empty($qty)) {
			echo "<font color='red'>Account number field is empty.</font><br/>";
		}
		
		if(empty($price)) {
			echo "<font color='red'>Country field is empty.</font><br/>";
		}
		if(empty($qty)) {
			echo "<font color='red'>Bank number field is empty.</font><br/>";
		}
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 	
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE beneficiary SET name='$name', accnum='$accnum', country='$country', bank='$bank' WHERE id=$id");
		
		//redirectig to the display page. In our case, it is view.php
		header("Location: view-beneficiary.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM beneficiary WHERE id=$id");

while($res = mysqli_fetch_array($result))
{
	
	
	$name = $res['name'];
	$accnum = $res['accnum'];
	$country = $res['country'];
	$bank = $res['bank'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Beneficiary</title>
<link href="style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="main">
<div class="mainwrp">

<?php
include("head.php");	
?>

<div class="mainin">
		<div class="lft"> <a href="view-transaction.php">View All Transaction</a><br> <br>
        <a href="add-transaction.php">Request New Transfer</a><br><br>
        <a href="add-benficiary.php">Add New Beneficiary</a><br><br>
        <a href="view-beneficiary.php">View All Beneficiary</a><br><br>
        </div>
        <div class="rgt">  
        <h1>Edit Beneficiary</h1>
	
	<form name="form1" method="post" action="edit-benficiary.php">
		<table border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name" value="<?php echo $name;?>" required></td>
			</tr>
			<tr> 
				<td>Account number</td>
				<td><input type="text" name="accnum" value="<?php echo $accnum;?>" required></td>
			</tr>
			<tr> 
				<td>Country</td>
				<td><input type="text" name="country" value="<?php echo $country;?>" required></td>
			</tr>
            <tr> 
				<td>Bank</td>
				<td><input type="text" name="bank" value="<?php echo $bank;?>" required></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input class="aded" type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</div> 

<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>
