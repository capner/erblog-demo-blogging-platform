<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<?php

$action = mysql_real_escape_string($_GET['action']);
if (isset($_GET['action'])) {
if ($action == 'new') {
$datacomment_parent = mysql_real_escape_string($_GET['parent']);
$datacomment_u = '';
$datacomment_text = '';
$action = 'new';	
}
if ($action == 'edit') {
$datacomment_u = mysql_real_escape_string($_GET['u']);
$query=mysql_query("select * from datacomment where u = '$datacomment_u' ");
while ($row= mysql_fetch_array($query)) {
$datacomment_text = htmlspecialchars($row['text']);
$datacomment_parent = htmlspecialchars($row['parent']);
$action = 'edit';	
}
}
if ($action == 'delete') {
$datacomment_u = mysql_real_escape_string($_GET['u']);
$query =mysql_query("select * from datacomment where u = '$datacomment_u' ");
while ($row= mysql_fetch_array($query)) {
$datacomment_author = $row['author'];
$datacomment_parent = $row['parent'];
}
if ($my_u == $datacomment_author || $my_role == 'admin'|| $my_role == 'xxx' ){
$query =mysql_query("update datacomment set hidden = '1' where u = '$datacomment_u' ");
$query = mysql_query("update datapost set comment = comment - 1 where u = '$datacomment_parent' ");
header('location:?page=post&u='.$datacomment_parent);
}
}
}

if (isset($_POST['submit'])){
/*
if(validation () == false ){
echo 'request not valid';
die;	
}
*/
$datacomment_parent = mysql_real_escape_string($_POST['parent']);
$action = mysql_real_escape_string($_POST['action']);
$datacomment_text = mysql_real_escape_string($_POST['text']);
$datacomment_u = mysql_real_escape_string($_POST['u']);
if($action == 'new') {
$datacomment_u = md5(base64_encode($fulltime.$my_username.$datacomment_text));
$query = mysql_query("insert into datacomment (timestamp,author,text,parent,u,hidden) values('$fulltime','$my_u','$datacomment_text','$datacomment_parent','$datacomment_u' ,'0')");	
$query = mysql_query("SELECT * FROM datapost where u = '$datacomment_parent' ");
while($row = mysql_fetch_assoc($query)){ 
$datapost_permalink = htmlspecialchars($row['permalink']);
$log_author1 = htmlspecialchars($row['author']);
$datapost_title = htmlspecialchars($row['title']);
}
$log_link = '/index.php?page=post&u='.$datacomment_parent;
$log_text = $my_name . ' write comment in post "' . $datapost_title .'"'; 




//nulis notif di log para follower
$query2 = mysql_query("SELECT * FROM  followpost where following = '$datacomment_parent' ");
$hasil = mysql_num_rows($query2);
if ($hasil !== 0 ) {
while($row = mysql_fetch_assoc($query2)){
$follower = $row['follower'];
$log_u = md5($fulltime.$log_link.$log_text);
$query = mysql_query("insert into log (timestamp,author,link,text,u)values('$fulltime','$follower','$log_link','$log_text','$log_u')");	
}
}
//end
//auto follow when nofollow
$query2 = mysql_query("SELECT * FROM  followpost where follower = '$my_u' and following = '$datacomment_parent' ");
$hasil = mysql_num_rows($query2);
if ($hasil !== 0 ) {
while($row = mysql_fetch_assoc($query2)){

}
} else {
$query = mysql_query("insert into followpost (follower,following,status) values ('$my_u','$datacomment_parent','1')");		
}


header('location:/index.php?page=post&u='.$datacomment_parent);
}
if ($action == 'edit') {
if ( $my_role == 'admin'){
$publish = mysql_real_escape_string($_POST['publish']);
$query= mysql_query("update  datacomment set hidden = '$publish' where u = '$datacomment_u' ");	
} else {
$query= mysql_query("update  datacomment set hidden = '1' where u = '$datacomment_u' ");		
}

$datacomment_u = mysql_real_escape_string($_GET['u']);
$query = mysql_query("select * from datacomment where u = '$datacomment_u ' ");
while ($row= mysql_fetch_array($query)) {
$datacomment_author = htmlspecialchars($row['author']);	
}
if ($my_u == $datacomment_author || $my_role == 'admin'|| $my_role == 'xxx' ){
$query= mysql_query("update  datacomment set text = '$datacomment_text'  where u = '$datacomment_u ' ");
header('location:?page=post&u='.$datacomment_parent);	
}
}
}


?>
<br>
<form action='' method='post'>
<input type ='hidden' name='csrf_name' value='<?php echo createToken() ; ?>'>
<input type ='hidden' name='parent' value='<?php echo $datacomment_parent; ?>'> 
<input type ='hidden' name='u' value='<?php echo $datacomment_u; ?>'> 
<input type ='hidden' name='action' value='<?php echo $action; ?>'>      
<div class="form-group">
<label for="penerima">write comment:
</label>
<textarea name='text' class="form-control" placeholder='write your text' rows='8' ><?php echo $datacomment_text;?></textarea>
</div>
<div class="form-group">
<select name = "publish" class="form-control">
<option value="0">publish</option>
<option value="1">draft</option>
</select>
</div>
<button type="submit" name = 'submit' class="btn btn-primary btn-block">send
</button>
</form>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<a href="/index.php?page=comment-editor&action=delete&u=<?php echo $datacomment_u; ?>"><button type="submit" name = 'submit' class="btn btn-danger">delete comment
</button></a>

