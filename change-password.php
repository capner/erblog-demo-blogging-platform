

<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>
<?php 

if(isset($_POST['submit'])) {
$new_name = mysql_real_escape_string($_POST['new_name']);
$old_pass =  mysql_real_escape_string (md5(md5(base64_encode($_POST['old_pass']))));
$new_pass =  mysql_real_escape_string (md5(md5(base64_encode($_POST['new_pass']))));
$new_pass1 = mysql_real_escape_string (md5(md5(base64_encode($_POST['new_pass1']))));
$paypal = mysql_real_escape_string($_POST['paypal']);
$whatsapp = mysql_real_escape_string($_POST['whatsapp']);
$description = mysql_real_escape_string($_POST['description']);

if (!empty($_POST['old_pass'])) {
if ($old_pass <> $password) {
echo "wrong old password" ;
} else if ($new_pass <> $new_pass1) {
echo '<script>alert("password didnt match, saved new profil failed ");</script>';
} else {
$query=mysql_query("update account set password = '$new_pass' where username ='$my_username' ");
$query=mysql_query("update account set paypal = '$paypal' where username ='$my_username' ");
echo '<script>alert("new profil saved succesfully");</script>';
}
}
$query=mysql_query("update account set name = '$new_name' where username ='$my_username' ");
$query=mysql_query("update account set paypal = '$paypal' where username ='$my_username' ");
$query=mysql_query("update account set whatsapp = '$whatsapp' , description = '$description' where username ='$my_username' ");
$query=mysql_query("select * from account where u = '$my_u' ");
while($row=mysql_fetch_array($query)){
$my_username= htmlspecialchars($row['username']);	
$my_role = htmlspecialchars($row['role']);	
$my_password= htmlspecialchars($row['password']);
$my_name = htmlspecialchars($row['name']);
$my_u = htmlspecialchars($row['u']);
$my_paypal = htmlspecialchars($row['paypal']);

$my_picture = htmlspecialchars($row['picture']);
	
}
echo '<script>alert("new profil saved succesfully");</script>';

}
?>

<div class="form-group">
<label>Your Email:
</label>
<input type="text" id="username" class="form-control" value='<?php echo $my_username ; ?>' maxlength="80" >
</div>
<br>
<div class="form-group">
<label>New Password:
</label>
<input type="password"  id="password1" class="form-control" value=''>
</div>
<div class="form-group">
<label >Repeat New Password:
</label>
<input type="password"  id="password2" class="form-control" value ='' >
</div>
<div class="form-group">
<label >Kode Rahasia (minta kepada admin dan kode akan dikirim via email
</label>
<input type="text" id="pin" class="form-control" value ='' >
</div>
<button id="submit" class="btn btn-primary">submit
</button>
<br>
<br>
<br>

<script>

$(document).ready(function() {

$('#mintakode').click(function(){

var to = $("#username").val();



$.post("processor.php",

    {

		page: "mail",
     to:to,
     

		

	      

    },

    function(data,status){

		alert(data);

		});





});







$('#submit').click(function(){
var username = $("#username").val();
var password1 = $("#password1").val();
var password2 = $("#password2").val();
var pin = $("#pin").val();


$.post("processor.php",

    {

		page: "reset-password",
		    username:username,
     password1:password1,
     password2:password2,
     pin:pin,

		

	      

    },

    function(data,status){

		alert(data);

		});

	




});



	 

	 });

</script>