<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
?>

<form action="" method="GET"  role="search" target="_top">
<input class="form-control" name="page" placeholder="name" type="hidden" value="admin">
<div class="input-group">
<input class="form-control" name="keyword" placeholder="name" type="text">
</div>
<br>
<button class="btn btn-primary" >account search</button>
</form>

<div class="hitam-kecil">
<?php
if ($my_role !== 'admin' ){
echo 'restricted area';
exit;	
}
setcookie('dst',$_SERVER['REQUEST_URI'],time() + (10 * 365 * 24 * 60 * 60));
$query = mysql_query("select sum(ballance) as sum_ballance from account");
while($row = mysql_fetch_array($query)){
echo '<br><br>Total Kas Rp. <span class="redbold"> '.number_format($row['sum_ballance']).'</span> <br><br><br>';	
}

$url_parameter = 'page=admin';
$filter = "account order by ballance desc ";
if (isset($_GET['keyword'])) {
$search = mysql_real_escape_string($_GET['keyword']);
$url_parameter = $url_parameter.'&keyword='.$search;
//$searchquery = str_replace(' ',' | ',$search);
echo '
<br>Search result for keyword :<span style="color:green">'.htmlspecialchars($search) .'</span><br>
' ;
$filter = "account where name like '%$search%' order by name asc";
//$url_parameter = $url_parameter.'&keyword='.$search;
$search = strtolower($search);
//$query = mysql_query("insert into search (keyword) values ('$search')");
}

$per_page= '20';
$page_query = mysql_query("SELECT COUNT(*) FROM account  ");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  
$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM  $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil <> 0 ) {

while($row = mysql_fetch_array($query)){ 
$account_name = htmlspecialchars($row['name']);
$account_pub_earning = htmlspecialchars($row['pub_earning']);
$account_ballance = htmlspecialchars($row['ballance']);
$account_username = htmlspecialchars($row['username']);
$account_paypal = htmlspecialchars($row['paypal']);
$account_whatsapp = htmlspecialchars($row['whatsapp']);
$account_u = htmlspecialchars($row['u']);
$account_adv_spending = htmlspecialchars($row['adv_spending']);
$account_pub_click = htmlspecialchars($row['pub_click'])+0.0001;
$account_adv_click = htmlspecialchars($row['adv_click'])+0.0001;
$account_pub_impression = htmlspecialchars($row['pub_impression'])+0.0001;
$account_adv_impression = htmlspecialchars($row['adv_impression'])+1.0001;
$account_ads_status = htmlspecialchars($row['ads_status']);
$account_ads_cpc = htmlspecialchars($row['ads_cpc']);



echo '
<div class="post-list">
<a href="index.php?page=publisher&u='.$account_u.'" target="blank">'.$account_name.'</a>
<br>
Ballance $ '.number_format($account_ballance,4).' 
<br>
Email '.$account_username.' 
<br>
Payment : '.$account_paypal.' </li>
<br>
Whatsapp: '.$account_whatsapp.'
<br>
Revenue $ '. number_format($account_pub_earning,4).' 
<br>
Impression '.number_format($account_pub_impression) .' 
<br>
eCPM Rp. ' .number_format(($account_pub_earning / $account_pub_impression) * 1000,4).' 
<br>
';


if($my_role == 'admin') {
echo '
 » [<a href="/index.php?page=admin-editor&u='.$account_u.'" target="blank">edit</a>]';

}

 echo '
 </div>
 <br><br><br>
 ';
}





?>

</div>
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

};

?>
