<?
include "../../../config.php";
include "../adodb5/adodb.inc.php";
include "../general/general.php";
include "../adodb5/tojson.inc.php";
include "../../pagination/pagingAdvance.php";
$g=new general();
if($_GET['type']=='get_category_by_category_parent')
{
	$sql = 	"SELECT * from category "
			." where category_parent=".$_POST['category_parent']
			." and category_level=".$_POST['category_level']
			." and category_type=".$_POST['category_type'];
	$category=$g->getSQLJSON($sql);
	return;
}

if($_GET['type']=='get_category_by_category_level')
{
	if(isset($_GET["category_type"])) $category_type=" AND category_type=".$_GET["category_type"];
	
	if($_POST['type']=='page')
	{
		$query_pag_data = "SELECT * from category where category_level=0 $category_type";
		pagingJSON($_POST["page"],$query_pag_data,1000,false);
		return;
	}
	if($_POST['type']=="no_of_page")
	{
		$count_sql="select count(category_id) as count from category where category_level=0 $type";
		smartPagingNavi($_POST["cur_page"],$count_sql,1000,true);
		return;
	}
}
if($_GET['type']=='get_category_by_category_id')
{
	$sql = 	"SELECT * from category "
			." where category_id=".$_POST['category_id'];
	$category=$g->getSQLJSON($sql);
	return;
}
if($_GET['type']=='manage_category')
{
	$by_category_type=( isset($_POST["category_type"]) )?" and category_type=".$_POST["category_type"]:"";
	$by_category_level=( isset($_POST["category_level"]) )?" and category_level=".$_POST["category_level"]:"";
	$sql = 	"SELECT category_id,category_name,category_description from category where 1=1  $by_category_type $by_category_level";
	$category=$g->getSQLJSON($sql);
	return;
}
if($_GET['type']=='add_category')
{
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	$validate=category_validate();
	if($validate!="1") return;
	$g=new general();
	$msg=$g->executeInsert("category",$_POST,"");
	if(is_numeric($msg))
	{
		$msg= "Thêm sản phẩm thành công.";
	}
	echo "<status><![CDATA[$msg]]></status>";
	return;
}
if($_GET['type']=='edit_category')
{
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	$validate=category_validate();
	if($validate!="1") return;
	$g=new general();
	$msg=$g->executeUpdate("category",$_POST," where category_id=".$_POST["category_id"]);
	if($msg==true)
	{
		$msg="Thay đổi thông tin thành công.";
	}
	echo "<status><![CDATA[$msg]]></status>";
	return;
}
function category_validate(){
	if($_POST["category_type"]=="-1")
	{
		$msg="Vui lòng chọn: <strong>loại thể loại</strong>";
		echo "<status><![CDATA[$msg]]></status>";
		return;
	}
	if($_POST["category_level"]=="-1")
	{
		$msg="Vui lòng chọn: <strong>Level thể loại</strong>";
		echo "<status><![CDATA[$msg]]></status>";
		return;
	}
	if(!isset($_POST["category_name"]) || $_POST["category_name"]=="")
	{
		$msg="Vui lòng nhập: <strong>tên thể loại</strong>";
		echo "<status><![CDATA[$msg]]></status>";
		return;
	}
	return "1";
}
?>