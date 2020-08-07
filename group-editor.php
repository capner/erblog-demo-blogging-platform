<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<?php
if (isset($_GET['action'])) {
$action = mysql_real_escape_string($_GET['action']);
if ($action == 'new') {
$datagroup_u = '';
$datagroup_title = '';
$datagroup_status = 'publish';
$action = 'new';	
}
if ($action == 'edit') {
$datagroup_u = mysql_real_escape_string($_GET['u']);
$query = mysql_query("select * from datagroup where u = '$datagroup_u' ");
while ($row= mysql_fetch_array($query)) {
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_status = htmlspecialchars($row['status']);
$action = 'edit';	
}
} 
} 


//jika post submit
if (isset($_POST['submit'])){
//jika csrf tidak valid
/*
if(validation () == false ){
echo 'request not valid';
die;	
}
*/
//memabaca variable
$datagroup_title = mysql_real_escape_string($_POST['title']);
$datagroup_status = mysql_real_escape_string($_POST['status']);
$datagroup_u = mysql_real_escape_string($_POST['u']);
$datagroup_action = mysql_real_escape_string($_POST['action']);
if (empty($_POST["title"])) {
echo 'judul atau isi tak boleh kosong';
exit ;
};
//jika submit post action new
if($action == 'new') {
//buat u baru

$datagroup_u = md5(base64_encode($fulltime.$my_username.$datagroup_title));
$query = mysql_query("insert into datagroup (timestamp,author,title,status,u) values('$fulltime','$my_u','$datagroup_title','$datagroup_status','$datagroup_u')");
$query = mysql_query("select * from datagroup where u = '$datagroup_u' ");
while ($row= mysql_fetch_array($query)) {
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_status = htmlspecialchars($row['status']);
}	
echo '<script>alert("saved successfull !! ")</script>';
} 
if($action == 'edit') {
$datagroup_u = mysql_real_escape_string($_GET['u']);
$query = mysql_query("select * from datagroup where u = '$datagroup_u' ");
while ($row= mysql_fetch_array($query)) {
$datagroup_author = htmlspecialchars($row['author']);
$datagroup_u = $row['u'];	
}
$query= mysql_query("update  datagroup set title = '$datagroup_title' , status = '$datagroup_status'  where u = '$datagroup_u' ");
$query = mysql_query("select * from datagroup where u = '$datagroup_u' ");
while ($row= mysql_fetch_array($query)) {
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_status = htmlspecialchars($row['status']);
}	
echo '<script>alert("saved successfull !! ")</script>';
} 
}


?>
<form action='' method='post'>
<input type ='hidden' name='csrf_name' value='<?php echo createToken() ; ?>'>
<input type ='hidden' name='u' value='<?php echo $datagroup_u; ?>'> 
<input type ='hidden' name='action' value='<?php echo $action; ?>'>   
<div class="form-group">
<label for="penerima">title:
</label>
<input type="text" name='title' class="form-control" placeholder='group name' value="<?php echo $datagroup_title ;?>">
</div>
<div class="form-group">
<label>Status:
</label>
<select name = "status" >
<option value="<?php echo $datagroup_status;?>"><?php echo $datagroup_status;?></option>
<option value="publish">publish</option>
<option value="draft">draft</option>
</select>
</div>
<div class="form-group">
<button type="submit" name = 'submit' class="btn btn-primary btn-block">save
</button>
</div>
</form>
<br>
<br>
<br>
<br>
<br>
<br>
<a href="index.php?page=group&u=<?php echo $datagroup_u; ?>" target="blank"><button type="submit" name = 'submit' class="btn btn-primary btn-block">VIEW PUBLISHED CATEGORY
</button> 
</a>
</div>
</div>
