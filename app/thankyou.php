<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thank you</title>
<link href="style.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="hm login-page">
<div class="mainwrp"> <img src="hk-logo.png" ><br>
  <br>
  
  <p><font size="+2">Thank you</font></p>
  <p>We have received your application and we will send you a document request via email to complete your registration.</p>
  
  <?php
  include("connection.php");
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "admin@hkpaymentsolutions.com";
    $email_subject = "New Application";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 

    // validation expected data exists
    if(!isset($_POST['lname']) ||
        
        !isset($_POST['cname'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 
    $lname = $_POST['lname'];
	$cname = $_POST['cname'];
	$conname = $_POST['conname'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$email = $_POST['email'];
	$power = $_POST['power'];
 
    
 
    
 
 
 
  
 
 
  $email_message = "You have received new Application.\n";
  
 
    $email_message = "Application details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Full Name: ".clean_string($lname)."\n";
    $email_message .= "Company Name: ".clean_string($cname)."\n";
	 $email_message .= "Contact Name: ".clean_string($conname)."\n";
    $email_message .= "phone: ".clean_string($phone)."\n";
	$email_message .= "Email: ".clean_string($email)."\n";
	$email_message .= "address: ".clean_string($address)."\n";
    $email_message .= "city: ".clean_string($city)."\n";
	  $email_message .= "country: ".clean_string($country)."\n\n\nThis was sent from HK Payment Solutions";
	//$email_message = "This was sent from HK Payment Solutions.\n\n";
    
    
 
// create email headers
$headers = 'From: '.$email."\r\n".
'Reply-To: '.$email."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  

?>
<?php
 //mysqli_query($mysqli, "INSERT INTO login(lname, cname, conname, phone, address, country, city, email, power) VALUES('$lname', '$cname', '$conname', '$phone', '$address', '$country', '$city', '$email')")
 mysqli_query($mysqli, "INSERT INTO login(lname, cname, conname, phone, address, country, city, email, power) VALUES('$lname', '$cname', '$conname', '$phone', '$address', '$country', '$city', '$email' ,'$power' )")
			or die(".");
}
?>
</div>
</body>
</html>
