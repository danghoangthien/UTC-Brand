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
<script id="category_parent_template" type="text/x-jquery-tmpl">
	<tr class='parent'  row_id='${row.category_id}' > 
		<td>${row.category_name} </td> 
		<td>${row.category_level} </td>
		<td>${row.category_description} </td>
		<td><a class='btn i_pencil icon blue small' href='../product/new.php?category_parent=${row.category_id} '>Add Product</a></td>
		<td><a  class='btn i_pencil icon yellow small' href='edit.php?id=${row.category_id}&category_type=${row.category_type} '>Edit</a></td>
		<td><a  class='btn  i_trashcan icon red small' href='delete.php?id=${row.category_id} '>Delete</a></td>
	</tr>
</script>
<script id="category_child_template" type="text/x-jquery-tmpl">
	<tr class='child' row_id='${row.category_id}' > 
		<td>${row.category_name} </td> 
		<td>${row.category_level} </td>
		<td>${row.category_description} </td>
		<td><a class='btn i_pencil icon blue small' href='../product/new.php?category_parent=${row.category_parent}&category_id=${row.category_id} '>Add Product</a></td>
		<td><a class='btn i_pencil icon yellow small' href='edit.php?id=${row.category_id}&category_type=${row.category_type} '>Edit</a></td>
		<td><a class='btn  i_trashcan icon red small' href='delete.php?id=${row.category_id} '>Delete</a></td>
	</tr>
</script>

    	

<script type="text/javascript">
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
		$.ajaxSetup({
			dataType:"json",
			type:"POST"
		});
		$(".datatable tbody").pagebind({
			template:"#category_parent_template",
			navigation	: "#page_navigation",
			url:"../../htinmotion/orm/category/core.php?type=get_category_by_category_level&category_type="+$.url().param("category_type"),
			onBindPage:get_child()
		});

	});
	function get_child(){
		setTimeout(function(){
			$(".datatable  tr.parent").each(function(){
				var row_id=$(this).attr("row_id");
				$.ajax({
					data 	: {category_parent:row_id,category_level:1,category_type:1},
					url  	:"../../htinmotion/orm/category/core.php?type=get_category_by_category_parent",	
					success	:function(json){
						$("tr[row_id='"+row_id+"']").after($("#category_child_template").tmpl(json.rows));
					}
				})
		})	
		},1500)
		
	}
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
			<div class="alert info">Danh sách thể loại</div>
			
			<table class="datatable">
				<thead>
					<tr>
						<th>Tên thể loại </th>
						<th>Level</th>
						<th>Mô tả</th>
						<th colspan="3">quản lý</th>
					</tr>
				</thead>
				<tbody>
                
                </tbody>
				<tfoot>
					<tr>
						<th>Tên thể loại </th>
						<th>Level</th>
						<th>Mô tả</th>
						<th colspan="3">quản lý</th>
					</tr>
				</tfoot>
			</table>
            <a style="width:100px" class='add_category btn i_pencil green'>Thêm mới</a>
             <a style="width:100px" class='folding btn i_triangle_left_right green'>Fold</a>
		</div>
               
	</section>
<footer>Developed by HT-In-Motion </footer>
</body>
</html>
