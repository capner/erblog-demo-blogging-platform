<?php
session_start();

//echo $_SESSION['code'];

if(isset($_POST['submit'])){
$kode = htmlspecialchars($_POST['kode']);
if ($kode !== $_SESSION['code']){
echo 'wrong number, try again !! <br>';	
} else {
$_SESSION['refresh'] = 0 ;
$rand = md5(rand(1,99999999999));
setcookie('uid',$rand,time() + (864000000));
header("location:index.php");
}
} 




?>
<html>
<body>
<form action="" method="post">
<img src="gambar.php" alt="gambar" /> </td>
<br>
Input number
<br>
<input type="text" name="kode" maxlength="5"/>
<input id="submit" type ="submit" name="submit" value="Im not robot">
</form>

<?php

//echo 'kode:'.$_SESSION['code'];

?>
<style>
body{
width:100%;
left:50%;
}
</style>
</body>
</html>
