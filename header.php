<?php
ob_start();
header('Content-type: text/html; charset=utf-8');
require_once("setting.php");
function create_url($string, $ext=''){     
        $replace = '-';         
        $string = strtolower($string);     
        //replace / and . with white space     
        $string = preg_replace("/[\/\.]/", " ", $string);     
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);     
        //remove multiple dashes or whitespaces     
        $string = preg_replace("/[\s-]+/", " ", $string);     
        //convert whitespaces and underscore to $replace     
        $string = preg_replace("/[\s_]/", $replace, $string);     
        //limit the slug size     
        $string = substr($string, 0, 100);     
        //text is generated     
        return ($ext) ? $string.$ext : $string; 
    }     
$sql=mysql_query("SELECT COUNT(*) as unread FROM inbox where penerima = '$username' and `read` = '0' ");
while ($row=mysql_fetch_array($sql)) {
$unread = $row['unread'];
};
$sql=mysql_query("SELECT COUNT(*) as log FROM log where author = '$username' and `read` = '0' ");
while ($row=mysql_fetch_array($sql)) {
$log = $row['log'];
};
$sql=mysql_query("SELECT COUNT(*) as tanya FROM forum where author = '$username' ");
while ($row=mysql_fetch_array($sql)) {
$tanya = $row['tanya'];
};
$sql=mysql_query("SELECT COUNT(*) as jawab FROM forumdetail where author = '$username' ");
while ($row=mysql_fetch_array($sql)) {
$jawab = $row['jawab'];
};
if (isset($_COOKIE['username'])){
$navbarform = '
<li><a href="inbox.php" rel="noindex,nofollow"><span class="glyphicon glyphicon-envelope"></span> Inbox ('.$unread.') </a> </li>
<li><a href="notification.php" rel="noindex,nofollow"> <span class="glyphicon glyphicon-bell"> </span>Pemberitahuan('.$log.')</a></li>
<li><a href="index.php?author='.$username.'" rel="noindex,nofollow"> <span class="glyphicon glyphicon-bell"> </span>Pertanyaanku('.$tanya.')</a></li>
';
$menu2 = "
<li><a href='logout.php' style='color:'> Logout</a></li>
<li><a href='profil.php' style='color:'> Setting</a></li>";
$statusform = "
Masuk sebagai : 
<span style='color:green'><b>".$username."</b></span>, 
jabatan : 
<span style='color:green'><b>".$role."</b></span> ,
total poin : 
<span style='color:green'><b>".$poin ."</b></span>
";
$menu_footer = '
<a href="profil.php">Setting</a> &nbsp';

} else {
$menu2 = "
<li class='active'><a href='login.php?page=login'> Login</a></li> ";	
$menu_footer = "";
$navbarform = '
';	
$statusform = '';
  
} 
if(isset($_GET['u'])) {
$u = mysql_real_escape_string($_GET['u']);
$query=mysql_query("select * from forum where u = '$u' ");
while($row=mysql_fetch_array($query)){
$title = htmlspecialchars($row['title']);	
$desc = htmlspecialchars(substr($row['text'],0,100));
}
} else if (isset($_GET['label'])){
$label = mysql_real_escape_string($_GET['label']);	
$query=mysql_query("select * from label where label = '$label' ");
while($row=mysql_fetch_array($query)){
$title = htmlspecialchars($row['label']);	
$desc = htmlspecialchars(substr($row['desc'],0,100));
}
$pagelabel = '&label='.$label ;		
}else if (isset($_GET['page'])){
$page = $_GET['page'];
if($page == 'about'){
$title = 'hacker playground';
$desc = 'website tanya jawab terbesar di indonesia dengan berbagai topik umum, sains dan teknologi, bisnis dan keuangan, komputer dan internet ';
	
} else if ($page == 'faq') {
$title = 'FAQ';
$desc = 'pertanyaan yang sering diajukan';
	
} else if ($page == 'rules') {
$title = 'Rules';
$desc = 'peraturan tata cara mengajukan pertanyaan dan jawaban yang baik';
	
} else if ($page == 'disclaimer') {
$title = 'Disclaimer';
$desc = 'semua posting menjadi tanggung jawab user yang admin lakukan hanyalah melakukan penindakan setelah ada laporan abuse';
	
} else if ($page == 'privacy') {
$title = 'Privacy';
$desc = 'website ini memakai cookie dan layanan pihak ketiga seperti google analytic untuk memantau traffic website
mungkin IP dan lokasi anda akan terekam';
	
} else if ($page == 'sitemap') {
$title = 'Sitemap';
$desc = 'halaman untuk bot search engine dan webmaset';
	
} else if ($page == 'login') {
$title = 'Login';
$desc = 'otomatis mterdaftar saat pertama kali login';
	
} else if ($page == 'chat') {
$title = 'Chat';
$desc = 'chat bebas tanpa perlu terikat rules pertanyaan dan jawaban';
	
} else if ($page == 'inbox') {
$title = 'Inbox';
$desc = 'berikirim pesan pribadi antar pengguna';
	
}
} else {
$title = 'hacker playground';
$desc = 'website tanya jawab terbesar di indonesia dengan berbagai topik umum, sains dan teknologi, bisnis dan keuangan, komputer dan internet ';
$pagelabel = '';
}
$filter = 'forum ';
if (isset($_GET['label'])) {
$filter = "forum where label like '%".$label."%'";
}
if (isset($_GET['search'])) {
$search = htmlspecialchars($_GET['search']);
$filter = "forum where title like '%".$search."%' or text like '%".$search."%' or author like '%".$search."%' or label like '%".$search."%'";
}
if(isset($_COOKIE['username'])){
$new_forum = '<a href="new-forum.php">             
<button type="submit" name = "submit" class="btn btn-success">ajukan pertanyaan             
</button></a> ';	
} else {
$new_forum = '<a href="login.php">             
<button type="submit" name = "submit" class="btn btn-success">ajukan pertanyaan            
</button></a>';	
}
if (isset($_GET['author'])) {
$filter = "forum where author = '".mysql_real_escape_string($_GET['author'])."'";
}
if (!isset($_COOKIE['tema'])){
$_COOKIE['tema'] = 'putih.css';
}
if ($_POST['tema']) {
$temabaru = $_POST['tema'] ;
setcookie('tema',$temabaru,time() + (10 * 365 * 24 * 60 * 60) );	
} 
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<meta name="title" content="<?php echo $title; ?>">
<meta name="description" content="<?php echo $desc; ?>">
<meta name="keywords" content="SEO source code file promosi deface ddos sql injection game download html php english gaming anime movie programmer coding css javascript python visualbasic c++ malware adsense hosting server hardware software internet marketing making money  ">
<link rel="icon" type="image/png" href="favicon.png" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<meta name="google-site-verification" content="_W2JvZW1sh6d_VZ9o-L7bHjqRJ-HTV63azTMbnpO6eE" />	
<meta name="yandex-verification" content="cf97942322233729" />
<!--
<link rel="stylesheet" href="../hpg/css/bootstrap.css">
<script src="../hpg/js/jquery.js"></script>
<script src="../hpg/js/bootstrap.js"></script>
-->
<link rel="stylesheet" href="<?php echo $_COOKIE['tema']; ?>">

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-7181530105511559",
enable_page_level_ads: true
});
</script>

</head>
<body >
<div class='container fluid'>
<div class="row";>
<div class="col-md-12"> 
<nav class="navbar navbar-inverse navbar-fixed-top " role="navigation">
<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="index.php">HACKER PLAYGROUND</a>
</div>
<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav">
<li><a href="chat.php?page=chat" rel="nofollow"><span class="glyphicon glyphicon-comment"></span> Chat </a> </li>
<?php echo $navbarform; ?>
</ul>
<!-- ORIGINAL SEARCH FORM    
<div class="col-sm-3 col-md-3">
<form class="navbar-form" role="search">
<div class="input-group">
<input type="text" class="form-control" placeholder="Search" name="q">
<div class="input-group-btn">
<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
</div>
</div>
</form>
</div>
-->
<div class="col-sm-6 col-md-3" style="float: right;">
<ul class="nav navbar-nav navbar-right">
<li>
<!--
<form class="navbar-form" role="search" action="index.php">
<div class="input-group">
<input type="text" class="form-control" placeholder="Search" name="search">
<div class="input-group-btn">
<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
</div>
</div>
</form>
-->
<div itemscope itemtype="http://schema.org/WebSite">
<meta itemprop="url" content="https://www.hacker-playground.com/"/>
<form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" class="navbar-form" role="search" action="index.php" method="get">
<div class="input-group">    
<meta itemprop="target" content="http://hacker-playground.com/index.php?search={search}"/>
<input itemprop="query-input" type="text" name="search" class="form-control" placeholder="Search"  required/>
<div class="input-group-btn">
<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
</div>
</div>
</form>
</div>
</li>
</ul>
</div>
</div><!-- /.navbar-collapse -->
</nav>
</div>
</div>
<div class="row";>
<div class="col-md-12">
<?php echo $statusform ; ?>	
<hr>
</div>
</div> 
<div class="row";>     
<div class="col-md-12"> 


<br>  
<?php echo $new_forum;?>           
<br>
<hr>
<?php
$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
foreach($crumbs as $crumb){
    echo ucfirst(str_replace(array(".php","_"),array(""," "),$crumb) . ' ');
}
?>
<hr> 
<br>	
</div>
</div>