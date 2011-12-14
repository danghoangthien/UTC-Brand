<?php 
include_once '../../config.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
include_once '../../template/admin/raiseerror.php';
if ($_POST) 
{
	$g=new general();
	$member= new urc_member();
	$error=array();
	$pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/";//	memid
	
	//tendangnhap,hoten,matkhau,diachi,cmnd,dienthoai,email
	$sql="select member_user from urc_member where member_user='".$_POST["tendangnhap"]."'";
	$arr=$g->getSQL($sql,0);
	if($arr[0])
	{ 
		$error[]=EXISTED_USERNAME;
		echo "<script>alert('".EXISTED_USERNAME."')</script>";return;
	
	}
	if(strlen($_POST["tendangnhap"])<5)
	{
		$error[]=INVALID_USERNAME;
		echo "<script>alert('".INVALID_USERNAME."')</script>";return;
	}
	else $member->member_user=$_POST["tendangnhap"];
	
	if(strlen($_POST["hoten"])<1)
	{
		$error[]=INVALID_REALNAME;
		echo "<script>alert('".INVALID_REALNAME."')</script>";return;
	}
	else $member->member_rname=$_POST["hoten"];
	if(strlen($_POST["matkhau"])<5)
	{
		$error[]=INVALID_PASSWORD;
		echo "<script>alert('".INVALID_PASSWORD."')</script>";return;
	}
	else
	{
		if($_POST["matkhau"]!=$_POST["matkhau2"])
		{
			$error[]=INVALID_PASSWORD2;
			echo "<script>alert('".INVALID_PASSWORD2."')</script>";return;
		}
		else $member->member_pass=md5($_POST["matkhau"]);
	}	
	if(strlen($_POST["cmnd"])<9 || strlen($_POST["cmnd"])>10 || is_numeric($_POST["cmnd"])==false )
	{
		$error[]=INVALID_CMND;
		echo "<script>alert('".INVALID_CMND."')</script>";return;
	}
	else  $member->member_card=$_POST["cmnd"];
	$sql="select member_email from urc_member where member_email='".$_POST["email"]."'";
	$arr=$g->getSQL($sql,0);
	if($arr[0])
	{ 
		$error[]=EXISTED_EMAIL;
		echo "<script>alert('".EXISTED_EMAIL."')</script>";return;
	}
	if(strlen($_POST["email"])==0 || !preg_match($pattern,$_POST["email"]))
	{
		$error[]=INVALID_EMAIL;
		echo "<script>alert('".INVALID_EMAIL."')</script>";return;
	}
	else  $member->member_email=$_POST["email"];
	if(!is_numeric($_POST["dienthoai"]))
	{
		$error[]=INVALID_PHONE;
		echo "<script>alert('".INVALID_PHONE."')</script>";return;
	}
	else $member->member_phone=$_POST["dienthoai"];
	if(sizeof($error)==0
	)
	{
		$member->member_add=$_POST["diachi"];
		$member->insert();
		redirect("Bạn đã đăng ký thành công!","../../index.php");
		
	}
	else
	{
		$appendError=appendError($error);
		echo $appendError;
	}
	
	
}
?>