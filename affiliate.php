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
<h3>Affiliate </h3>
Affiliate Earning $ <?php echo $my_af_earning; ?>
<br>
<br>
Get 5% affiliate reward from your referral<br>
<br>
<div class="form-group">			                              
<label for="codename">Your Affiliate Link:                              
</label>			                              
<textarea class="form-control" rows="5">
http://pinterduit.com/?page=login&ref=<?php echo $my_u ; ?>
</textarea>                          
</div>			
<br>
<h3>User Under Your Affiliate </h3>


<?php

setcookie('dst',$_SERVER['REQUEST_URI'],time() + (10 * 365 * 24 * 60 * 60));

$url_parameter = 'page=report';
if ($my_role == 'admin'){
	$filter = "account where upline = '$my_u' order by pub_earning desc ";
}else{
	$filter = "account where upline = '$my_u'  order by pub_earning desc";
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

$per_page= '20';
$page_query = mysql_query("SELECT COUNT(id) FROM $filter  ");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  
$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM  $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil !== 0 ) {

while($row = mysql_fetch_array($query)){ 
$downline_name = htmlspecialchars($row['name']);
$downline_earning = htmlspecialchars($row['pub_earning']);





echo '
 » '.$downline_name.' : $ '.(5/100)*$downline_earning.'
 <br>
';

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

