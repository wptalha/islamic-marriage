<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include("connection.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$result=mysqli_query($mysqli, "DELETE FROM transfer WHERE id=$id");

//redirecting to the display page (view.php in our case)
//header("Location:view-transaction.php");
echo "<script language='javascript' type='text/javascript'> location.href='view-transaction.php' </script>";
?>

