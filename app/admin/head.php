<div class="hd">

<div class="lgo">
<img width="150" height="auto" alt="HK Investments" src="hk-logo.png" >
</div> 

<div class="usrss" style="text-align:right;">


 <?php $result = mysqli_query($mysqli, "SELECT lname,address,city,country FROM login WHERE id=".$_SESSION['id']." ORDER BY id DESC");
		while($res = mysqli_fetch_array($result)) {		
			
			
			echo "Admin - ".$res['lname']."";
			
			
			
		} ?>

<a style="text-decoration:none; color:#FF0000; font-weight:600;" href='logout.php'>Logout</a><br /><br />
</div>

</div>

<div style="text-align: center;float: left;width: 100%;" class="mainhdl">

<div class="thirt" style=" padding-left:20px; padding-right:20px;" > <?php echo date('l jS F, Y '); ?></div>

<div class="thirt act" > <a href="users.php">Manage User</a></div>
<div class="thirt vact"> <a href="view-transaction.php">View Transfer Request </a></div>
<div class="thirt vact"> <a href="add-transaction.php">Debit / Credit Account </a></div>


</div>