<?
include "../../../config.php";
include "../adodb5/adodb.inc.php";
include "../general/general.php";
include "../adodb5/tojson.inc.php";
include "../../pagination/pagingAdvance.php";
$g=new general();
if($_GET['type']=='get_all')
{
	$sql = 	"SELECT * from product where product_status!='trash' ";
	$category=$g->getSQLJSON($sql);
	return;
}
if($_GET['type']=='get_product_by_product_id')
{
	$sql = 	"SELECT * from product "
			." where  product_id=".$_POST['product_id'];
	$category=$g->getSQLJSON($sql);
	return;
}
if($_GET['type']=='edit_product')
{
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	$validate=product_validate();
	if($validate!="1") return;
	$g=new general();
	$msg=$g->executeUpdate("product",$_POST," where product_id=".$_POST["product_id"]);
	if($msg==true)
	{
		$msg="Thay đổi thông tin thành công.";
	}
	echo "<status><![CDATA[$msg]]></status>";
	return;
}
if($_GET['type']=='add_product')
{
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	$validate=product_validate();
	if($validate!="1") return;
	$g=new general();
	$msg=$g->executeInsert("product",$_POST,"");
	if(is_numeric($msg))
	{
		$msg= "Thêm sản phẩm thành công.";
	}
	echo "<status><![CDATA[$msg]]></status>";
	return;
}
if($_GET['type']=='edit_product')
{
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	if($_POST["product_status"]=='trash') {$validate=1;echo"dd";}
	if($_POST["product_status"]!='trash') {$validate=product_validate();}
	if($validate!="1") return;
	$g=new general();
	$msg=$g->executeUpdate("product",$_POST," where product_id=".$_POST["product_id"]);
	if($msg==true)
	{
		if($_POST["product_status"]!='trash')$msg="Thay đổi thông tin sản phẩm thành công.";
		if($_POST["product_status"]=='trash') $msg="Xóa sản phẩm thành công.";
	}
	echo "<status><![CDATA[$msg]]></status>";
	return;
}
function product_validate(){
	if(!isset($_POST["product_name"]) || $_POST["product_name"]=="")
	{
		$msg="Vui lòng nhập: <strong>Tên sản phẩm</strong>";
		echo "<status><![CDATA[$msg]]></status>";
		return;
	}
	if(!isset($_POST["product_price"]) || $_POST["product_price"]=="")
	{
		$msg="Vui lòng nhập: <strong>Giá thể loại</strong>";
		echo "<status><![CDATA[$msg]]></status>";
		return;
	}
	if(!isset($_POST["product_code"]) || $_POST["product_code"]=="-1")
	{
		$msg="Vui lòng nhập: <strong>Mã sản phẩm</strong>";
		echo "<status><![CDATA[$msg]]></status>";
		return;
	}
	if(!isset($_POST["product_release_dt"]) || $_POST["product_release_dt"]=="-1")
	{
		$_POST["product_release_dt"]=date("Y-m-d H:i:s");
	}
	$_POST["product_create_dt"]=date("Y-m-d H:i:s");
	return "1";
}
?>