<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}

?>
<br>
<br>


<?php
$permalink = mysql_real_escape_string($_GET['permalink']);
$u = mysql_real_escape_string($_GET['u']);

$query_datapost =  mysql_query("SELECT * FROM datapost where permalink = '$permalink' and status = 'publish' limit 1");
$hasil = mysql_num_rows($query_datapost);
if ($hasil == 0 ) {
header("HTTP/1.0 404 Not Found");
echo '
Check This Out ! | Mungkin Anda Suka Ini !
<br>
<br>';

$query = mysql_query("SELECT * FROM datapost where status = 'publish' AND language = 'id' order by trending desc limit 20 ");
while($row = mysql_fetch_assoc($query)){ 
$datapost_timestamp_related = htmlspecialchars($row['timestamp']);
$datapost_title_related = htmlspecialchars($row['title']);
$datapost_text_related = htmlspecialchars($row['text']);
$datapost_author_related = htmlspecialchars($row['author']);
$datapost_u_related= htmlspecialchars($row['u']);
$datapost_permalink_related = htmlspecialchars($row['permalink']);
$datapost_parent_related = htmlspecialchars($row['parent']);
echo '<li><a href="/'.$datapost_permalink_related.'.html" rel="index follow">'.$datapost_title_related .'</a></li>';
}

} else { 

$query_datapost =  mysql_query("SELECT * FROM datapost where permalink = '$permalink' and status = 'publish' limit 1");
while($row = mysql_fetch_assoc($query_datapost)){ 
$datapost_timestamp = htmlspecialchars($row['timestamp']);
$datapost_title = htmlspecialchars($row['title']);
$datapost_text = htmlentities($row['text']);
$datapost_author = htmlspecialchars($row['author']);
$datapost_u= htmlspecialchars($row['u']);
$datapost_permalink = htmlspecialchars($row['permalink']);
$datapost_parent= htmlspecialchars($row['parent']);
$datapost_view = htmlspecialchars($row['view']);
$datapost_language = htmlspecialchars($row['language']);

}



$query_datagroup = mysql_query("SELECT * FROM  datagroup where u = '$datapost_parent' ");
while($row = mysql_fetch_assoc($query_datagroup)){
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_u = htmlspecialchars($row['u']);
$datagroup_permalink = create_url($row['title']);
}




$query_account = mysql_query("SELECT * FROM  account where u = '$datapost_author' ");
while($row = mysql_fetch_assoc($query_account)){
$datapost_author_name = htmlspecialchars($row['name']);
$datapost_author_role = htmlspecialchars($row['role']);
$datapost_author_status = htmlspecialchars($row['status']);
$datapost_author_u = htmlspecialchars($row['u']);
$datapost_author_description = htmlspecialchars($row['description']);
$pub_impression = htmlspecialchars($row['pub_impression']);
}

echo '<br><br>';

echo '<h1>'.$datapost_title.'</h1>';
echo '<a href="/index.php?page=publisher&u='.$datapost_author_u.'">'.$datapost_author_name.'</a> - <a href="/index.php?page=group&u='.$datagroup_u.'">'.$datagroup_title.'</a>';
echo ' - <span class="timestamp" rel="datapost-timestamp"> '.$datapost_timestamp.'</span> / '.number_format($datapost_view).' ' ;
if( $datapost_author == $my_u || $my_role == 'admin') {
echo '
| <a href="/index.php?page=post-editor&action=edit&u='.$datapost_u.'">Edit</a>';	
}


echo '
<br>
';

$query_datapost_update = mysql_query("update datapost set view = view + 1 , trending = trending + 1 where u = '$datapost_u' ");
?>
<br>
<?php
include 'ads-code3.php';
?>
<br>
<br>
<?php 

echo '
<br><div class="wrapper"><b>Pinterduit.com - </b>'.closetags(showBBcodes(nl2br($datapost_text))).'</div>';
?>
<?php
//echo $serverlocation.$_SESSION['refresh'];
if ( $_SERVER['SERVER_NAME'] !== 'localhost' && $_SESSION['refresh'] < 200 && $datapost_author_role == 'admin' ){
//include 'ads-code.php';

} 
?>

<?php

echo '

';

echo '<h4>Related Post</h4>'; 
$query = mysql_query("SELECT * FROM datapost where parent = '$datapost_parent' and status = 'publish' and language = '$datapost_language' order by trending desc limit 10 ");
while($row = mysql_fetch_assoc($query)){ 
$datapost_timestamp_related = htmlspecialchars($row['timestamp']);
$datapost_title_related = htmlspecialchars($row['title']);
$datapost_text_related = htmlspecialchars($row['text']);
$datapost_author_related = htmlspecialchars($row['author']);
$datapost_u_related= htmlspecialchars($row['u']);
$datapost_permalink_related = htmlspecialchars($row['u']);
$datapost_parent_related = htmlspecialchars($row['parent']);
echo '<li><a href="/'.$datapost_permalink_related.'.html" rel="index follow">'.$datapost_title_related .'</a></li>';
}
echo  '<br><br>';


echo'';
echo '<br>';



echo '<br><br>';


}




?>
<br>
<?php
//echo $serverlocation.$_SESSION['refresh'];
if ( $_SERVER['SERVER_NAME'] !== 'localhost' && $_SESSION['refresh'] < 200 && $datapost_author_role == 'admin' ){
//include 'ads-code1.php';

} 
?>


<script>
$(document).ready(function() {


$('.likeButton').click(function(){

$.post("processor.php",
    {
		page:"likebutton",
		u: "<?php echo $datapost_u;?>",
		action: "like",
	      
    },
    function(data,status){
      alert(data);
    });
	
});
$('.dislikeButton').click(function(){

$.post("processor.php",
    {
		page:"likebutton",
		u: "<?php echo $datapost_u;?>",
		action: "dislike",    
    },
    function(data,status){
      alert(data);
    });	
	
});



$('#follow-button').click(function(){
var u = $("#u").val();
var action = $("#action").val();

	

$.post("processor.php",
    {
		page: "follow-account",
		u:u,
		action:action,
		
	      
    },
    function(data,status){
    if (data == "follow account success"){
     $("#action").val("Unfollow");
     $("#follow-button").html("Unfollow");
     $(".total-follower").html(parseInt($(".total-follower").html())+1);
     } else if (data == "unfollow account success"){
     $("#action").val("Follow");
     $("#follow-button").html("Follow");
      $(".total-follower").html(parseInt($(".total-follower").html())-1);
     }
     
		alert(data);
		});

	
	
	event.preventDefault();

});

/*
$(this).one('scroll',function(){

$.post("processor.php",
    {
		page: "counter-view",
		u:"<?php echo $datapost_u ; ?>",
		
		
	      
    },
function (data,status){
//alert(data);
});



});
*/
	 
	 });
</script>