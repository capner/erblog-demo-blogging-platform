<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>
<br>
<br>
<?php 

if ($my_role !== 'admin' ){
echo 'restricted area';
exit;	
}

if (isset($_GET['u'])){
$member_u =  mysql_real_escape_string($_GET['u']);

$query = mysql_query("select * from account where u = '$member_u' ");
$cek_hasil = mysql_num_rows($query);
if ($cek_hasil == 0 ){
echo 'data not found';
die;	
}
while($row = mysql_fetch_assoc($query)){ 
$member_username = htmlspecialchars($row['username']);
$member_name = htmlspecialchars($row['name']);
$member_paypal = htmlspecialchars($row['paypal']);
$member_ballance = htmlspecialchars($row['ballance']);
$member_status = htmlspecialchars($row['status']);
$member_pin = buka(htmlspecialchars($row['pin']));
}
}

?>
<div class="form-group">
<label>account u:
</label>
<input type="text" name='u' id="u" class="form-control" value='<?php echo $member_u ; ?>' maxlength="80" readonly>
</div>
<div class="form-group">
<label>email:
</label>
<input type="text" name='username'  id="username" class="form-control" value='<?php echo $member_username ; ?>' maxlength="80" readonly >
</div>
<div class="form-group">
<label>name:
</label>
<input type="text" name='name' id="name" class="form-control" value='<?php echo $member_name ; ?>' maxlength="80" readonly>
</div>
<div class="form-group">
<label >Payment Gateway :
</label>
<textarea name='paypal' id="paypal" class="form-control" rows="5" readonly>
<?php echo $member_paypal ; ?>
</textarea>
</div>
<div class="form-group">
<label >Ballance:
</label>
<input type="text" name='ballance'  id="ballance" class="form-control" value ='<?php echo $member_ballance ; ?>' >
</div>
<div class="form-group">
<label >Kode Rahasia:
</label>
<input type="text" id="pin" class="form-control" value ='<?php echo $member_pin ; ?>' >
</div>
<div class="form-group">
<label>Status:
</label>
<select name = "status" id="status" class="form-control">
<option value="<?php echo $member_status;?>"><?php echo $member_status;?></option>
<option value="active">active</option>
<option value="disabled">disabled</option>
<option value="banned">banned</option>
</select>
</div>
<button name = "submit" id="submit"  class="btn btn-primary">update profile
</button>
<br>
<br>
<br>
<?php
echo md5(rand(1000,9999));
?>
<br>
<br>
<br>
<script>

$(document).ready(function() {

$('#submit').click(function(){

var u = $("#u").val();

var ballance = $("#ballance").val();
var status = $("#status").val();
var pin = $("#pin").val();


$.post("processor.php",

    {

		page: "admin-editor",

		u: u ,

		ballance:ballance,
		status:status,
	 pin:pin,
		

	      

    },

    function(data,status){

		alert("Data: " + data + "\nStatus: " + status);

		});

	

	

	event.preventDefault();



});



	 

	 });

</script>

