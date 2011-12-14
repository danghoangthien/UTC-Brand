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
</style>
<script id="category_parent_template" type="text/x-jquery-tmpl">
    	<option value="${row.category_id}">${row.category_name}</option>
</script>

    	

<script type="text/javascript">
    $(document).ready(function(){
		
			if($.url().param("category_type"))
			{
				$("#category_type").val($.url().param("category_type"));
				$("#category_type").trigger("change");
			}		
		$("#category_level").change(function(){
			var option={
				url:"../../htinmotion/orm/category/core.php?type=get_category_by_category_parent",
				data:{
						category_parent:$("#category_parent").val(),
						category_level:0,
						category_type  :$("#category_type").val()
					},
				template:"#category_parent_template"
			};
			if($("#category_level").val()=="1") {$("#category_parent").selectbind(option);}
			if($("#category_level").val()=="0") {$("#category_parent").html("<option value='-1'>Please select...</option>");}
		});
		$("#category_type").change(function(){
			//$("#category_level option[value='-1']").attr("selected","selected");
			
			$("#category_level").trigger("change");
		});
		$("#add").click(function(){
			$.ajax({
				type:"POST",
				data:$('form#add_category').serializeArray(),
				dataType:"xml",
				url:"../../htinmotion/orm/category/core.php?type=add_category",
				success:function(xml){
					jQuery.facebox($(xml).find("status").text());
				}
			})	
		});
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

        <form  id="add_category">  
        <div class="alert info">
            <br/>    
	        <h2>Nhập thể loại</h2>
	    </div> 
        <ul>
            <li >
		        <div>
		                <label>Thể loại dành cho </label>
		                <select name="category_type" id="category_type" class="field select addr"> 
		                 <option selected='selected' value='-1'>Please select...</option>
                         <option  value='0'>Tin tức</option>
                         <option  value='1'>Sản phẩm</option>
		                </select>  
		                <p class="instruct">Chọn kiểu thể loại</p>
		        </div>
		    </li>
		    <li >
		        <div>
		                <label>Level </label>
		                <select name="category_level" id="category_level" class="field select addr"> 
		                    <option selected='selected' value='-1'>Please select...</option>
                         	<option  value='0'>Thể loại gốc</option>
                            <option  value='1'>Thể loại con</option>
		                </select>  
		                <p class="instruct">Chọn level cho thể loại </p>
		        </div>
		    </li>
            <li >
		        <div>
		                <label>Thuộc thể loại </label>
		                <select name="category_parent" id="category_parent" class="field select addr"> 
		                    <option selected='selected' value='-1'>Please select...</option>
                         	
		                </select>  
		                <p class="instruct">Chọn  thể loại cha</p>
		        </div>
		    </li>
		    
		    <li class="complex" >
	          
	            <div>
	                    <label>Tên thể loại</label>
	                    <input class="field text large"  name="category_name"  id="category_name">
	                    </input>
		                <p class="instruct">Tên thể loại (bắt buộc) </p>
		        </div>
		        <div>
	                    <label>Mô tả,ghi chú thể loại</label>
                        <textarea rows="1" cols="50" class="field textarea small" name="category_description" id="category_description">
	                       
	                    </textarea>
		                <p class="instruct">Ghi chú thể loại (không bắt buộc)</p>
		        </div>
		    </li>
		     <li>
		        <div>
		              <span class="right">
		                <a id="add" class="btn i_arrow_right icon blue" >thêm thể loại</a>
		            </span>
		        </div>
		     </li>
		            

	    </ul> 
	</form>       
</section>
<footer>Developed by HT-In-Motion </footer>
</body>
</html>
