<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>
<?php 


?>
<br>
<br>
<div class="form-group">
<label>Email:
</label>
<input type="text" name='username' id="username" class="form-control" value='<?php echo $my_username ; ?>' maxlength="80" readonly>
</div>
<div class="form-group">
<label> Display Name
</label>
<input type="text" name='name' id="name" class="form-control" value='<?php echo $my_name ; ?>' maxlength="80">
</div>
<div class="form-group">
<label >Whatsapp:
</label>
<input type="text" name='whatsapp' id="whatsapp" class="form-control" value ='<?php echo $my_whatsapp ; ?>' >
</div>
<div class="form-group">
<label >Payment Gateway (example: OVO 08974847484 , paypal: paypalku@gmail.com, dogecoin: D5wt9Vv1S93pfJNx993bT5iKQrqf54eZPh ) :
</label>
<textarea name='paypal' id="paypal" class="form-control" rows="5">
<?php echo $my_paypal ; ?>
</textarea>
</div>
<div class="form-group">
<label >Profile Description :
</label>
<textarea name='description' id="description" class="form-control" placeholder='write your text' size="500" rows='5' ><?php echo $my_description;?></textarea>
</div>
<div class="form-group">
<label >Secret Code (asked to admin via whatsapp) :
</label>
<input type="text"  id="pin" class="form-control" >
</div>
<br>
<br>
<button name = 'submit' id="submit" class="btn btn-primary">update profile
</button>
<br>
<br>
<br>
<script>

$(document).ready(function() {





$('#submit').click(function(){

var username = $("#username").val();
var name = $("#name").val();
var paypal = $("#paypal").val();
var whatsapp = $("#whatsapp").val();
var description = $("#description").val();
var picture = $("#picture").val();
var pin = $("#pin").val();


$.post("processor.php",

    {

		page: "profil",
     username:username,
     name:name,
     paypal:paypal,
     whatsapp:whatsapp,
     description:description,
     picture:picture,
     pin:pin,

		

	      

    },

    function(data,status){

		alert(data);

		});





});

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


	 

	 });

</script>