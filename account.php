<?php
$author = $_GET['author'];
$query1 = mysql_query("SELECT * FROM  account where u = '$author' ");
while($row = mysql_fetch_assoc($query1)){
$profil_role = htmlspecialchars($row['role']);
$profil_name = htmlspecialchars($row['name']);
$profil_poin = htmlspecialchars($row['poin']);
$profil_skill = htmlspecialchars($row['skill']);
$profil_register = htmlspecialchars($row['register']);
$profil_username_u = htmlspecialchars($row['u']);
}
?>
<div class="row";> 
<div class="col-md-3">
<img class="centered-and-cropped" width="100" height="100" style="border-square:50%"src="<?php echo $profil_skill;?>" >
</div>
<div class="col-md-9">
ID : <?php echo $profil_username_u ;?>
<br>
Name : <?php echo $profil_name ;?>
<br>
Role : <?php echo $profil_role ;?>
<br>
Register : <?php echo $profil_register ;?>
<br>
</div>
</div>
<br>
<br>