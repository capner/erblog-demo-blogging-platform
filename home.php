<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>
<?php
setcookie('dst',$_SERVER['REQUEST_URI'],time() + (10 * 365 * 24 * 60 * 60));
if(isset($_COOKIE['session'])){

}
?>

<?php
//jawaban
$url_parameter = '';
if ($my_role == 'admin'){
$filter = "where hidden = '0' or hidden = '1' order by id desc ";	
} else {
$filter = "where hidden = '0' order by id desc ";
}
if (isset($_GET['keyword'])) {
$search = htmlspecialchars($_GET['keyword']);
$url_parameter = '&keyword='.$search;
//$searchquery = str_replace(' ',' | ',$search);
echo '
<br>Search result for keyword :<span style="color:green">'.htmlspecialchars($search) .'</span><br><br><br>
' ;
if ($my_role == 'admin'){
$filter = " where title like '%$search%'  or  hidden = '0' and hidden = '1'  order by id  desc ";	
} else {
$filter = " where title like '%$search%'  and  hidden = '0'   order by id  desc ";
}
$url_parameter = '&keyword='.$search;
$search = strtolower($search);
}

$per_page= '100';
$page_query = $db_operation->query("SELECT COUNT(*) from datapost where  hidden = '0' order by id desc");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  

$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = $db_operation->query("SELECT * FROM datapost $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil <> 0 ) {
$i = 0 ;
while($row = mysql_fetch_array($query)){ 
$datapost_id = htmlspecialchars($row['id']);
$datapost_timestamp =htmlspecialchars($row['timestamp']);
$datapost_title = htmlspecialchars($row['title']);
$datapost_text = htmlspecialchars($row['text']);
$datapost_author = $row['author'];
$datapost_permalink = create_url($row['title']);
$datapost_u = $row['u'];
$datapost_comment = $row['comment'];
$datapost_hidden = $row['hidden'];
$datapost_parent = $row['parent'];
$datapost_view = $row['view'];
$query2 = $db_operation->query("SELECT * FROM  datagroup where u = '$datapost_parent' ");
while($row = mysql_fetch_assoc($query2)){
$datagroup_title = $row['title'];
$datagroup_permalink = create_url($row['title']);
$datagroup_u = $row['u'];
}
$query3 = $db_operation->query("SELECT * FROM  account where u = '$datapost_author' ");
while($row = mysql_fetch_assoc($query3)){
$datapost_name = htmlspecialchars($row['name']);
$datapost_author_role = htmlspecialchars($row['role']);
$ncolor = htmlspecialchars($row['ncolor']);
include 'nick-color.php';
//sistem follow
$query4 = $db_operation->query("SELECT * FROM  followpost where follower = '$my_u' and following = '$datapost_u' ");
$hasil = mysql_num_rows($query4);
if ($hasil <> 0 ) {
while($row = mysql_fetch_assoc($query4)){

$followstatus = '<a href="/?page=post&u='.$datapost_u.'&followaction=unfollow" rel="noindex nofollow">unfollow</a>';	
}
} else {
$followstatus = '<a href="/?page=post&u='.$datapost_u.'&followaction=follow" rel="noindex nofollow">follow</a>';	
}
//end
if($datapost_hidden == '0'){
$publish_status = '';	
} else {
$publish_status = '[DRAFT]';	
}
$query458=mysql_query("SELECT MAX(view) as topview FROM datapost ");
while($row = mysql_fetch_assoc($query458)){ 
$topview = $row['topview'];
}
$stars = ($datapost_view / $topview)*5;
echo '<div id="">#'.$publish_status.' <a href="/index.php?'.$datapost_permalink.'&page=post&u='.$datapost_u.'">'.$datapost_title .'</a>';
if( $datapost_author == $my_u || $my_role == 'admin') {
echo '
[<a href="index.php?page=post-editor&action=edit&u='.$datapost_u.'">edit</a>]';	
}
echo '</div></div>';
}
$i++;
if($i == 4) {
echo $banner_atas;
$i = 0;	
}
}
echo '<ul class="pagination">';
echo '<li><a href="index.php?'.$url_parameter.'&next='.($page-1).'" class="button" rel="noindex prev">PREVIOUS</a></li>'; 
for ($i=1; $i<=$total_pages; $i++) {  
};  
echo '<li><a href="index.php?'.$url_parameter.'&next='.($page+1).'" class="button " rel="noindex next">NEXT</a></li>';
echo '</ul></div>';

} 
?>
