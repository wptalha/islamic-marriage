<?php
/*
// mysql_connect("database-host", "username", "password")
$conn = mysql_connect("localhost","root","root") 
			or die("cannot connected");

// mysql_select_db("database-name", "connection-link-identifier")
@mysql_select_db("test2",$conn);
*/

/**
 * mysql_connect is deprecated
 * using mysqli_connect instead
 */

$databaseHost = 'wordpressdb-c.hosting.stackcp.net';
$databaseName = 'SCWORDPRESS-3238b8f7';
$databaseUsername = 'SCWORDPRESS-3238b8f7';
$databasePassword = '4f3cb060323a12d4d286efa5bc7d9d08';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
	
?>