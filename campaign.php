<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}

/*
$query = mysql_query("SELECT * FROM  data_campaign where author = '$my_u' ");
while($row = mysql_fetch_assoc($query)){
$data_campaign_title = htmlspecialchars($row['title']);
$data_campaign_link = htmlspecialchars($row['link']);
$data_campaign_author = htmlspecialchars($row['author']);
$data_campaign_status = htmlspecialchars($row['status']);
$data_campaign_image = htmlspecialchars($row['image']);
$data_campaign_impression = htmlspecialchars($row['impression']);
$data_campaign_click = htmlspecialchars($row['click']);
$data_campaign_spending = htmlspecialchars($row['spending']);
}

*/



?>

<br>
<br>

<form action="/" method="GET"  role="search" target="_top">
<input class="form-control" name="page" placeholder="name" type="hidden" value="campaign">
<div class="input-group">
<input class="form-control" name="keyword" placeholder="campaign title" type="text">
</div>
<br>
<button class="btn btn-primary" >Search</button>
</form>
<br>
<br>
<?php


//jawaban
$url_parameter = '&page=campaign';
if ($my_role == 'admin'){
$filter = " order by id desc";
} else {
$filter = " where author = '$my_u' order by id desc ";
}
if (isset($_GET['keyword'])) {
$search = mysql_real_escape_string($_GET['keyword']);
$url_parameter = '&page=campaign&keyword='.$search;
//$searchquery = str_replace(' ',' | ',$search);
echo '
<br>Hasil Pencarian Dari Katakunci :<span style="color:green">'.htmlspecialchars($search) .'</span><br><br><br>
' ;
if ($my_role == 'admin'){
$filter = " where title like '%$search%'   order by id  desc ";

} else {
$filter = " where title like '%$search%'  and  author = '$my_u'   order by id  desc ";

}

$url_parameter = '&u='.$account_u.'&keyword='.$search;
$search = strtolower($search);
}

$per_page= '20';
$page_query = mysql_query("SELECT COUNT(*) from datapost where  status = 'publish' and author = '$account_u' order by id desc");
$pages = ceil(mysql_result($page_query, 0) / $per_page);
$total_pages = ceil($page_query / $per_page);  

$page = (isset($_GET['next'])) ? (int)$_GET['next'] : 1;
$start = ($page - 1) * $per_page;
$query = mysql_query("SELECT * FROM data_campaign $filter  LIMIT $start, $per_page ");
$hasil = mysql_num_rows($query);
if ($hasil <> 0 ) {
$i = 0 ;
while($row = mysql_fetch_array($query)){ 
$data_campaign_u = htmlspecialchars($row['u']);
$data_campaign_title = htmlspecialchars($row['title']);
$data_campaign_link = htmlspecialchars($row['link']);
$data_campaign_author = htmlspecialchars($row['author']);
$data_campaign_status = htmlspecialchars($row['status']);
$data_campaign_image = htmlspecialchars($row['image']);
$data_campaign_impression = htmlspecialchars($row['impression']);
$data_campaign_click = htmlspecialchars($row['click']);
$data_campaign_spending = htmlspecialchars($row['spending']);
$data_campaign_cpm = htmlspecialchars($row['cpm']);
$data_campaign_language = htmlspecialchars($row['language']);


$query_account = mysql_query("SELECT * FROM account where u = '$data_campaign_author' ");
while($row = mysql_fetch_array($query_account)){ 
$account_name = htmlspecialchars($row['name']);
}

echo '
<img src="'.$data_campaign_image.'" width="50px" ></img>
<br>
User : '.$account_name.'<br>
Title : '.$data_campaign_title.'
<br>
Language : '.$data_campaign_language.'
<br>
Impression : '.$data_campaign_impression.'
<br>
CPM : '.$data_campaign_cpm.'
<br>
Spending : $ '.number_format($data_campaign_spending,2).'
<br>
Status : '.$data_campaign_status.'
<br>
Link : <a href="'.$data_campaign_link.'" target="blank">'.$data_campaign_link.'</a>
<br>
';
if( $data_campaign_author == $my_u || $my_role == 'admin' ) {
echo '
[<a href="index.php?page=campaign-editor&action=edit&u='.$data_campaign_u.'">edit</a>]';	
}
echo '<br><br><br>';

}
}




?>
<br>
<br>
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

<script>
$(document).ready(function() {
$('#follow-button').click(function(){
var u = $("#u").val();
var action = $("#action").val();

	

$.post("processor.php",
    {
		page: "follow-account",
		u:u,
		action:action,
		
	      
    },
    function(data,status){
    if (data == "follow account success"){
     $("#action").val("Unfollow");
     $("#follow-button").html("Unfollow");
     $(".total-follower").html(parseInt($(".total-follower").html())+1);
     } else if (data == "unfollow account success"){
     $("#action").val("Follow");
     $("#follow-button").html("Follow");
      $(".total-follower").html(parseInt($(".total-follower").html())-1);
     }
     
		alert(data);
		});


});

	 
	 });
</script>