<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>

<?php
echo '<h1>Comment </h1>';

//jawaban
if ($my_role == 'admin'){
$filter = " ";
} else {
$filter = " ";
}
$per_page= '10';
$page_query = mysql_query("SELECT COUNT(*) from datacomment order by id desc");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  

$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM datacomment order by id desc  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil <> 0 ) {

while($row = mysql_fetch_array($query)){ 
$datacomment_timestamp =htmlspecialchars($row['timestamp']);
$datacomment_text = htmlspecialchars($row['text']);
$datacomment_author = $row['author'];
$datacomment_hidden = $row['hidden'];
$datacomment_u = $row['u'];
$result=mysql_query("SELECT count(*) as totalcomment from datacomment ");
$data=mysql_fetch_assoc($result);
$totalcomment= $data['totalcomment'] ;
$query3 = mysql_query("SELECT * FROM  account where u = '$datacomment_author' ");
while($row = mysql_fetch_assoc($query3)){
$datacomment_name = htmlspecialchars($row['name']);
if($datacomment_hidden == '0'){
$publish_status = '';	
} else {
$publish_status = '[DRAFT]';	
}
if ($my_role == 'admin'){

} else {
if($datacomment_hidden == '0'){

} else {
$datacomment_text = '[komentar sedang ditinjau oleh admin]';	
}
}
echo '
<h3><span class="display-name">'.mysql_real_escape_string(htmlentities($datacomment_name)) .'</span></h3> <div id="post-info"><span class="timestamp" rel="datapost-timestamp"> '.$datacomment_timestamp.'</span>, ';
if( $datacomment_author == $my_u || $my_role == 'admin') {
echo '
<a href="index.php?page=comment-editor&action=edit&u='.$datacomment_u.'">edit</a>';	
}
echo '</div><br>';
echo '<div id="wrapper">'.$publish_status.' '.$datacomment_text .'</div>';
echo '<br><br>
';
}
}
} 
echo '</div><div></div></div>';
echo '<ul class="pagination">';
echo '<li><a href="index.php?'.$permalink.'&page=post&u='.$u.'&next='.($page-1).'" class="button" rel="noindex prev">PREVIOUS</a></li>'; 
for ($i=1; $i<=$total_pages; $i++) {  
};  
echo '<li><a href="index.php?'.$permalink.'&page=post&u='.$datapost_u.'&next='.($page+1).'" class="button" rel="next">NEXT</a></li>';
echo '</ul>';
echo '';
?>