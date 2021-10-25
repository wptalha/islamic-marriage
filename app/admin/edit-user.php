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
	$lname = $_POST['lname'];
	$cname = $_POST['cname'];
	$conname = $_POST['conname'];	
	$phone = $_POST['phone'];	
	$cpan = $_POST['cpan'];	
	$address = $_POST['address'];	
	$country = $_POST['country'];	
	$city = $_POST['city'];		
	$email = $_POST['email'];	
	$username = $_POST['username'];	
	$cpan = $_POST['cpan'];	
	//$bal = $_POST['bal'];	
	$password = $_POST['password'];	
	
	if(empty($lname) || empty($cname) || empty($conname) || empty($phone) || empty($address)) {
				
		
	} else {	
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE login SET lname='$lname', cname='$cname', conname='$conname', phone='$phone', cpan='$cpan', address='$address', country='$country', city='$city', email='$email', username='$username'  ,password='$password' WHERE id=$id");
		
		//redirectig to the display page. In our case, it is view.php
		//header("Location: users.php");
      echo "<script language='javascript' type='text/javascript'> location.href='users.php' </script>";
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM login WHERE id=$id");

while($res = mysqli_fetch_array($result))
{
	$lname = $res['lname'];
	$cname = $res['cname'];
	$conname = $res['conname'];	
	$phone = $res['phone'];	
	$cpan = $res['cpan'];	
	$address = $res['address'];	
	$country = $res['country'];	
	$city = $res['city'];		
	$email = $res['email'];	
	$username = $res['username'];	
	//$bal = $res['bal'];	
	$password = $res['password'];	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit user</title>
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
	<form name="form1" method="post" action="edit-user.php">
		<table border="0">
			
			<tr> 
				<td>Name</td>
				<td><input type="text" name="lname" value="<?php echo $lname;?>" required></td>
			</tr>
			<tr> 
				<td>Company Name</td>
				<td><input type="text" name="cname" value="<?php echo $cname;?>" required></td>
			</tr>
            <tr> 
				<td>Contact Name</td>
				<td><input type="text" name="conname" value="<?php echo $conname;?>" required></td>
			</tr>
            <tr> 
				<td>Phone</td>
				<td><input type="text" name="phone" value="<?php echo $phone;?>" required></td>
			</tr>
            <tr> 
				<td>Address</td>
				<td><input type="text" name="address" value="<?php echo $address;?>" required></td>
			</tr>
            <tr> 
				<td>Country</td>
				<td><input type="text" name="country" value="<?php echo $country;?>" required>
                </td>
			</tr>
            <tr> 
				<td>City</td>
				<td><input type="text" name="city" value="<?php echo $city;?>" required></td>
			</tr>
            <tr> 
				<td>Email</td>
				<td><input type="text" name="email" value="<?php echo $email;?>" required></td>
			</tr>
            <tr> 
				<td>Username</td>
				<td><input type="text" name="username" value="<?php echo $username;?>" required></td>
			</tr>
            <tr> 
				<td>Password</td>
				<td><input type="text" name="password" value="<?php echo $password;?>" required></td>
			</tr>
            <tr> 
				<td>Customer Platform Account No</td>
				<td><input type="text" name="cpan" value="<?php echo $cpan;?>" ></td>
			</tr>
            <!--<tr> 
				<td>Balance</td>
				<td><input type="text" name="bal" value="<?php echo $bal;?>" required></td>
			</tr>-->
            
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
                </td>
				<td><input class="aded" type="submit" name="update" value="Update"><br /><br /> <a href="users.php"><< Go Back</a><br /><br /></td>
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
