<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
// including the database connection file
include_once("connection.php");

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	
	
	$ref = $_POST['ref'];	
	$status = $_POST['status'];	
	
	
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE transfer SET ref='$ref' , status='$status'  WHERE id=$id");
		
		//redirectig to the display page. In our case, it is view.php
  echo "<script language='javascript' type='text/javascript'> location.href='view-transaction.php' </script>";
		//header("Location: view-transaction.php");
	
}
?>
<?php
//getting id from url
$id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * from transfer  WHERE id=$id");
//selecting data associated with this particular id
//$result = mysqli_query($mysqli, "SELECT * FROM transfer WHERE id=$id");

while($res = mysqli_fetch_array($result))
{
	
	$ref = $res['ref'];	
	$status = $res['status'];	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Transaction</title>
<link href="style.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="main">
<div class="mainwrp">

<?php
include("head.php");	
?>

<div class="mainin">
		<div class="lft"> 
        </div>
        <div class="rgt">  
	<h1>Edit Transfer</h1>
	<form name="form1" method="post" action="edit-transaction.php">
		<table border="0">
		
            <tr> 
				<td>Reference</td>
				<td><input type="text" name="ref" value="<?php echo $ref;?>" required></td>
			</tr>
            <tr> 
				<td>Status</td>
				<td>
                
                
                <select name="status" required>  
                <option value="<?php echo $status;?>" ><?php echo $status;?></option>
                <option value="Approved">Approved</option>
                <option value="Declined">Declined</option>
                <option value="Processing">Processing</option>
                
                
                </select>
                
                
                
                </td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
                </td>
				<td><input class="aded" type="submit" name="update" value="Update"><br /><br /> <a href="view-transaction.php"><< Go Back</a><br /><br /></td>
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
