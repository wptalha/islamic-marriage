<?php
session_start();
session_destroy();
session_unset(); 
//header("Location:main.php");
echo "<script language='javascript' type='text/javascript'> location.href='login.php' </script>";
?>
