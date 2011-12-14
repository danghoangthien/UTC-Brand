<?
//$lv="../../";
include_once ($lv."config.php");
include_once $lv.'htinmotion/php-cut-html-string/cutstring.php';
include_once $lv.'htinmotion/orm/adodb5/adodb.inc.php';
include_once $lv.'htinmotion/orm/general/general.php';
/*
$g=new general();
//get latest from 6 category
$lt=$g->getSQL(
	"
	(SELECT * FROM contest WHERE contest_active='enable' AND contest_type=1 ORDER BY contest_date DESC   LIMIT 0,1)
	UNION ALL
	(SELECT * FROM contest WHERE contest_active='enable' AND contest_type=2 ORDER BY contest_date DESC  LIMIT 0,1)
	UNION ALL
	(SELECT * FROM contest WHERE contest_active='enable' AND contest_type=3 ORDER BY contest_date DESC LIMIT 0,1)
	UNION ALL
	(SELECT * FROM contest WHERE contest_active='enable' AND contest_type=4 ORDER BY contest_date DESC LIMIT 0,1)
	UNION ALL
	(SELECT * FROM contest WHERE contest_active='enable' AND contest_type=5 ORDER BY contest_date DESC LIMIT 0,1)
	ORDER BY contest_date desc
	",0);
/*echo "<pre>";
print_r($lt);
echo "</pre>";*/
//$tof["contest_type"]="3";
//print_r  (find_type($lt,$tof));
/*
function find_type($arr,$pair)
{
	$has=-1;
	$key=array_keys($pair);
	$value=$pair[$key[0]];
	foreach($arr as $ak=>$av)
	{
		foreach($av as $k=>$v )
		{
			if($k==$key[0] &&  $v==$value)
			{
				$has=$ak;
			}
		}
	}
	return $has;
}

$desc=array();
$dance["contest_type"]="1";
$key_dance=find_type($lt,$dance);
if($key_dance==-1)
{
	$desc[0]["all dance"]="Nếu những vũ điệu sôi động chính là đam mê của bạn, bạn sẽ cần đến sàn đấu của chúng tôi. Chúng tôi biết bạn có những bước nhảy điêu luyện. Vậy thì còn chần chờ gì nữa, hãy cho mọi người thấy những điệu nhảy của bạn đi nào!";
	$desc[0]["img"]="images/home_all24_sp1.jpg";
}
if($key_dance!=-1)
{
	$desc[0]["all dance"]=$lt[$key_dance]["contest_desc"];
	//$desc[0]["all dance"]="Nếu những vũ điệu sôi động chính là đam mê của bạn, bạn sẽ cần đến sàn đấu của chúng tôi. Chúng tôi biết bạn có những bước nhảy điêu luyện. Vậy thì còn chần chờ gì nữa, hãy cho mọi người thấy những điệu nhảy của bạn đi nào!";
	$desc[0]["img"]="images/home_all24_sp1.jpg";
	$desc[0]["vid"]=$lt[$key_dance]["contest_video_converted"];
}
$model=array();
$model["contest_type"]="5";
$key_model=find_type($lt,$model);
if($key_model!=-1)
{
	$desc[4]["all modeling"]=$lt[$key_model]["contest_desc"];
	$desc[4]["img"]="uploads/".$lt[$key_model]["contest_fileup"];
}
if($key_model==-1)
{
	$desc[4]["all modeling"]="Bạn yêu thời trang và tự tin về hình thể của mình. Chúng tôi có sàn diễn. Tham gia cùng chúng tôi và trở thành người mẫu triển vọng nhất.";
	$desc[4]["img"]="images/home_all24_sp5.jpg";
}

$music=array();
$music["contest_type"]="3";
$key_music=find_type($lt,$music);
if($key_music!=-1)
{
	$desc[2]["all music"]=$lt[$key_music]["contest_desc"];	
	$desc[2]["img"]="images/home_all24_sp1.jpg";
	$desc[2]["vid"]=$lt[$key_music]["contest_video_converted"];
}
if($key_music==-1)
{
	$desc[2]["all music"]="Bạn đam mê ca hát. Chúng tôi có sân khấu và khán giả. Thể hiện đam mê của mình và và để cho khán giả reo hò theo giọng ca của bạn. Hãy đăng ký và tham gia cùng chúng tôi.";
	$desc[2]["img"]="images/home_all24_sp3.jpg";
}
*/
	$desc[4]["all modeling"]="Bạn yêu thời trang và tự tin về hình thể của mình. Chúng tôi có sàn diễn. Tham gia cùng chúng tôi và trở thành người mẫu triển vọng nhất.";
	$desc[4]["img"]="images/home_all24_sp5.jpg";
$desc[0]["all dance"]="Nếu những vũ điệu sôi động chính là đam mê của bạn, bạn sẽ cần đến sàn đấu của chúng tôi. Chúng tôi biết bạn có những bước nhảy điêu luyện. Vậy thì còn chần chờ gì nữa, hãy cho mọi người thấy những điệu nhảy của bạn đi nào!";
	$desc[0]["img"]="images/home_all24_sp1.jpg";
$desc[1]["all football"]="Hãy tưởng tượng có cả trăm bàn thắng được ghi. Và trận đấu sẽ kéo dài bất tận. Mỗi trận đấu 24phút, đội 5 người sẽ đấu với nhau, và đội chiến thắng sẽ được xác định. Khoảnh khắc của mỗi bàn thắng sẽ được ghi hình.Tại đây, những kỹ năng tâng bóng cũng sẽ được phô diễn cùng với những thử thách cùng trái bóng.Tham gia cùng với đội bóng của mình và đọ tài cùng những đội bóng khác.";
$desc[1]["img"]="images/home_all24_sp2.jpg";

$desc[3]["all fashion"]="Cảm hứng thời trang từ niềm đam mê. Hãy trở thành nhà thiết kế trẻ hot nhất và mang cảm hứng của bạn đến với mọi người. Đó là cơ hội để thiết kế của bạn được hiện thực hoá. Hãy đăng ký và tham gia cùng chúng tôi. Mang đời thường đến với sàn diễn. Lấy cảm hứng từ nơi ở của mình. Mang phong cách của bạn đến với chúng tôi và chúng ta sẽ chia sẽ cùng thế giới.";
$desc[3]["img"]="images/home_all24_sp4.jpg";
$desc[2]["all music"]="Bạn đam mê ca hát. Chúng tôi có sân khấu và khán giả. Thể hiện đam mê của mình và và để cho khán giả reo hò theo giọng ca của bạn. Hãy đăng ký và tham gia cùng chúng tôi.";
$desc[2]["img"]="images/home_all24_sp3.jpg";
$desc[5]["all skate & BMX"]="Sự kiện all24 sẽ mang đến những trải nghiệm thú vị về skateboard và là nơi mà các bạn chia sẻ kinh nghiệm và kỹ năng trượt ván của mình. Chúng ta có chung nhiệm vụ với những cú lướt, xoay mình và all in cùng tấm ván.Nếu bạn muốn trình diễn khả năng và học những kỹ năng từ người giỏi nhất, hãy đến tham gia cùng chúng tôi.";
$desc[5]["img"]="images/home_all24_sp6.jpg";
$desc[6]["all fun"]="Graffiti, Bóng rổ, Freestyle Football, Kinect game - Đâu là hoạt động yêu thích của bạn? Hãy tham gia cũng chúng tôi trong sự kiện all24! Vui lòng đăng ký giữ chỗ trên website.";
$desc[6]["img"]="images/home_all24_sp7.jpg";

?>






















