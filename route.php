<?php

$web_title = 'Pinterduit.com | Freelance Writer Platform';
$web_desc = 'Want To Advertise Or Make Money By Contributing On This Site ? Sign Up Right Now !' ;
$meta_image= 'https://www.pinterduit.com/favicon.png';
if (isset($_GET['page'])){
$page = $_GET['page'];
if($page == 'about'){
$page = 'about.php';
$title = 'About' ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=about">About</a> ';	
} else if ($page == 'campaign') {
$page = "campaign.php";
$canonical = '';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> ';
} else if ($page == 'login') {
$page = "login.php";
$desc = 'create account and start discuss';
$canonical = '<link rel="canonical" href="'.$canonical_domain.'/?page=login" />';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=login">Login</a> ';
} else if ($page == 'campaign-editor') {
$page = 'campaign-editor.php';
$title = 'Campaign Editor';
$desc = 'campaign editor';
$canonical = '<link rel="canonical" href="'.$canonical_domain.'/?page=login" />';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a>';
} else if ($page == 'shout') {
$ads_banner = 'off';
$page = 'shout.php';
$title = 'Shout Of Trending And Hot Topics';
$desc = 'Find or share what trending now quickly';
$canonical = '<link rel="canonical" href="'.$canonical_domain.'/?page=shout" />';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=shout">Shout Of Trending And Hot Topics </a> ';
} else if ($page == 'shout-editor') {
$ads_banner = 'off';
$page = 'shout-editor.php';
$title = 'Shout Editor';
$desc = 'shout your voice freely';
$canonical = '<link rel="canonical" href="'.$canonical_domain.'/?page=shout" />';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=shout-editor">Shout Editor</a> ';
} else if ($page == 'affiliate') {
$ads_banner = 'off';
$page = 'affiliate.php';
$title = 'Affiliate';
$desc = 'Earn commision by referring othrr';
$canonical = '<link rel="canonical" href="'.$canonical_domain.'/?page=affiliate" />';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=affiliate">Affiliate </a> ';
} else if ($page == 'report') {
$ads_banner = 'off';
$page = 'report.php';
$title = 'Analytic';
$desc = 'analytic';
$canonical = '<link rel="canonical" href="'.$canonical_domain.'/?page=report" />';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=report">Analytic</a> ';
} else if ($page == 'notification') {
$page = 'notification.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=notification">Notification</a> ';	
} else if ($page == 'group-editor') {
$page = 'group-editor.php';
$title = 'group editor' ;
$robots = 0 ;
$desc = 'create, edit, delete, group';
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=group-editor">Topic Editor</a> ';	
} else if ($page == 'post-editor') {
$page = 'post-editor.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=post-editor">Post editor</a> ';	
} else if ($page == 'pub-report') {
$page = 'pub-report.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=publisher">Publisher</a> » <a href="/index.php?page=pub-report">Earning Report</a> ';	
} else if ($page == 'ads-report') {
$page = 'ads-report.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=advertiser">Advertiser</a> » <a href="/index.php?page=ads-report">Spending Report</a> ';	
}else if ($page == 'comment-editor') {
$page = 'comment-editor.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=comment-editor">Comment editor</a> ';	
} else if ($page == 'publisher') {
$page = 'publisher.php';

if (isset($_GET['u'])){
$account_u = mysql_real_escape_string($_GET['u']);
} else {
echo 'not found';
die;	
}

$query3 = mysql_query("SELECT * FROM  account where u = '$account_u' ");
while($row = mysql_fetch_assoc($query3)){
$name = htmlspecialchars($row['name']);
$datapost_author_role = htmlspecialchars($row['role']);
$datapost_author_u = htmlspecialchars($row['u']);
$datapost_author_description = htmlspecialchars($row['description']);
$alltime_view = htmlspecialchars($row['pub_alltime_view']);
$picture = htmlspecialchars($row['picture']);
$alltime_views = htmlspecialchars($row['pub_alltime_view']);
$permalink = 'profile-of-'.create_url($name);
}
$title = 'Profile of '.$name .' - follow me on '.$canonical_domain.'';
$desc = $datapost_author_description;
$meta_image = $picture;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=publisher&u='.$datapost_author_u.'">'.$name.'</a> ';	 $canonical = '<link rel="canonical" href="'.$canonical_domain.'/index.php?'.$permalink.'&page=publisher&u='.$account_u.'" />';

} else if ($page == 'advertiser') {
$page = 'advertiser.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=advertiser">Advertiser</a> ';	
} else if ($page == 'user') {
$page = 'user.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=user">User</a> ';	
}else if ($page == 'group') {
$page = 'group.php';
//membaca datagroup
$u = mysql_real_escape_string($_GET['u']);
$query =  mysql_query("SELECT * FROM datagroup where u = '$u' ");
$hasil = mysql_num_rows($query);
if ($hasil <> 0 ) {
$query=mysql_query("select * from datagroup where u = '$u' ");
while($row=mysql_fetch_array($query)){
$title = htmlspecialchars($row['title']);	
$desc = $title;
$datagroup_permalink = create_url($row['title']);
$metaimage = 'logo.png';	
$canonical = '<link rel="canonical" href="'.$canonical_domain.'/index.php?page=group&title='.$datagroup_permalink.'&u='.$u.'" />';
$robots = 0 ;
}
}
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=group-list">Reader</a> » <a href="/index.php?'.$datagroup_permalink.'&page=group&u='.$u.'">'.$title.'</a>';	
} else if ($page == 'post') {
$page = 'post.php';
//membaca datapost
$permalink = mysql_real_escape_string($_GET['permalink']);
$query =  mysql_query("SELECT * FROM datapost where permalink = '$permalink' ");
$hasil = mysql_num_rows($query);
if ($hasil > 0 ) {
$query=mysql_query("select * from datapost where permalink = '$permalink' ");
while($row=mysql_fetch_array($query)){
$title = htmlspecialchars($row['title']);	
$desc = htmlspecialchars(substr($row['text'],0,100)) ;
$permalink = htmlspecialchars($row['permalink']);	
$datapost_language = htmlspecialchars($row['language']);	
$metaimage = '';
$canonical = '
<link rel="canonical" href="'.$canonical_domain.'/'.$permalink.'.html" />
';
$datapost_parent = htmlspecialchars($row['parent']);
$query32 = mysql_query("select * from datagroup where u = '$datapost_parent' ");
while($row=mysql_fetch_array($query32)){
$datagroup_title = htmlspecialchars($row['title']);
$datagroup_u = htmlspecialchars($row['u']);
$datagroup_permalink = create_url($row['title']);


}
 $robots = 1;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=group&u='.$datagroup_u.'">'.$datagroup_title.'</a>


';		
} 
} 

} else if ($page == 'profil') {
$page = 'profil.php';
$title = 'Setting';
$desc = 'setting profil';
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=profil">Setting</a> ';	
} else if ($page == 'home') {
$page = 'what-new.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a>';		
}  else if ($page == 'deposit') {
$page = 'deposit.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=deposit">Deposit / Withdraw </a>';		
}  else if ($page == 'deposit-editor') {
$page = 'deposit-editor.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=deposit">Deposit / Withdraw </a> » <a href="/index.php?page=deposit-editor">Deposit Editor</a>';		
} else if ($page == 'captcha') {
$page = 'captcha.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a>';		
} else if ($page == 'log-click') {
$page = 'log-click.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a>';		
} else if ($page == 'group-list') {
$page = 'group-list.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=group-list">Reader </a>';	
} else if ($page == 'search') {
$page = 'search.php';
$title = 'search result' ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=search">Search</a> ';		
} else if ($page == 'admin-editor') {
$page = 'admin-editor.php';
$title = 'search result' ;
$desc = $web_desc;
$robots = 0;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=admin">Admin</a> » <a href="/index.php?page=admin-editor">Admin Editor</a>';		
}else if ($page == 'feed') {
$page = 'feed.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a>';		
} else if ($page == 'admin') {
$page = 'admin.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=admin">Admin</a>';		
} else if ($page == 'changepassword') {
$page = 'change-password.php';
$title = $web_title ;
$desc = $web_desc;
$robots = 0 ;
$breadcrumb = '<a href="/">Home</a> » <a href="/index.php?page=changepassword">Change Password</a>';		
} 
} else {
$page = 'what-new.php';	
$title = $web_title; ;
$desc = $web_desc;
$datapost_language = 'en';
$robots = 1;

$breadcrumb = '<a href="/">Home</a>';
}
if (isset($_GET['next']) || isset($_GET['search']) || isset($_GET['keyword']) ){
$robots = 0;	
header("HTTP/1.1 404 Not Found");
}
?>