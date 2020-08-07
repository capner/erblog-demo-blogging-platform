<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}

if(!isset($_COOKIE['account_u'])){
echo 'you need to login first';
die;
}
?>

<br>
<br>
<a href="/?page=deposit-editor&action=new"><button name = 'submit' class="btn btn-primary">Create New Deposit / Withdraw </button></a>
<br>
<br>
<br>
<?php

$url_parameter = 'page=deposit';
if ($my_role == 'admin'){
	$filter = "deposit order by id desc ";
	
} else {
	$filter = "deposit where author = '$my_u' order by id desc ";
}

$per_page= '20';
$page_query = mysql_query("SELECT COUNT(*) FROM deposit  ");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  
$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM  $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil <> 0 ) {

while($row = mysql_fetch_array($query)){ 
$deposit_id = htmlspecialchars($row['id']);
$deposit_timestamp = htmlspecialchars($row['timestamp']);
$deposit_author = htmlspecialchars($row['author']);
$deposit_ammount = htmlspecialchars($row['ammount']);
$deposit_date = htmlspecialchars($row['date']);
$deposit_type = htmlspecialchars($row['type']);
$deposit_note = htmlspecialchars($row['note']);
$deposit_status = htmlspecialchars($row['status']);
$deposit_u = htmlspecialchars($row['u']);

$query457 = mysql_query("SELECT * FROM  account where u = '$deposit_author' ");
while($row = mysql_fetch_assoc($query457)){
$account_name = htmlspecialchars($row['name']);
$account_paypal = htmlspecialchars($row['paypal']);
}



echo '
 '.$deposit_timestamp.'
<br>
User :'.$account_name.' 
<br>
Type : '.$deposit_type.' 
<br>
Date : '.$deposit_date.'
<br>
Ammount : $. '. number_format($deposit_ammount).'
<br>
Payment : '. $account_paypal.'
<br>
Note : '.$deposit_note.'
<br>
Status : '.$deposit_status.'
<br>';
if ($my_role == 'admin' && $deposit_status == 'pengajuan'){
echo '<a href="index.php?page=deposit-editor&action=edit&u='.$deposit_u.'" >Edit</a>';	
} 

echo '
<br><br>
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

}  else {
echo 'no record found';	
}

?>