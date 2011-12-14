<?php
session_start();
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/saigon');
if(matchpage("page/admin")!==false  && matchpage("login.php")!==true )
{
	//check session
		if(!isset($_SESSION["mem"]))
		{echo"<script>alert('Vui lòng đăng nhập trước khi vào trang này');location.href='http://mediagurus.vn/hp/hp_survey/page/admin/account/login.php'</script>";}	

}
if( matchpage("all24_upload.php") )
{
	//check session
	/*
	if(!isset($_SESSION["mem"])){echo"<script>alert('Vui lòng đăng nhập trước khi vào trang này');location.href='index.php'</script>";}	
	*/
}
if($_SERVER['SERVER_NAME'] == "localhost")
{
$HOST="localhost";
$DATABASE="interior";
$USERNAME="root";
$PASS="123456";
$DEBUG=false;
$admin_level="../../../";
//$DEBUG=true;
$RSS_KEY="ABQIAAAAt9ed7tLxIjLKhiUXHbE-tRT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQwU3ju0R_56lQwLF3qgQpCIRA0fg";
$API_KEY="";
//$CWD ="C:\Inetpub\vhosts\sonnhadontet.com\c2life.com.vn\httpdocs\mega\" 
//echo $HOST;
}
else
{
$HOST="localhost";
$DATABASE="admin_hp";
//$USERNAME="adidasisallin";
$USERNAME="admin_hpsurvey";
$PASS="gurus!@#$%^";
$DEBUG=false;
$RSS_KEY="ABQIAAAAt9ed7tLxIjLKhiUXHbE-tRT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQwU3ju0R_56lQwLF3qgQpCIRA0fg";
$API_KEY="";
$admin_level="../../";
}
?>
<?php
define('HOST',$HOST);
define('DATABASE',$DATABASE);
define('USERNAME',$USERNAME);
define('PASS',$PASS);
define('DEBUG',$DEBUG);
define('ADMIN_LEVEL',$admin_level);
define('SITE_TITLE',"adidas is all in");
define('SITE_FACEBOOK',"http://www.facebook.com/pages/adidasisallin/118828588178622");
define('SITE_COPYRIGHT',"Copyright &#169; 2010 STADA Vietnam. All rights reserved.");
//define('CWD ',$CWD );
define('EXIST_TOPIC_TITLE'	,"Ti&#234;u &#273;&#7873; n&#224;y &#273;&#227; t&#7891;n t&#7841;i.");
define('EXIST_TYPE_TITLE'	,"Th&#7875; l&#7885;ai n&#224;y &#273;&#227; t&#7891;n t&#7841;i.");
define('INVALID_TITLE'		,"Ti&#234;u &#273;&#7873; > 5 k&#253; t&#7921;.");
define('INVALID_DESC'		,"M&#244; t&#7843; > 5 k&#253; t&#7921;.");
define('INVALID_CONT'		,"N&#7897;i dung > 5 k&#253; t&#7921;.");
define('INVALID_IMG'		,"H&#236;nh &#7843;nh kh&#244;ng h&#7907;p l&#7879;.");
define('SUCCESS_LOGIN'		,"Login tha`nh công.");
define('SUCCESS_INSERT'		,"Insert tha`nh công.");
define('SUCCESS_UPDATE'		,"Update tha`nh công.");
define('SUCCESS_DELETE'		,"Delete tha`nh công.");
define('SUCCESS_CSTASTUS'	,"Thay &#273;&#7893;i status tha`nh công.");
define('RSS_KEY'			,$RSS_KEY);
define('TPTYPE_TABLE'			,"danh sach cac the loai bai viet.");
define('TPTYPE_FORM_INS'			,"bang nhap lieu cho the loai bai viet.");
define('TPTYPE_FORM_UPD'			,"bang chinh sua cho the loai bai viet.");
define('TP_TABLE'			,"danh sach cac bai viet.");
define('TP_FORM_INS'			,"bang nhap lieu cho bai viet.");
define('TP_FORM_UPD'			,"panel chinh sua cho bai viet.");
define('CM_TABLE'			,"danh sách các bình lu&#7853;n.");
define('COMMENT_SUCCESS'			,"Bạn đã gửi bình luận thành công.");
define('CONSULT_SUCCESS'			,"Bạn đã gửi câu hỏi thành công.");
//FRONT END
define('TITLE_LIMIT'			,150);
define('DECS_LIMIT'			,250);
define('TL_ID'			,15);
define('LT_ID'			,21);
define('LTDC_ID'			,23);
define('LTKDC_ID'			,24);
define('DD_ID'			,14);
define('GC_ID'			,22);
define('SP_ID'			,25);
define('INVALID_NAME',"B&#7841;n ph&#7843;i nh&#7853;p t&#234;n.");
define('INVALID_TITLE'," B&#7841;n ph&#7843;i nh&#7853;p ti&#234;u &#273;&#7873; nhi&#7873;u h&#417;n 5 k&#253; t&#7921;.");
define('INVALID_DESC'," B&#7841;n ph&#7843;i nh&#7853;p mô tả nhi&#7873;u h&#417;n 15 k&#253; t&#7921;.");
define('INVALID_PHOTO'," B&#7841;n phải chọn ảnh tham dự.");
define('INVALID_COMMENT',"B&#7841;n ph&#7843;i nh&#7853;p b&#236;nh lu&#7853;n nhi&#7873;u h&#417;n 5 k&#253; t&#7921;.");
define('INVALID_EMAIL',"B&#7841;n ph&#7843;i nh&#7853;p email h&#7907;p l&#7879;.");
define('INVALID_CAT',"B&#7841;n ph&#7843;i ch&#7885;n th&#7875; l&#7885;ai t&#432; v&#7845;n.");
define('INVALID_SEX',"Vui l&#242;ng ch&#7885;n gi&#7899;i t&#237;nh.");//INVALID_PHONE
define('INVALID_PHONE',"S&#7889; &#273;i&#7879;n th&#7885;ai kh&#244;ng h&#7907;p l&#7879;.");//INVALID_PHONE
define('SUCCESS_REGISTER',"B&#7841;n &#273;&#227; &#273;&#259;ng k&#253; th&#224;nh c&#244;ng.");
define('SUCCESS_UPLOAD',"Cám ơn bạn đã tham gia chương trình Gamefaces.<br/>
Hình ảnh của bạn đã được chuyển đến admin,chúng tôi sẽ đưa hình của bạn lên trong thời gian sớm nhất.");//SUCCESS_UPLOAD
define('SUCCESS_UPLOAD_ALL24',"Cám ơn bạn đã tham gia chương trình Adidas All24.<br/>
File dự thi của bạn đã được chuyển đến admin,chúng tôi sẽ đưa lên trong thời gian sớm nhất.");//SUCCESS_UPLOAD
//game
define('HET',30);

$attend=array(
'week1'=>array('start'=>'2010-11-15','end'=>'2010-11-22'),
'week2'=>array('start'=>'2010-11-22','end'=>'2010-11-29'),
'week3'=>array('start'=>'2010-11-29','end'=>'2010-12-06'),
'week4'=>array('start'=>'2010-12-06','end'=>'2010-12-13')
);
//NHAT KY
define('EXISTED_DATE',"ngày bạn chọn đã có nội dung,vui lòng chọn chức năng CHỈNH SỬA.");
define('ATTEND',serialize($attend));//nho unserialize khi sd

$current_week="week4";
/*
$week3 = "2011-07-17";
$date2 = time();
$dateArr = explode("-",$week3);
$date1Int = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]);
if(($date1Int-$date2)<=0)
{
	//define('CURRENT_WEEK',"week2");
	$current_week="week4";
}
    //echo "$date1Int compare to $date2 difference is ".($date1Int-$date2);
*/
define('CURRENT_WEEK',$current_week);
//dangky thanhvien
define('EXISTED_EMAIL',"Email đã tồn tại.");
define('EXISTED_USERNAME',"Username đã tồn tại.");
define('INVALID_REALNAME',"Họ tên quá ngắn (phải > 5 ký tự).");
define('EXISTED_EMAIL',"Email đã tồn tại");
define('INVALID_PASSWORD',"Mật khẩu  quá ngắn (phải > 5 ký tự)");
define('INVALID_PASSWORD2',"Mật khẩu xác minh không đúng.");
define('INVALID_CMND',"CMND không chính xác.");
define('INVALID_USERNAME',"Username quá ngắn (phải > 5 ký tự).");
function matchpage($page)
{
	$curl=get_current_url();	
	if(strpos($curl,$page)!==false) return true;
	else return false;
}
function get_current_url() {
    $protocol = 'http';
    if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) {
        $protocol .= 's';
        $protocol_port = $_SERVER['SERVER_PORT'];
    } else {
        $protocol_port = 80;
    }
    $host = $_SERVER['HTTP_HOST'];
    $port = $_SERVER['SERVER_PORT'];
    $request = $_SERVER['PHP_SELF'];
    $query = substr($_SERVER['argv'][0], strpos($_SERVER['argv'][0], ';') + 1);
    $toret = $protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request . (empty($query) ? '' : '?' . $query);
    return $toret;
}
function redirect($alert="",$location)
{   if($alert!="")$alert="alert('$alert');";
	echo "<script>$alert location.href='$location'</script>";
}
?>
