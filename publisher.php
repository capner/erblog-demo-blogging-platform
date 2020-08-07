<?php
if(!defined('MyConst')) {
die('Direct access not permitted');
}
if (isset($_GET['u'])){
$account_u = mysql_real_escape_string($_GET['u']);
} else {
echo 'Tidak Ditemukan';
die;	
}

$query3 = mysql_query("SELECT * FROM  account where u = '$account_u' ");
while($row = mysql_fetch_assoc($query3)){
$name = htmlspecialchars($row['name']);
$datapost_author_role = htmlspecialchars($row['role']);
$datapost_author_u = htmlspecialchars($row['u']);
$datapost_author_description = htmlspecialchars($row['description']);
$pub_impression = htmlspecialchars($row['pub_impression']);
$picture = htmlspecialchars($row['picture']);
}



$query=mysql_query("select count(*) as total_published_post from datapost where author = '$account_u' and status = 'publish' "); 
while ($row = mysql_fetch_assoc($query)){

  $total_published_post = $row['total_published_post'];

}



?>
<br>
<br>
<h1><?php echo $name;?></h1>
<?php echo $datapost_author_description;?>
<br>
<span class="abu-kecil">Total Konten Dilihat: <?php echo  number_format($pub_impression); ?>, Total Konten Diterbitkan: <?php echo number_format($total_published_post); ?> ,
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<?php


//jawaban
$url_parameter = '&page=publisher&u='.$account_u;
if ($my_role == 'admin' || $account_u == $my_u){
$filter = "where author = '$account_u' order by id desc";
} else {
$filter = "where author = '$account_u' and status = 'publish' order by id desc ";
}
if (isset($_GET['keyword'])) {
$search = mysql_real_escape_string($_GET['keyword']);
$url_parameter = '&page=publisher&u='.$account_u.'&keyword='.$search;
//$searchquery = str_replace(' ',' | ',$search);
echo '
<br>Hasil Pencarian Dari Katakunci :<span style="color:green">'.htmlspecialchars($search) .'</span><br><br><br>
' ;

if ($my_role == 'admin' || $account_u == $my_u){
$filter = "where title like '%$search%'  and  author = '$account_u'   order by id  desc";
} else {
$filter = "where title like '%$search%'  and  author = '$account_u' and status = 'publish'  order by id  desc ";
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
$query = mysql_query("SELECT * FROM datapost $filter  LIMIT $start, $per_page ");
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
$datapost_status = $row['status'];
$datapost_parent = $row['parent'];
$datapost_view = number_format($row['view']);
$datapost_like = htmlspecialchars($row['likebutton']);
$datapost_dislike = htmlspecialchars($row['dislikebutton']);


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


$query458=mysql_query("SELECT MAX(view) as topview FROM datapost ");
while($row = mysql_fetch_assoc($query458)){ 
$topview = $row['topview'];
}

echo '<b>';

if ($my_role == 'admin' || $account_u == $my_u){
echo '['.$datapost_status.']';
} 

echo '
<a href="/'.$datapost_permalink.'/'.$datapost_u.'.html">'.$datapost_title .'</a> </b>
<br>
<a href="#">'.$datapost_name.'</a> - <a href="/index.php?'.$datagroup_permalink.'&page=group&u='.$datagroup_u.'">'.$datagroup_title.'</a>';
if( $datapost_author == $my_u || $my_role == 'admin' ) {
echo '
[<a href="/index.php?page=post-editor&action=edit&u='.$datapost_u.'">edit</a>]';	
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

} 
?>
<br>
<br>

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