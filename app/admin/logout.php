<?php
session_start();
session_destroy();
echo "<script language='javascript' type='text/javascript'> location.href='login.php' </script>";
//header("Location:main.php");
?>
