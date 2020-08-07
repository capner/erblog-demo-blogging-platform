<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
if(!isset($_COOKIE['account_u'])){
echo 'you need to login first';
die;
}
?>

<?php
$deposit_u = md5(base64_encode($fulltime.$my_username));
$action = mysql_real_escape_string($_GET['action']);
if (isset($_GET['action'])) {
if ($action == 'new') {
$deposit_author = $my_u;
$account_name = $my_name ;
$deposit_type = 'deposit';
$deposit_date = '';
$deposit_paypal = $my_paypal ;
$deposit_ammount = '5';
$deposit_status = 'pending';
$action = 'new';	
}
if ($action == 'edit') {
$deposit_u = mysql_real_escape_string($_GET['u']);
$query=mysql_query("select * from deposit where u = '$deposit_u' ");
while ($row= mysql_fetch_array($query)) {
$deposit_type = htmlspecialchars($row['type']);
$deposit_date = htmlspecialchars($row['date']);
$deposit_ammount = htmlspecialchars($row['ammount']);
$deposit_author = htmlspecialchars($row['author']);
$deposit_note = htmlspecialchars($row['note']);
$deposit_status = htmlspecialchars($row['status']);
$deposit_u = htmlspecialchars($row['u']);

$query = mysql_query("SELECT * FROM account where u = '$deposit_author' ");
while($row = mysql_fetch_assoc($query)){ 
$account_name = htmlspecialchars($row['name']);
$account_u = htmlspecialchars($row['u']);
$account_ballance = htmlspecialchars($row['ballance']);
$account_paypal = htmlspecialchars($row['paypal']);
}
$action = 'edit';	
}
if ($deposit_author !== $my_u && $my_role !== 'admin' ){
echo 'this is not your post';
die;	
}
}
}
?>

<input type ='hidden' id="u" value='<?php echo $deposit_u; ?>' readonly> 
<input type ='hidden' id="author" value='<?php echo $deposit_author; ?>' readonly> 

<br>
<div class="form-group">
<label>User :
</label>
<input type="text" id='account_name' class="form-control" value='<?php echo $account_name ; ?>' maxlength="80" readonly>
</div>
<div class="form-group">
<label>Type :
</label>
<select id = "type" class="form-control">
<option value="<?php echo $deposit_type; ?>"><?php echo $deposit_type; ?></option>
<option value="deposit">deposit</option>
<option value="withdraw">withdraw</option>
</select>
</div>
<div class="form-group">
<label>Date :
</label>
<input type="date" id='date' class="form-control" value='<?php echo $deposit_date; ?>' maxlength="80">
</div>
<div class="form-group">
<label>Ammount:
</label>
<input type="number" id='ammount' class="form-control" value='<?php echo $deposit_ammount ; ?>' maxlength="80">
</div>
<div class="form-group">
<label >Payment Gateway :
</label>
<textarea name='paypal' id="paypal" class="form-control" rows="5" readonly>
<?php echo $deposit_paypal ; ?>
</textarea>
</div>
<div class="form-group">
<label>Note :
</label>
<input type="text" id='note' class="form-control" value='<?php echo $deposit_note; ?>'  >
</div>
<div class="form-group">
<label>Status :
</label>
<select id = "status" class="form-control">
<option value="<?php echo $deposit_status; ?>"><?php echo $deposit_status; ?></option>
<?php
if ($my_role == 'admin'){
?>
<option value="approved">approved</option>
<option value="rejected">rejected</option>
<?php
}
?>
</select>
</div>
<button id = 'btn-deposit-editor' class="btn btn-primary">Save
</button>
<br>
<br>
<br>
<br>
<br>
<a href="/index.php?page=deposit" target="blank"><button name = "submit" class="btn btn-success" >Lihat Deposit</button></a>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<b>How To Deposit</b>
<br>
Please send fund to payment method bellow, and write note. what 
payment method were you used and account id such as paypal
email, doge wallet etc.
<br>
<br>
<li>BCA 1040341524 An. Eri Nurdiyanto (kcp Muntilan)</li>
<li>OVO 089673300464</li>
<li>Dogecoin D5wt9Vv1S93pfJNx993bT5iKQrqf54eZPh </li>
<li>Paypal capneronline@gmail.com </li>
<br>
<br>
<br>
<br>
<br>
<b>How To Withdraw</b>
<br>
Please fill the note what payment method method you want in the
form above.

<br>
<br>
<script>
$(document).ready(function(event) {
$('#btn-deposit-editor').click(function(event){
var u = $("#u").val();
var author = $("#author").val();
var type = $("#type").val();
var date = $("#date").val();
var ammount = $("#ammount").val();
var status = $("#status").val();	
var note = $("#note").val();


$.post("processor.php",
    {
		page: "deposit-editor",
		u: u ,
 author:author,
		type:type,
		date:date,
		ammount:ammount,
		note:note,
		status:status,
    },
    function(data,status){
    
		alert(data);
		});
	
});





	 });
</script>
