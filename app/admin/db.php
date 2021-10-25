<?php
$connection = mysqli_connect('localhost', 'myweb_expres', 'rm{fR^lXs2mP');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'myweb_express');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}