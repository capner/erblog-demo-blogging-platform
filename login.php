<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>
<br>
<br>
<?php
if(isset($_COOKIE['account_u'])) {
header('location:index.php'); 
} ;

if (isset($_GET['ref'])){
$ref = mysql_real_escape_string($_GET['ref']);

} else {
$ref = $admin_u;
}
?>

<div class="col-md-12"> 
<h3>Login</h3>                                
<div class="form-group">			                          
</div>		 			                          
<div class="form-group">			                              
<label for="codename">Email:                              
</label>			                              
<input type="email" name='username' id="username" class="form-control" placeholder='' required >			                          
</div>			 			                          
<div class="form-group">			                              
<label for="secret">Password :                              
</label>			                              
<input type="password" name='password' id="password" class="form-control" placeholder='' required >			                          
</div>
<br>			                          
<br>			 			                          
<button id="login6464" class="btn btn-primary ">Login                           
</button>			                      
<br>
<br>
<br>
<a href="/index.php?page=changepassword">Forgot Password?</a>
<br>
<br>
<br>
<br>
<br>


<h3>Register</h3>                                 
<div class="form-group">			
 <input type="hidden" name='ref' id="ref" class="form-control" placeholder='' value="<?php echo $ref; ?>"  >			                          
                         
</div>			 			           
<div class="form-group">			                              
<label for="codename">Email:                              
</label>			                              
<input type="email" name='username' id="usernameR" class="form-control" placeholder='' required >			                          
</div>			 			                          
<div class="form-group">			                              
<label for="secret">Password :                              
</label>			                              
<input type="password" name='password' id="passwordR" class="form-control" placeholder='' required >			                          
</div>
<div class="form-group">			                              
<label for="secret">Repeat Password :                              
</label>			                              
<input type="password" name='password1' id="password1R" class="form-control" placeholder='' required >			                          
</div>	
<div class="form-group">			                              
<label for="secret">Display Name:                              
</label>			                              
<input type="text" name='name' id="nameR" class="form-control" placeholder='' required >			                          
</div>				 		 			                          
<br>			                          		 			                          
<button  id="mendaftar" class="btn btn-primary ">Register                          
</button>			                      		 			 			                     		            <br>
<br>
By registering you are agree to  <a href="index.php?page=about">Terms Of Service</a>
<br>
</div>


<script>

$(document).ready(function() {


$('#mendaftar').click(function(event){

var ref = $("#ref").val();
var usernameR = $("#usernameR").val();
var passwordR = $("#passwordR").val();
var password1R = $("#password1R").val();
var nameR = $("#nameR").val();


$.post("processor.php",

    {

		page: "register",
     upline:ref,
     username:usernameR,
     password:passwordR,
     password1:password1R,
     name:nameR,
   

		

	      

    },

    function(data,status){

		alert(data);
    if (data == "login success"){
      window.location.replace("index.php");

      }

		});

	

	

	event.preventDefault();



});


$('#login6464').click(function(){

var username = $("#username").val();
var password = $("#password").val();


$.post("processor.php",

    {

		page: "login",
     username:username,
     password:password,

		

	      

    },

    function(data,status){

		alert(data);
    if (data == "login success"){
      window.location.replace("index.php");

      }

		});

	

	

	



});
	 

	 });



</script>