<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script runat="server">
</script>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<? include "../../theme/whitelabelTheme/template/head.html"; ?> 
<style type="text/css">
#paging ul li{
display:inline;
padding:5px;
color:#0099cc;
cursor:pointer;
}
li{
	list-style:none;
}
table tr.parent{
	background:#EFEFEF;
}
table tr.parent td
{
	font-weight:700;
	
}
table td{
	vertical-align:middle;
}
</style>
<script id="product_list_template" type="text/x-jquery-tmpl">
	<tr> 
		<td>${row.product_name} </td>
		<td>${row.product_price} </td> 
		<td>${row.product_material} </td> 
		<td>${row.product_release_dt} </td>
		<td>${row.product_expire_dt} </td>
		<td>${row.product_status} </td>
		<td>${row.product_feature} </td>
		<td><a  action="ajax_detail" row_id='${row.product_id}' class='btn i_pencil icon green small' href='#t' >Details</a></td>
		<td><a  class='btn i_pencil icon yellow small' href='edit.php?id=${row.product_id}'>Edit</a></td>
		<td><a  action="ajax_trash" row_id='${row.product_id}'  class='btn i_trashcan icon red small' href='#t' >Delete</a></td>
	</tr>
</script>

    	

<script type="text/javascript">
	$.ajaxSetup({
			dataType:"json",
			type:"POST"
	});
    $.fn.ready(function(){
		if($.url().param("category_type"))
		{
			$(".add_category").attr("href","new.php?category_type="+$.url().param("category_type"));
			$(".folding").click(function(){
				if($("tr.child").css("display")=="none")
				{
					$("tr.child").show("slow");
				}
				else
				{
					$("tr.child").hide("slow");
				}
			})
		}
		$(".datatable tbody").pagebind({
			template:"#product_list_template",
			navigation	: "",
			url:"../../htinmotion/orm/product/core.php?type=get_all",
			onBindPage:get_child()
		});

	});
	function get_child(){
		setTimeout(function(){
			$(".datatable ").dataTable();
		},1500)
	}
	$("a[action='ajax_trash']").live('click',function(){
		var product_id=$(this).attr("row_id");
		jQuery.facebox("<h3>Bạn có chắc muốn xóa sản phẩm này</h3><h3><strong id='ajax_trash_confirm'>Có</strong> <strong id='ajax_trash_cancel'>Không</strong></h3>");
		$("#ajax_trash_confirm").click(function(){
			$.ajax({
				dataType:"json",
				data	:{product_id:product_id,product_status:'trash'},
				url		:"../../htinmotion/orm/product/core.php?type=edit_product",
				success	:function(xml){
					jQuery.facebox("<h3>"+$(xml).find("status").text()+"</h3>");
					setTimeout(function(){
						location.reload;
					},2500)
				}
			})
		});
		$("#ajax_trash_cancel").click(function(){
			 jQuery(document).trigger('close.facebox') ;
		});
		
	});
	$("a[action='ajax_detail']").live('click',function(){
		//popup layout...
	});	
</script>
<body>
	<div id="pageoptions">
	<? include "../../theme/whitelabelTheme/template/pageoptions.html"; ?> 
    	<!--#include file="../../../Theme/template/pageoptions.html" --> 
    </div>
	<header>
    <? include "../../theme/whitelabelTheme/template/header.html"; ?> 
		<!--#include file="../../../Theme/template/header.html" --> 
	</header>
    <nav>
	 <? include "../../theme/whitelabelTheme/template/nav.html"; ?> 
	</nav>			
	<section id="content">
		<div class="g12">
			<div class="alert info">Danh sách sản phẩm</div>
			
			<table class="datatable">
				<thead>
					<tr>
						<th>Tên sản phẩm &nbsp;&nbsp;</th>
						<th>Giá&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th>Chất liệu&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Ngày phát hành&nbsp;&nbsp;</th>
                        <th>Ngày kết thúc&nbsp;&nbsp;</th>
                        <th>Tình trạng&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Trạng thái&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th colspan="3">quản lý</th>
					</tr>
				</thead>
				<tbody>
                
                </tbody>
				<tfoot>
					<tr>
						<th>Tên sản phẩm </th>
						<th>Giá</th>
						<th>Chất liệu</th>
                        <th>Ngày phát hành</th>
                        <th>Ngày kết thúc</th>
                        <th>Tình trạng</th>
                        <th>Trạng thái</th>
						<th colspan="3">quản lý</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</section>
<footer>Developed by HT-In-Motion </footer>
</body>
</html>
