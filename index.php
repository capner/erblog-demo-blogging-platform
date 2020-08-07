<?php
ob_start();
$starttime= microtime(true);
define('MyConst', TRUE);
require_once("setting.php");


$canonical_domain = 'https://www.pinterduit.com';
$robots = 0 ;
$sidebar = 'on';
$url_label = '';
$url_search = ''; 
$url_author ='';  
$canonical='<link rel="canonical" href="'.$canonical_domain.'" />';
$unreadinbox = '0';
$unreadlog = '0' ;



if (isset($_COOKIE['account_u'])){
$sql=mysql_query("SELECT COUNT(id) as unreadlog FROM log where author = '$my_u' and readed = '0' ");
while ($row=mysql_fetch_array($sql)) {
$unreadlog = $row['unreadlog'];
};


if ($my_role == 'admin'){
$create_group = '

 <li class="nav-item"> <a href="/index.php?page=group-editor&action=new" rel="">'.translate("Buat Kategori | Create New Category ").' </a></li>
  <li class="nav-item"><a href="/index.php?page=admin" rel="">Admin</a></li>
  <li class="nav-item"><a href="/index.php?page=log-click" rel="">Log Click</a></li>
  

';
}else {
$create_group ='';	
};




$query = mysql_query("select count(id) as totalpublishedpost from datapost where author = '$my_u' and status = 'publish' ");
while($row = mysql_fetch_array($query)){ 
$my_total_published_post = htmlspecialchars($row['totalpublishedpost']);

}

$navbar_menu = '

'.$create_group.'
<li class="nav-item"><a href="/index.php?page=notification" rel="noindex nofollow">'.translate("Notif | Notification").' ('.$unreadlog.')</a></li>
<li class="nav-item"><a href="/index.php?page=post-editor&action=new">'.translate("Post Baru | Create New Post").'</a></li>
<li class="nav-item"><a href="/index.php?page=campaign-editor&action=new" rel="">'.translate("Iklan Baru | Create New Campaign").'</a></li>
<li class="nav-item"><a href="/index.php?page=deposit" rel="">Finance</a> </li>
<li class="nav-item"><a href="/index.php?page=profil" rel="">Profile</a> </li>
<li class="nav-item"><a href="/logout.php" rel="">Logout</a></li>
';
$login_status = '<a href="/"><b>'. $my_name .'</b>  <span style="color:green;">'.number_format($my_ballance,2).'$</span> </a>';

$stats = '


';
$navbar_brand = '<a href="index.php?author='.$my_u.'" class="navbar-brand" >'.$my_name.'</a>';
} else {

$navbar_menu = '
 <a href="index.php?page=login" rel="">Masuk Atau Buat Akun</a>
';
$login_status='<a href="/index.php?page=login" >Masuk / Buat Akun</a>';
$navbar_brand = '<a href="/" rel="" class="navbar-brand">Kuceki</a>';  

$stats = '';
}

include 'route.php';

?>
<!DOCTYPE html>
<html lang="<?php echo $datapost_language; ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<title><?php echo  $title; ?></title>
<meta name="title" content="<?php echo  $title; ?>">
<meta name="description" content="<?php echo $desc; ?>">
<meta name="keywords" content="<?php echo $desc; ?>">
<meta http-equiv="content-language" content="<?php echo $datapost_language; ?>">
<meta property="og:type"  content="website" />
<meta property="og:title" content="<?php echo  $title; ?>"/>
<meta property="og:image" content="<?php echo $meta_image;?>"/>
<meta property="og:description" content="<?php echo $desc; ?>"/>
<link rel="icon" type="image/png" href="/favicon.png" />
<meta name="google-site-verification" content="j5k8MikIu0_xisze_iffzoFFSDCb4wBfocSlC7ZrGBU" />
<meta name="google-site-verification" content="T_4NY9eRxZtGzHRBs2Q8_k9Q5PA5jtOXuY_iGlGBO3Q" />
<meta name="yandex-verification" content="2522b343ee5d69e2" />
<meta name="yandex-verification" content="f88cf11c716c19fa" />
<meta name="msvalidate.01" content="EBC0D4B048C47C42CF7E7042C0A05AF9" />
<meta name='dmca-site-verification' content='QXVoU3Ava2NtYnBYcy9ZV2lGZFVqTUZQMEFIRC9UU2h5d3hzay9DN09pUT01' />
<meta name="coinzilla" content="ee566285e3d096ab12c4507ff81d6626" />
<meta name="maValidation" content="d60260d8db7da79be371c80926da4821" />
<meta name="adbit-site-verification" content="ba72a2fef33b4fa7be19cc7306239c776d46ab51665871cf94ce2c41ff96a9c8" />
<meta name="exoclick-site-verification" content="a67c67740d4ede3b7111a125fa48c39e">
<meta name='dmca-site-verification' content='UHhCUnY1MmZkTjRpYkk5QTV5S3NCUT090' />
<link rel="alternate" href="https://www.pinterduit.com" hreflang="x-default" />
<link rel="alternate" type="application/rss+xml" title="RSS Feed for Pinterduit.com" href="/rss.php" />
<script src="/vendor/jquery/jquery.min.js"></script>

<?php
echo $canonical ;

if ($robots == 1 ) {
echo '
<meta name="robots" content="index follow" />';	
} else {
echo '
<meta name="robots" content="noindex" />';	
}




?>

<style>


#thumbnail{
float:left;
margin:5px;
overflow:hidden;
}

#cover{ position:fixed; top:0px; right:0px; width:100%; height:100%; background-color:white; background-repeat:no-repeat; background-position:center; z-index:10000000; opacity: 1; filter: alpha(opacity=1); /* For IE8 and earlier */ }

.nav-item{
padding:5px;
color:white;

}

.nav-item a{

color:white;
}


</style>


  </head>
	<body>  

<?php
if ( $_SERVER['SERVER_NAME'] !== 'localhost'){
echo '

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112843809-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "UA-112843809-4");
</script>

';	
}
?>

<!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/">Pinterduit.com</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <?php echo $navbar_menu; ?>
        </ul>
      </div>
    </div>
  </nav>

<!-- Page Content -->
  <div class="container">
<br>
<br>
<!--
 <div class="alert alert-success" role="alert"> 
 <h4 class="alert-heading">Notice !</h4> 
 <p> Join Our New Whatsapp Group
 <a href="https://chat.whatsapp.com/HuVwMjwWTxtG4EoBRM1AZX
" rel="nofollow noindex sponsored" target="blank">Group Whatsapp</a>
 </p> 
 </div>
 -->
<br>
Language : <?php echo $language; ?>
<br>
<a href="/?language=en" >English</a> - <a href="/?language=id" >Bahasa Indonesia</a>
<br>
<br>
Categories: 
<?php

$query = mysql_query("SELECT * FROM datagroup order by title asc ");

while($row = mysql_fetch_array($query)){ 

$datagroup_timestamp = htmlspecialchars($row['timestamp']);

$datagroup_title = htmlspecialchars($row['title']);


$datagroup_author = htmlspecialchars($row['author']);

$datagroup_post = htmlspecialchars($row['post']);

$datagroup_u = htmlspecialchars($row['u']);

$datagroup_permalink = htmlspecialchars($row['permalink']);

$datagroup_follower= htmlspecialchars($row['follower']);



echo '
<a href="index.php?page=group&u='.$datagroup_u.'">'.$datagroup_title.'</a> -
';

}

?>
<br>
<br>

<?php
if (!isset($_COOKIE['account_u'])){
?>
<div class="row">
<div class="col-md-12">
<h2><?php echo translate("Mau pasang iklan atau hasilkan uang dengan berkontribusi menulis konten di situs ini ? Buat akun sekarang | Want To Advertise Or Make Money By Contributing On This Site ? Sign Up Right Now !"); ?></h2>
<a href="index.php?page=login" ><button type="submit" name = "submit" class="btn btn-success "><?php echo translate("Masuk / Buat Akun | Login / Sign Up"); ?></button></a>
</div>
</div>

<?php
}
?>
<br>
<br>
<div class="row">

      <!-- Post Content Column -->
      <div class="col-md-8">


<?php


if (isset($_COOKIE['account_u'])){
$query = mysql_query("update account set online = 'online' where u = '$my_u' ");

$query = mysql_query("select count(id) as totalip from log_ip ");
while($row = mysql_fetch_array($query)){ 
$total_ip = htmlspecialchars($row['totalip']);
}




$query = mysql_query("select count(id) as totalpending from deposit where status = 'pending' ");
while($row = mysql_fetch_array($query)){ 
$total_pending = htmlspecialchars($row['totalpending']);

}


$query_moderation = mysql_query("select count(id) as pending_post from datapost where status = 'pending' ");
while($row = mysql_fetch_array($query_moderation)){ 
$pending_post = htmlspecialchars($row['pending_post']);
}




$query = mysql_query("select count(id) as my_pending_post from datapost where status = 'pending' and author = '$my_u' ");
while($row = mysql_fetch_array($query)){ 
$my_pending_post = htmlspecialchars($row['my_pending_post']);

}
$my_pub_click++;

echo '
<br>
<h4>'.$my_name .'</h4>
<br>
'.translate("Saldo $. | Ballance $").' '.number_format($my_ballance,2) .' 
<br>
'.translate("Penghasilan $. | Revenue $").' '. number_format($my_pub_earning,2).' 
<br>
 '.translate("Tayangan | Impression ").''.number_format($my_pub_impression) .' 
<br>
eCPM $ ' .number_format(($my_pub_earning / $my_pub_impression) * 1000,2).' 
<br>
Total Post '.number_format($my_total_published_post).'
<br>
My Pending Post '.$my_pending_post.'
<br>
Monetize : '.$my_status.'
<br>
';
?>


<?php


if ($my_role == 'admin'){

echo '
<br>
<br>
<br>
Pending Post : '.number_format($pending_post) .' (';
$query = mysql_query("SELECT  DISTINCT language from datapost where status = 'pending' ");
while($row = mysql_fetch_array($query)){ 
$langpending = htmlspecialchars($row['language']);
echo $langpending .', ';
}

echo ')
<br>
Pending Finance '.number_format($total_pending) .'
<br>
All Impression '.number_format($total_ip) .' 
<br>
';


}

echo '
<a href="/index.php?page=notification" rel="noindex nofollow"><span class="label label-success">'.translate("Notifikasi | Notification").' ('.$unreadlog.')</span></a> -
<a href="/index.php?page=publisher&u='.$my_u.'" rel=""><span class="label label-success">'.translate("Postingan Saya | My Post").'</span></a> -
<a href="/index.php?page=campaign" rel=""><span class="label label-success">'.translate("Iklan Saya | My Campaign").'</span></a> -
<a href="https://cse.google.com/cse?cx=007344866558814912770:pvun-cd0pgk" rel="" target="blank"><span class="label label-success">'.translate("Pencarian | Search").'</span></a> -
<a href="/index.php?page=report" rel=""><span class="label label-success">Analytic</span></a> -
<a href="/index.php?page=affiliate" rel=""><span class="label label-success">Affiliate</span></a> -

';

} else {

echo '

';

}

?>




<br>

<br>

<?php

echo $breadcrumb;
include  $page ;
?>



<?php
//echo $serverlocation.$_SESSION['refresh'];
if ($_SERVER['SERVER_NAME'] !== 'localhost' && $_SESSION['refresh'] < 200){

include 'ads-code.php';
} 
?>



<!-- end col lg 8 -->
</div>

<!-- Sidebar Widgets Column -->
      <div class="col-md-4">
<?php

include  'sidebar.php' ;


//echo $serverlocation.$_SESSION['refresh'];
if ($_SERVER['SERVER_NAME'] !== 'localhost' && $_SESSION['refresh'] < 200 ){

include 'ads-code1.php';
} 


?>

<?php

$endtime = microtime(true);
$duration = $endtime - $starttime;

if ($isbot == 0){
$botyn = 'no';
} else {
$botyn = 'yes';
}

/*
echo '
<div id="well">
<br><span class="abu-kecil">code execution :'.$duration. ' seconds
<br> 
uid : '.$uid.'
<br>
useragent : '.$useragent.'
<br>
bot detected : '.$botyn.'
<br>
referer : '.$referer.'
</span>
</well>
';
*/


?>



<?php

if ($serverlocation !== 'local' && $_SESSION['refresh'] > 3 ) {

?>


 
<?php
 
 };
 
 ?>
 

<br>
<!-- end md 4 -->
</div>
<!-- row -->
</div>
<!-- end container -->
</div>
 <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
    
<?php
include 'footer.php'; ?>
Sponsor
<br>
<br>

    </div>
    
    <!-- /.container -->
  </footer>


<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="/styles.css" />
<link href="/css/blog-post.css" rel="stylesheet">
<link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


<script>
/*
$(document).ready(function(){



function lazyload(){

$.getScript("/vendor/bootstrap/js/bootstrap.bundle.min.js");
$('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/styles.css') ); 
$('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/css/blog-post.css') ); 
$('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/vendor/bootstrap/css/bootstrap.min.css') ); 


$('#cover').hide();
}

window.setTimeout(lazyload,5000);


});


*/
</script>
</body>
</html>