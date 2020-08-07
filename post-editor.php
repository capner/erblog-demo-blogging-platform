<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
if(!isset($_COOKIE['account_u'])){
echo 'you need to login first';
die;
}
?>
<script src="jquery.selection.js"></script>

<?php
$datapost_u = md5(base64_encode($fulltime.$my_username));
$action = mysql_real_escape_string($_GET['action']);
if (isset($_GET['action'])) {
if ($action == 'new') {
$datapost_text = '';
$datapost_title = '';
$datagroup_u = '-';
$datagroup_title = '-';
$datapost_status = '-';
$datapost_permalink = '-';
$action = 'new';	
}
if ($action == 'edit') {
$datapost_u = mysql_real_escape_string($_GET['u']);
$query=mysql_query("select * from datapost where u = '$datapost_u' ");
while ($row= mysql_fetch_array($query)) {
$datapost_title = htmlspecialchars($row['title']);
$datapost_text = htmlspecialchars($row['text']);
$datapost_parent = htmlspecialchars($row['parent']);
$datapost_author = htmlspecialchars($row['author']);
$datapost_permalink = htmlspecialchars($row['permalink']);
$datapost_status = htmlspecialchars($row['status']);
if ($my_role !== 'admin'){
$datapost_status = 'pending';
}

$image = htmlspecialchars($row['image']);
$caption = htmlspecialchars($row['caption']);
$query = mysql_query("SELECT * FROM datagroup where u = '$datapost_parent' ");
while($row = mysql_fetch_assoc($query)){ 
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_u = htmlspecialchars($row['u']);
$datagroup_title = htmlspecialchars($row['title']);
}
$action = 'edit';	
}
if ($datapost_author !== $my_u && $my_role !== 'admin' ){
echo 'this is not your post';
die;	
}
}
}
?>
<br>
<br>
<input type ='hidden' name='u' id="u" value='<?php echo $datapost_u; ?>' readonly> 
<br>
<div class="form-group">
Title
<br>
<textarea class="form-control" name ="title" id="title" rows="3" maxlength="50"><?php echo $datapost_title; ?></textarea>
</div>
<div class="form-group">		 
<label for="penerima">Content
<br>
<button  id="wrap-bold" class="btn btn-warning">B                         
</button>	
<button  id="wrap-underline" class="btn btn-warning">U                         
</button>	
<button  id="wrap-italic" class="btn btn-warning">/                          
</button>	
<button  id="wrap-red" class="btn btn-warning">Red                         
</button>	
<button  id="wrap-green" class="btn btn-warning">Green                         
</button>	
<button  id="wrap-img" class="btn btn-warning">Img                        
</button>	
</label>
<textarea name='text' id="text" class="form-control"  size="500" rows='20' ><?php echo $datapost_text;?></textarea>
</div>
<div class="form-group">
<label>Category:
</label>
<select name = "category" id="category" class="form-control">
<option value="<?php echo $datagroup_u;?>"><?php echo $datagroup_title;?></option>
<?php
$query = mysql_query("SELECT * FROM datagroup order by title asc ");
while($row = mysql_fetch_array($query)){ 
$datagroup_timestamp = htmlspecialchars($row['timestamp']);
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_text = htmlspecialchars($row['text']);
$datagroup_author = htmlspecialchars($row['author']);
$datagroup_post = htmlspecialchars($row['post']);
$datagroup_u = htmlspecialchars($row['u']);
$datagroup_permalink = htmlspecialchars($row['permalink']);
$datagroup_follower= htmlspecialchars($row['follower']);
echo '
<option value="'.$datagroup_u.'">'.$datagroup_title.'</option>
';
}
?>
</select>
</div>
<div class="form-group">
<label> Status :
</label>
<select name = "status" id="status" class="form-control">
<option value="<?php echo $datapost_status;?>"><?php echo $datapost_status;?></option>
<?php
if ($my_role == 'admin'){
echo '
<option value="publish">publish</option>
';
}
?>
<option value="pending">pending</option>
<?php
if ($datapost_status !== 'publish' || $my_role == 'admin'){
echo '
<option value="draft">draft</option>
';
}
?>
</select>
</div>
<div class="form-group">
<br>
<button  id="btn-post-editor" class="btn btn-primary">Save                          
</button>			 
</div>
<br>
<br>
<br>
<br>
<br>
<a href="/<?php echo $datapost_u; ?>/<?php echo $datapost_permalink; ?>.html" target="blank"><button name = "submit" class="btn btn-success" >VIEW PUBLISHED POST</button></a>
<br>
<br>
<br>
<br>
<script>
$(document).ready(function(event) {
$('#btn-post-editor').click(function(event){
var u = $("#u").val();
var title = $("#title").val();
var text = $("#text").val();
var category = $("#category").val();
var status = $("#status").val();	

$("#loader").show();

$.post("processor.php",
    {
		page: "post-editor",
		u: u ,
		title:title,
		text:text,
		category:category,
		status:status,
		
    },
    function(data,status){
    //$(".loader").css('display', 'none');
    $("#loader").hide();
		alert(data);
		});
	
});


$('#wrap-bold').click(function(){ 
$('#text') 
// insert before string '<strong>' 
// <strong> を選択テキストの前に挿入 
.selection('insert', {text: '[b]', mode: 'before'}) 
// insert after string '</strong>' 
// </strong> を選択テキストの後に挿入 
.selection('insert', {text: '[/b]', mode: 'after'});

});

$('#wrap-red').click(function(){ 
$('#text') 
// insert before string '<strong>' 
// <strong> を選択テキストの前に挿入 
.selection('insert', {text: '[color=red]', mode: 'before'}) 
// insert after string '</strong>' 
// </strong> を選択テキストの後に挿入 
.selection('insert', {text: '[/color]', mode: 'after'});

});


$('#wrap-green').click(function(){ 
$('#text') 
.selection('insert', {text: '[color=green]', mode: 'before'}) 
.selection('insert', {text: '[/color]', mode: 'after'});

});

$('#wrap-underline').click(function(){ 
$('#text') 
.selection('insert', {text: '[u]', mode: 'before'}) 
.selection('insert', {text: '[/u]', mode: 'after'});

});


$('#wrap-italic').click(function(){ 
$('#text') 
.selection('insert', {text: '[i]', mode: 'before'}) 
.selection('insert', {text: '[/i]', mode: 'after'});

});

$('#wrap-img').click(function(){ 
$('#text') 
.selection('insert', {text: '[img]', mode: 'before'}) 
.selection('insert', {text: '[/img]', mode: 'after'});

});

$('#wrap-youtube').click(function(){ 
$('#text') 
.selection('insert', {text: '[youtube]', mode: 'before'}) 
.selection('insert', {text: '[/youtube]', mode: 'after'});

});


	 });
</script>
