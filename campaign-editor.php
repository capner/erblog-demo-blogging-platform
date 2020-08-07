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
$data_campaign_u = md5(base64_encode($fulltime.$my_username));
$action = mysql_real_escape_string($_GET['action']);
if (isset($_GET['action'])) {
if ($action == 'new') {
$data_campaign_title = 'my bitcoin exchanger';
$data_campaign_link = 'http://myexchanger.com';
$data_campaign_status = 'active';
$data_campaign_image = 'http://imgbb.com/banner.jpg';
$data_campaign_cpm = '0.1';
$action = 'new';	
}
if ($action == 'edit') {
$data_campaign_u = mysql_real_escape_string($_GET['u']);
$query=mysql_query("select * from data_campaign where u = '$data_campaign_u' ");
while ($row= mysql_fetch_array($query)) {
$data_campaign_title = htmlspecialchars($row['title']);
$data_campaign_link = htmlspecialchars($row['link']);
$data_campaign_author = htmlspecialchars($row['author']);
$data_campaign_status = htmlspecialchars($row['status']);
$data_campaign_image = htmlspecialchars($row['image']);
$data_campaign_cpm = htmlspecialchars($row['cpm']);
$action = 'edit';	
}
if ($data_campaign_author !== $my_u && $my_role !== 'admin' ){
echo 'you have no permission';
die;	
}
}
}
?>

<input type ='hidden'  id="u" value='<?php echo $data_campaign_u; ?>' readonly> 
<br>
<div class="form-group">
Title
<br>
<input type = "text" class="form-control" id="title" value='<?php echo $data_campaign_title; ?>'>
</div>
<div class="form-group">
<label for="penerima">Image Link (200x200 max 1mb)
</label>
<input type = "text"  id="image" class="form-control" value='<?php echo $data_campaign_image; ?>'>
</div>
<div class="form-group">
<label >Link Website
</label>
<input type = "text"  id="link" class="form-control" value='<?php echo $data_campaign_link; ?>'>
</div>
<div class="form-group">
<label >CPM 
</label>
<input type = "text"  id="cpm" class="form-control" value='<?php echo $data_campaign_cpm; ?>'>
</div>
<div class="form-group">
<label> Status :
</label>
<select name = "status" id="status" class="form-control">
<option value="<?php echo $data_campaign_status;?>"><?php echo $data_campaign_status;?></option>
<option value="active">active</option>
<option value="paused">paused</option>
</select>
</div>
<div class="form-group">
<br>
<button  id="btn-campaign-editor" class="btn btn-primary">Save                          
</button>			 
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<script>
$(document).ready(function() {
$('#btn-campaign-editor').click(function(){
var u = $("#u").val();
var title = $("#title").val();
var image = $("#image").val();
var link = $("#link").val();
var cpm = $("#cpm").val();	
var status = $("#status").val();	


$.post("processor.php",
    {
		page: "campaign-editor",
		u: u ,
		title:title,
		image:image,
  link:link,
 cpm:cpm,
		status:status,
		
    },
    function(data,status){
    
    
		alert(data);
		});
	
});
	 });
</script>
