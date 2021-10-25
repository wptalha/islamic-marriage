<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
// including the database connection file
include_once("connection.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transaction Details</title>
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
        <?php
//getting id from url
$id = $_GET['id'];// echo "$id";	
//$result = mysqli_query($mysqli, "SELECT * from transfer  WHERE id=$id");
//selecting data associated with this particular id
//$result = mysqli_query($mysqli, "SELECT * FROM transfer WHERE id=$id");

            ?>
            
            <h2>Beneficiary Details</h2>
		
        <?php 
		
		


		
		$result = mysqli_query($mysqli, "SELECT beneficiary.name,  beneficiary.accnum, beneficiary.pan ,beneficiary.sc ,beneficiary.iban ,beneficiary.country ,beneficiary.bank ,beneficiary.badd ,transfer.amount, transfer.currency ,transfer.purpose,transfer.ref,transfer.status FROM transfer JOIN beneficiary ON transfer.benid = beneficiary.id WHERE transfer.id=$id ");
		while($res = mysqli_fetch_array($result)) {		
			
			$name = $res['name'];	
			$accnum = $res['accnum'];	
			$pan = $res['pan'];	
				$sc = $res['sc'];
					$iban = $res['iban'];
						$country = $res['country'];
							$bank = $res['bank'];
								$badd = $res['badd'];
			$amount = $res['amount'];	
			$currency = $res['currency'];	
			$purpose = $res['purpose'];	
			$ref = $res['ref'];	
			$status = $res['status'];	
			//$ref = $res['ref'];	
		}
		
		
		
		?>
 
			<table width="25%" border="0">
			<tr> 
				<td>Beneficiary Name</td>
				<td><?php echo $name;?></td>
			</tr>
            
			<tr> 
				<td>Beneficiary Account number</td>
				<td><?php echo $accnum;?></td>
			</tr>
            
            <tr> 
				<td>Beneficiary Platform Account Number</td>
				<td><?php echo $pan;?></td>
			</tr>
            
            
            <tr> 
				<td>Swift Code</td>
				<td><?php echo $sc;?></td>
			</tr>
            <tr> 
				<td>IBAN No</td>
				<td><?php echo $iban;?></td>
			</tr>
			<tr> 
				<td>Beneficiary Country</td>
				<td><?php echo $country;?></td>
			</tr>
            <tr> 
				<td>Beneficiary Bank Name</td>
				<td><?php echo $bank;?></td>
			</tr>
            <tr> 
				<td>Beneficiary Bank Address</td>
				<td><?php echo $badd;?></td>
			</tr>
             <tr> 
				<td>Amount</td>
				<td><?php echo $amount;?></td>
			</tr>
             <tr> 
				<td>Currency</td>
				<td><?php echo $currency;?></td>
			</tr>
              <tr> 
				<td>Transaction Reference</td>
				<td><?php echo $purpose;?></td>
			</tr>
             <tr> 
				<td>Reference</td>
				<td><?php echo $ref;?></td>
			</tr>
              <tr> 
				<td>Status</td>
				<td><?php echo $status;?></td>
			</tr>
			<tr> <td><a class="aded" href="view-transaction.php"> << Back </a></td>
				<td></td>
				
			</tr>
		</table>
</div> 
<?php
include("footer.php");	
?>
</div><!--mainwrp-->
</body>
</html>
