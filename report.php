<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}

if(!isset($_COOKIE['account_u'])){
echo 'you need to login first';
die;
}

/*

if ($my_role !== 'admin' ){
echo 'restricted area';
exit;	
}
*/


?>

<span class="hitam-kecil">
<?php

setcookie('dst',$_SERVER['REQUEST_URI'],time() + (10 * 365 * 24 * 60 * 60));

$url_parameter = 'page=report';
if ($my_role == 'admin'){
	$filter = "logads order by id desc ";
}else{
	$filter = "logads where publisher = '$my_u' order by id desc";
}	


if (isset($_GET['keyword'])) {
$search = htmlspecialchars($_GET['keyword']);
$url_parameter = $url_parameter.'&keyword='.$search;
//$searchquery = str_replace(' ',' | ',$search);
echo '
<br>Search result for keyword :<span style="color:green">'.htmlspecialchars($search) .'</span><br>
' ;
$query2 = mysql_query("select * from account where username = '$search' ");
while($row=mysql_fetch_array($query2)){
$publisher_u= htmlspecialchars($row['u']);	
}
$filter = "logads where publisher = '$publisher_u' order by id desc";
//$url_parameter = $url_parameter.'&keyword='.$search;
$search = strtolower($search);
//$query = mysql_query("insert into search (keyword) values ('$search')");
}

$per_page= '7';
$page_query = mysql_query("SELECT COUNT(id) FROM $filter  ");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  
$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM  $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil !== 0 ) {

while($row = mysql_fetch_array($query)){ 
$logads_id = htmlspecialchars($row['id']);
$logads_timestamp = htmlspecialchars($row['timestamp']);
$logads_publisher = htmlspecialchars($row['publisher']);
$logads_advertiser = htmlspecialchars($row['advertiser']);
$logads_budget = htmlspecialchars($row['budget']);
$logads_ip = htmlspecialchars($row['ip']);
$logads_datapost_u = htmlspecialchars($row['datapost_u']);
$logads_uid = htmlspecialchars($row['uid']);

$query1 = mysql_query("select * from account where u = '$logads_publisher' ");
while($row=mysql_fetch_array($query1)){
$publisher_name= htmlspecialchars($row['name']);	
}

$query2 = mysql_query("select * from account where u = '$logads_advertiser' ");
while($row=mysql_fetch_array($query2)){
$advertiser_name= htmlspecialchars($row['name']);	
}

$query624 = mysql_query("SELECT * FROM datapost where u = '$logads_datapost_u' ");
while($row = mysql_fetch_assoc($query624)){ 
$datapost_timestamp = htmlspecialchars($row['timestamp']);
$datapost_title = htmlspecialchars($row['title']);
$datapost_text = $row['text'];
$datapost_author = htmlspecialchars($row['author']);
$datapost_u= htmlspecialchars($row['u']);
$datapost_permalink = create_url($row['title']);
$datapost_parent= htmlspecialchars($row['parent']);
$datapost_view = htmlspecialchars($row['view']);


}

echo '
<br>
<br>
# '.$logads_id.'<br>
 » timestamp: '.$logads_timestamp.' <br> 
 ';

if ($my_role == 'admin'){

echo '
 » uid : '.$logads_uid.' <br>
 » ip: '.$logads_ip.' <br>
 » advertiser : '.$advertiser_name.'<br>
 » publisher : '.$publisher_name.'<br>
 » budget : '.$logads_budget.'<br>

 ';
 
 }
 
 echo '
 » post title: '.$logads_datapost_u.' <br>
 <br><br>';

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

} 

?>

<br>

