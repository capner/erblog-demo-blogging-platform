<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>
<h3>Home</h3>

<?php
$url_parameter = 'page=group-list';
if  ($my_role == 'admin'){
$filter = "datagroup order by title asc ";
} else {
$filter = "datagroup where status = 'publish' order by title asc ";	
}
if (isset($_GET['keyword'])) {
$search = mysql_real_escape_string($_GET['keyword']);
$url_parameter = $url_parameter.'&keyword='.$search;
//$searchquery = str_replace(' ',' | ',$search);
echo '
<br>Search result for keyword :<span style="color:green">'.htmlspecialchars($search) .'</span><br>
' ;
if  ($my_role == 'admin'){
$filter = "datagroup where title like '%$search%' order by title asc ";
} else {
$filter = "datagroup where title like '%$search%' and status = 'publish' order by title asc ";	
}

//$url_parameter = $url_parameter.'&keyword='.$search;
$search = strtolower($search);
//$query = mysql_query("insert into search (keyword) values ('$search')");
}

$per_page= '20';
$page_query = mysql_query("SELECT COUNT(*) FROM datagroup  ");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  
$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM  $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil <> 0 ) {
while($row = mysql_fetch_array($query)){ 
$datagroup_timestamp = htmlspecialchars($row['timestamp']);
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_status = htmlspecialchars($row['status']);
$datagroup_author = htmlspecialchars($row['author']);
$datagroup_post = htmlspecialchars($row['post']);
$datagroup_u = htmlspecialchars($row['u']);
$datagroup_permalink = htmlspecialchars($row['permalink']);
$datagroup_follower= htmlspecialchars($row['follower']);
$result=mysql_query("SELECT count(*) as totalreply from datapost where parent = '$datagroup_u' ");
$data=mysql_fetch_assoc($result);
$totalreply= $data['totalreply'] ;
$query1 = mysql_query("SELECT * FROM  account where u = '$datagroup_author' ");
while($row = mysql_fetch_assoc($query1)){
$home_name = htmlspecialchars($row['name']);
$home_role = htmlspecialchars($row['role']);
$home_username_u = htmlspecialchars($row['u']);

if ($datagroup_status == 'publish'){
$publish_status = '';	
} else {
$publish_status = '[DRAFT]';		
}
echo '
';
echo '<li><b>'.$publish_status.'<a href="index.php?'.$datagroup_permalink.'&page=group&u='.$datagroup_u.'">' . $datagroup_title .'</a> </b>';
if( $datagroup_author == $my_u || $my_role == 'admin') {
echo '
 [<a href="index.php?page=group-editor&action=edit&u='.$datagroup_u.'">edit</a>] </li>';	
}

/*
$query587 = mysql_query("SELECT * FROM datapost where parent = '$datagroup_u' order by id desc limit 10 ");
while($row = mysql_fetch_array($query587)){ 
$datapost_id = htmlspecialchars($row['id']);
$datapost_timestamp =htmlspecialchars($row['timestamp']);
$datapost_title = htmlspecialchars($row['title']);
$datapost_status = htmlspecialchars($row['status']);
$datapost_author = $row['author'];
$datapost_permalink = create_url($row['title']);
$datapost_u = $row['u'];
$datapost_comment = $row['comment'];
$datapost_hidden = $row['hidden'];
$datapost_parent = $row['parent'];
$datapost_view = $row['view'];

if($datapost_hidden == '0'){
$publish_status = '';	
} else {
$publish_status = '[DRAFT]';	
}

echo '<div id="">  »'.$publish_status.' <a href="/index.php?'.$datapost_permalink.'&page=post&u='.$datapost_u.'">'.$datapost_title .'</a>';
if( $datapost_author == $my_u || $my_role == 'admin') {
echo '
[<a href="index.php?page=post-editor&action=edit&u='.$datapost_u.'">edit</a>]';	
}
}
*/

}
}

echo '
<a href="index.php?'.$url_parameter.'&next='.($page-1).'"  rel="noindex prev"><button>PREVIOUS</button></a>
'; 
for ($i=1; $i<=$total_pages; $i++) {  
};  
echo '
<a href="index.php?'.$url_parameter.'&next='.($page+1).'"  rel="noindex next"><button>NEXT</button></a>
';

} 
echo '</div>';
?>
<br>

