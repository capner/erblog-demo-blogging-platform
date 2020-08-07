<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>
<form action="/" method="GET"  role="search" target="_top">
<input class="form-control" name="" placeholder="name" type="hidden" value="">
<div class="form-group">
<label> Filter :
</label>
<select name = "coloumn" class="form-control">
<option value="title">Title</option>
<option value="authorname">Author</option>
</select>
</div>
<div class="form-group">
<label> Status :
</label>
<select name = "status" class="form-control">
<option value="publish">Publish</option>
<?php
if ($my_role == 'admin'){
echo '
<option value="draft">Draft</option>
<option value="pending">Pending</option>

';
}
?>
</select>
</div>
<div class="form-group">
<label> Keyword :
</label>
<input class="form-control" name="keyword" type="text">
</div>

<br>
<button class="btn btn-primary" >Search</button>
</form>
<br>
<br>
<br>

<?php
//jawaban
$url_parameter = '';
if ($my_role == 'admin'){
$filter = "SELECT * FROM datapost WHERE language = '$language' $sqlcategory order by id desc ";	
} else {
$filter = "SELECT * FROM datapost where status = 'publish' AND language = '$language' $sqlcategory order by id desc ";
}
if (isset($_GET['keyword'])) {
$keyword = mysql_real_escape_string($_GET['keyword']);
$coloumn = mysql_real_escape_string($_GET['coloumn']);
$status = mysql_real_escape_string($_GET['status']);

$url_parameter = 'coloumn='.$coloumn.'&keyword='.$keyword.'&status='.$status;
//$searchquery = str_replace(' ',' | ',$search);
echo '
<br>Search result for keyword :<span style="color:green">'.htmlspecialchars($coloumn).' : '.htmlspecialchars($keyword) .'</span><br><br><br>
' ;
if ($my_role == 'admin'){
$filter = "SELECT * FROM datapost where ".$coloumn." like '%$keyword%'  and  status = '$status' AND language = '$language' $sqlcategory order by id  desc ";	
} else {
$filter = "SELECT * FROM datapost where ".$coloumn." like '%$keyword%'  and  status = '$status'  AND language = '$language' $sqlcategory order by id  desc ";
}

if ($coloumn == 'authorname'){
if ($my_role == 'admin'){
$filter = "SELECT datapost.*,account.* FROM datapost inner join account on datapost.author = account.u where account.name like '%$keyword%'  and  datapost.status = '$status' order by datapost.id  desc ";	
} else {
$filter = "SELECT datapost.*,account.* FROM datapost inner join account on datapost.author = account.u where account.name like '%$keyword%'  and  datapost.status = '$status'   order by datapost.id  desc ";
}

}
}

$per_page= '7';
$page_query = mysql_query("SELECT COUNT(id) from datapost ");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  

$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query(" $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil !== 0 ) {
$i = 0 ;
while($row = mysql_fetch_array($query)){ 
$datapost_id = htmlspecialchars($row['id']);
$datapost_timestamp =htmlspecialchars($row['timestamp']);
$datapost_title = htmlspecialchars($row['title']);
$datapost_text = htmlspecialchars($row['text']);
$datapost_author = htmlspecialchars($row['author']);
$datapost_permalink = htmlspecialchars($row['permalink']);
$datapost_u = htmlspecialchars($row['u']);
$datapost_status = htmlspecialchars($row['status']);
$datapost_parent = htmlspecialchars($row['parent']);
$datapost_view = htmlspecialchars($row['view']);


$query2 = mysql_query("SELECT * FROM  datagroup where u = '$datapost_parent' ");
while($row = mysql_fetch_assoc($query2)){
$datagroup_title = $row['title'];
$datagroup_permalink = create_url($row['title']);
$datagroup_u = $row['u'];
}
$query3 = mysql_query("SELECT * FROM  account where u = '$datapost_author' ");
while($row = mysql_fetch_assoc($query3)){
$datapost_name = htmlspecialchars($row['name']);
$datapost_author_role = htmlspecialchars($row['role']);
$datapost_author_u = htmlspecialchars($row['u']);
$datapost_author_permalink = create_url($row['name']);
$datapost_author_picture = htmlspecialchars($row['picture']);



echo '
<br>
<h3>
';
if ($my_role == 'admin'){
echo '['.$datapost_status.']';
}


echo '
<a href="/'.$datapost_permalink.'.html">'.$datapost_title .'</a> </h3>
'.$datapost_permalink.'
<span class="glyphicon glyphicon-user"></span> <a href="index.php?'.$datapost_author_permalink.'&page=publisher&u='.$datapost_author_u.'">'.$datapost_name.'</a> / <a href="index.php?page=group&u='.$datagroup_u.'">'.$datagroup_title.'</a> 
<br>
'.closetags(substr(showBBcodes($datapost_text),0,200)).'...
<br>
';
if( $datapost_author == $my_u || $my_role == 'admin') {
echo '
[<a href="/index.php?page=post-editor&action=edit&u='.$datapost_u.'">Edit</a>]';	
}
echo '<br><br><br>';
}
}


?>

     <ul class="pagination">
            <!-- LINK FIRST AND PREV -->
            <?php
            if ($page == 1) { // Jika page adalah pake ke 1, maka disable link PREV
            ?>
              <a href="#">First</a>
              <a href="#">&laquo;</a>
            <?php
            } else { // Jika buka page ke 1
                $link_prev = ($page > 1) ? $page - 1 : 1;
            echo '
                <a href="index.php?'.$url_parameter.'&next=1" rel="noindex next">First</a> 
                <a href="index.php?'.$url_parameter.'&next='.$link_prev.'">&laquo;</a>
        ';
            }
            ?>

            <!-- LINK NUMBER -->
            <?php
            // Buat query untuk menghitung semua jumlah data
            $query = mysql_query("SELECT COUNT(id) AS jumlah FROM datapost where status = 'publish' ");
            while ($row=mysql_fetch_assoc($query)){
            $jumlah = $row['jumlah'];
            }

            $jumlah_page = ceil($jumlah / $per_page); // Hitung jumlah halamanya
            $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
            $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link member
            $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

            for ($i = $start_number; $i <= $end_number; $i++) {
                $link_active = ($page == $i) ? 'class="active"' : '';
            echo '
                <a href="index.php?'.$url_parameter.'&next='.$i.'" '.$link_active.'>'.$i.'</a>
            ';
            }
            ?>

            <!-- LINK NEXT AND LAST -->
            <?php
            // Jika page sama dengan jumlah page, maka disable link NEXT nya
            // Artinya page tersebut adalah page terakhir
            if ($page == $jumlah_page) { // Jika page terakhir
            ?>
                <a href="#">&raquo;</a>
                <a href="#">Last</a>
            <?php
            } else { // Jika bukan page terakhir
                $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

echo '
                <a href="index.php?'.$url_parameter.'&next='.$link_next.'" rel="noindex next">&raquo; </a> 
                <a href="index.php?'.$url_parameter.'&next='.$jumlah_page.'">Last</a>
        ';
            }
            ?>
</ul>

<?php

} else {
echo 'data not found';

}
?>
