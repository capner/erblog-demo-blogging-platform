<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
;
?>

<?php
$u = mysql_real_escape_string($_GET['u']);
$query =  mysql_query("SELECT * FROM datagroup where u = '$u' limit 1");
$hasil = mysql_num_rows($query);
if ($hasil == 0 ) {
header("location:/index.php");
}


$query = mysql_query("SELECT * FROM datagroup where u = '$u' ");
while($row = mysql_fetch_assoc($query)){ 
$datagroup_timestamp = htmlspecialchars($row['timestamp']);
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_status = htmlspecialchars($row['status']);
$datagroup_author = htmlspecialchars($row['author']);
$datagroup_post = htmlspecialchars($row['post']);
$datagroup_u= htmlspecialchars($row['u']);
$datagroup_permalink= create_url($row['title']);
$datagroup_follower = htmlspecialchars($row['follower']);

if ($datagroup_status == 'draft' ){
echo 'This group has been deleted' ;
die;
}
}



echo '<br><br><br>';
echo '<h3>'.$datagroup_title.'</h3>';
//echo $replyform ;
echo '<br>
';
//jawaban
$per_page= '20';
$page_query = mysql_query("SELECT COUNT(*) from datapost where  parent= '$datagroup_u' and status = 'publish' order by id desc");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  

$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM datapost where  parent= '$datagroup_u' and status = 'publish' order by id desc  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil == 0 ){
echo 'no post in this category';
die;	
}

while($row = mysql_fetch_array($query)){ 
$datapost_id = htmlspecialchars($row['id']);
$datapost_timestamp =htmlspecialchars($row['timestamp']);
$datapost_title = htmlspecialchars($row['title']);
$datapost_text = htmlspecialchars($row['text']);
$datapost_author = htmlspecialchars($row['author']);
$datapost_permalink = htmlspecialchars($row['author']);
$datapost_view = htmlspecialchars($row['view']);
$datapost_u = $row['u'];



$query3 = mysql_query("SELECT * FROM  account where u = '$datapost_author' ");
while($row = mysql_fetch_assoc($query3)){
$datapost_name = htmlspecialchars($row['name']);
$datapost_author_role = htmlspecialchars($row['role']);
$datapost_author_u = htmlspecialchars($row['u']);

$query458=mysql_query("SELECT MAX(view) as topview FROM datapost ");
while($row = mysql_fetch_assoc($query458)){ 
$topview = $row['topview'];
}
$stars = ($datapost_view / $topview)*5;
echo '<h2><a href="/'.$datapost_permalink.'/'.$datapost_u.'.html">'.$datapost_title .'</a> </h3>
<a href="/index.php?page=publisher&u='.$datapost_author_u.'">'.$datapost_name.'</a> / <a href="/index.php?page=group&u='.$datagroup_u.'">'.$datagroup_title.'</a> 
<br>
'.substr($datapost_text,0,200).'...
<br>
';

if( $datapost_author == $my_u || $my_role == 'admin') {
echo '
<a href="/index.php?page=post-editor&action=edit&u='.$datapost_u.'"> [edit] </a>';	
}
echo '
<br><br><br>

';
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
