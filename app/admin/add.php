<html>
<head>
    <title>Add Data</title>
</head>
 
<body>
<?php
//including the database connection file
include_once("connection.php");
 
if(isset($_POST['Submit'])) {    
    $lname = $_POST['cname'];
    $lage = $_POST['cage'];
    $lemail = $_POST['cemail'];
        
    
        // if all the fields are filled (not empty)             
        //insert data to database
        $result = mysqli_query($mysqli, "INSERT INTO users(name,age,email) VALUES('$lname','$lage','$lemail')");
        
        //display success message
        echo "<font color='green'>Data added successfully.";
        
    
}
?>
</body>
</html>