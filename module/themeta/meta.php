<?
include_once ("config.php");
include_once 'htinmotion/orm/resources/class.database.php';
include_once 'htinmotion/orm/generated_classes/class.todaytopic.php';
include_once 'htinmotion/orm/adodb5/adodb.inc.php';
include_once 'htinmotion/orm/general/general.php';

$title=SITE_TITLE;
if(matchpage("gamefaces.php") || matchpage("gamefaces_join.php") || matchpage("gamefaces_rule.php"))
{
$title.="- Gamefaces";
$keyword="Gamefaces";
$description="Messi, Katy Perry, David Beckham, DJ Mehah, Ana Ivanovic, Angle Bab, Kaka, Villa…tất cả đều đã 'all in', còn bạn thì sao?
Bạn đam mê thể thao, ca hát, những bước nhảy đường phố hay những mẫu thời trang theo phong cách riêng của mình? Hãy thể hiện niềm đam mê đó lên gương mặt của bạn và cho chúng tôi biết niềm đam mê của bạn bừng cháy thế nào?
Tải ảnh thể hiện gương mặt cháy bỏng đam mê nhất của bạn để có cơ hội nhận được những phần quà thật 'all in' từ nhãn hàng adidas.  ";	
$og_title=	$title;
}
if(matchpage("all24.php") 
|| matchpage("all24_upload.php") 
|| matchpage("all24_rule.php") 
|| matchpage("allmusic.php")
|| matchpage("allfootball.php")
|| matchpage("allskate.php")
|| matchpage("alldance.php")
|| matchpage("allfashion.php")
)
{
$title.="-All24";
$keyword="-All24";
$description="Tham gia All24 do adidas tổ chức ";	
$og_title=	$title;
}
if(matchpage("climacool.php") )
{
$title.="-Colour Mission";
$keyword="-Colour Mission";
$description="Tham gia All24 do adidas tổ chức ";	
$og_title=	$title;	
}

if(matchpage("news.php"))
{
	if($_GET["newsID"])
	{
		$gf=new general();
		$sql="Select todaytopic_title,todaytopic_desc from todaytopic where todaytopic_id=".$_GET["newsID"];
		$tp=$gf->getSQL($sql,0);
		$title.="-".$tp[0]["todaytopic_title"];
		$og_title=$tp[0]["todaytopic_title"];
		$description="".$tp[0]["todaytopic_desc"];
	}
} 
$keyword.="Adidas is all in,adidas";
/*
if(matchpage("dinh-duong-giam-can-chi-tiet.php")||matchpage("luyen-tap-chi-tiet.php")||matchpage("thao-luan-chi-tiet.php"))
{
$tp = new todaytopic();
$tp->select($_GET["t_id"]);
$title.="-".$tp->todaytopic_title;	
$description="Bài viết về giảm cân,dinh dưỡng,luyện tập thuộc chương trình giảm cân cùng bạn của Stada,";
$keyword=$tp->todaytopic_desc.", ";	
}



if(matchpage("luyen-tap.php") || matchpage("luyen-tap-dung-cu.php") || matchpage("luyen-tap-khong-dung-cu.php"))
{
$title.="-Luyện tập,Luyện tập dụng cụ,Luyện tập tay không";
$keyword="Luyện tập để giảm cân,luyện tập để giữ vóc dáng,sức khỏe, ";
$description="Chế độ tập luyện trong chương trình Stada giảm cân cùng bạn,luyện tập với dụng cụ,luyện tập tay không";		
}

if(matchpage("tu-van.php") )
{
$title.="-Tư vấn";
$keyword="Tư vấn về sản phẩm stada,tư vấn về sức khỏe,luyện tập,dinh dưỡng,giảm cân,chế độ tập luyện";
$description="Tư vấn,trao đổi,giải đáp thắc mắc trong chương trình Stada giảm cân cùng bạn, ";			
}
*/

//$description.="Adidas is all in,adidas";

?>

<title><?php echo $title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="<?php echo $description ?>" name="description">
<meta content="<?php echo $keyword ?>" name="keywords">

<meta property="og:tag name" content="adidas is all in"/> 
<meta property="og:image " content="http://adidasisallin.com.vn/images/index.jpg"/> 
<meta property="og:type " content="article"/> 
<meta property="og:title " content="<?php// echo $og_title ?>"/>  
<link href="images/logo.png" rel="shortcut icon">

