<?php
include_once '../../config.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
include_once '../../template/admin/raiseerror.php';
$g=new general();
if ($_POST["type"]=="login") 
{		
	$sql="select * from member where member_user='".$_POST["username"]
		."' and member_pass='".md5($_POST["password"])."'";
	$mem=$g->getSQL($sql,0);
	if	($mem[0])
	{		
		$_SESSION["mem"]=$mem[0];	
		$redirect=	"javascript:history.go(-2)";
		if($_POST["basename"]=="index.php")
		{
			$redirect=	"javascript:history.go(-1)";
		}
		if($_POST["basename"]=="register.php")
		{
			$redirect=	"javascript:history.go(-3)";
		}
		redirect("Chào mừng bạn đến với Adidas Việt Nam.",$redirect);
	}
	else redirect("Tên đăng nhập hoặc mật khẩu chưa chính xác !!","javascript:history.go(-1)" );
}
if ($_POST["type"]=="register") 
{
	$member= array();
	$error=array();
	$pattern 	= "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/";//	memid
	$pattern	= "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
	//tendangnhap,hoten,matkhau,diachi,cmnd,dienthoai,email
	
	if(strlen($_POST["tendangnhap"])<5)
	{
		$error[]=INVALID_USERNAME;
		//echo "<error>".INVALID_USERNAME."</error>";return;
	}
	else 
	{
		$member["member_user"]=$_POST["tendangnhap"];
		$sql="select member_user from member where member_user='".$_POST["tendangnhap"]."'";
		$arr=$g->getSQL($sql,0);
			if($arr[0])
			{ 
			$error[]=EXISTED_USERNAME;
			//echo "<error>".EXISTED_USERNAME."</error>";return;
			}
	}
	if(!$_POST["gioitinh"])
	{
		$error[]=INVALID_SEX;
		/*echo "<script>alert('".INVALID_USERNAME."')</script>";return;*/
	}
	else $member["member_sex"]=$_POST["gioitinh"];
	if(strlen($_POST["hoten"])<1)
	{
		$error[]=INVALID_REALNAME;
		/*echo "<script>alert('".INVALID_REALNAME."')</script>";return;*/
	}
	else $member["member_rname"]=$_POST["hoten"];
	if(strlen($_POST["matkhau"])<5)
	{
		$error[]=INVALID_PASSWORD;
		/*echo "<script>alert('".INVALID_PASSWORD."')</script>";return;*/
	}
	else
	{
		if($_POST["matkhau"]!=$_POST["matkhau2"])
		{
			$error[]=INVALID_PASSWORD2;
			/*echo "<script>alert('".INVALID_PASSWORD2."')</script>";return;*/
		}
		else $member["member_pass"]=md5($_POST["matkhau"]);
	}	
	if(strlen($_POST["cmnd"])<9 || strlen($_POST["cmnd"])>10 || is_numeric($_POST["cmnd"])==false )
	{
		$error[]=INVALID_CMND;
		/*echo "<script>alert('".INVALID_CMND."')</script>";return;*/
	}
	else  $member["member_card"]=$_POST["cmnd"];
	$sql="select member_email from member where member_email='".$_POST["email"]."'";
	$arr=$g->getSQL($sql,0);
	if($arr[0])
	{ 
		$error[]=EXISTED_EMAIL;
		/*echo "<script>alert('".EXISTED_EMAIL."')</script>";return;*/
	}
	if(strlen($_POST["email"])==0 || !preg_match($pattern,$_POST["email"]))
	{
		$error[]=INVALID_EMAIL;
		/*echo "<script>alert('".INVALID_EMAIL."')</script>";return;*/
	}
	else  $member["member_email"]=$_POST["email"];
	if(!is_numeric($_POST["dienthoai"]))
	{
		$error[]=INVALID_PHONE;
		/*echo "<script>alert('".INVALID_PHONE."')</script>";return;*/
	}
	else $member["member_phone"]=$_POST["dienthoai"];
	if(sizeof($error)==0)
	{
		header('Content-type: text/xml');
		echo "<?xml version='1.0' encoding='UTF-8'?>";	
		$member["member_add"]=$_POST["diachi"];
		$member["member_dob"]=$_POST["ngaysinh"];
		$g->executeInsert("member",$member,"");
		echo "<status>".SUCCESS_REGISTER."</status>";
		//redirect("Bạn đã đăng ký thành công!","../../index.php");
		
	}
	else
	{
		header('Content-type: text/xml');
		echo "<?xml version='1.0' encoding='UTF-8'?>";	
		echo "<errors>";
		foreach($error as $e)
		{
			echo "<error>$e</error>";
		}
		echo "</errors>";
	}
	
} 

?>
