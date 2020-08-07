<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>

<?php
echo '<h3>Popular Post</h3>'; 
$query = mysql_query("SELECT * FROM datapost where status = 'publish' AND language = '$language' order by trending desc limit 10 ");
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

?>
<br>
<?php
echo '<h3>Recent Post</h3>'; 
$query = mysql_query("SELECT * FROM datapost where status = 'publish' AND language = '$language' order by id desc limit 10 ");
while($row = mysql_fetch_assoc($query)){ 
$datapost_timestamp_related = htmlspecialchars($row['timestamp']);
$datapost_title_related = htmlspecialchars($row['title']);
$datapost_text_related = htmlspecialchars($row['text']);
$datapost_author_related = htmlspecialchars($row['author']);
$datapost_u_related= htmlspecialchars($row['u']);
$datapost_permalink_related = htmlspecialchars($row['permalink']);
$datapost_parent_related = htmlspecialchars($row['parent']);
echo '<li><a href="/'.$datapost_permalink_related.'.html"  rel="index follow">'.$datapost_title_related .'</a></li>';
}

?>
<br>
<?php
echo '<h3>Featured Post</h3>'; 
$query = mysql_query("SELECT * FROM datapost where status = 'publish' AND language = '$language' order by trending asc limit 10 ");
while($row = mysql_fetch_assoc($query)){ 
$datapost_timestamp_related = htmlspecialchars($row['timestamp']);
$datapost_title_related = htmlspecialchars($row['title']);
$datapost_text_related = htmlspecialchars($row['text']);
$datapost_author_related = htmlspecialchars($row['author']);
$datapost_u_related= htmlspecialchars($row['u']);
$datapost_permalink_related = htmlspecialchars($row['permalink']);
$datapost_parent_related = htmlspecialchars($row['parent']);
echo '<li><a href="/'.$datapost_permalink_related.'.html"  rel="index follow">'.$datapost_title_related .'</a></li>';
}

?>






