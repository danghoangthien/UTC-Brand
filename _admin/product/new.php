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
    $.fn.ready(function(){
		var option={
				url:"../../htinmotion/orm/category/core.php?type=get_category_by_category_parent",
				data:{
						category_parent:-1, category_level:0,category_type  :1						
					},
				template:"#category_parent_template",
				changebind:function(){
					childBind();
				}
		};
		$("#category_parent").selectbind(option);
		setTimeout(function(){
			$("#category_parent").trigger("change");
			if($.url().param("category_parent"))
			{
				$("#category_parent" ).val($.url().param("category_parent")).trigger("change").attr('disabled', 'disabled');
			}		
		},1200);
		uploadBinding("#product_image","#product_image_display","/uploads/");
		$("#action").click(function(){
			$.ajax({
				type	:"POST",
				data	:$('form#manage').serializeArray(),
				dataType:"xml",
				url		:"../../htinmotion/orm/product/core.php?type=add_product",
				success	:function(xml){
						jQuery.facebox($(xml).find("status").text());
						}
			})	
		});
	});
	function childBind(){
		var option={
				url:"../../htinmotion/orm/category/core.php?type=get_category_by_category_parent",
				data:{
						category_parent:$("#category_parent").val(),
						category_level:1,
						category_type  :1
					},
				template:"#category_parent_template"
		}
		$("#category_id").selectbind(option);
		setTimeout(function(){
			$("#category_id").trigger("change");
			if($.url().param("category_id"))
			{
				$("#category_id" ).val($.url().param("category_id"));
				$("#category_id" ).trigger("change").attr('disabled', 'disabled'); 
				$("#category_parent").attr('disabled', 'disabled');
			}
		},1000)
		
		//$("#category_id").trigger("change");
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
        <form  id="manage">  
        <div class="alert info"> Nhập sản phẩm và các thông số kỹ thuật </div> 
        <div class="g4">
                <label >Thể loại gốc </label>
                <select  id="category_parent" class="field select addr"> 
                 <option selected='selected' value='-1'>Please select...</option>
                </select>  
                <p class="instruct">Chọn thể loại gốc (Level 1)</p>
         </div>
         <div class="g4">       
         		<label>Thể loại con </label>
                <select name="category_id" id="category_id" class="field select addr"> 
                 <option selected='selected' value='-1'>Please select...</option>
                </select>  
                <p class="instruct">Chọn thể loại con</p>
        </div>
        <div class="g4">
                <label>Tên sản phẩm</label>
                <input type="text" class="field text large"  name="product_name"  id="product_name"/>
                <p class="instruct">Tên sản phẩm (bắt buộc) </p>
        </div>
        <div class="g4">
                <label>Mã sản phẩm</label>
                <input type="text" class="field text small"  name="product_code"  id="product_code"/>

                <p class="instruct">Mã số sản phẩm (bắt buộc) </p>
        </div>
        <div class="g4">
                <label>Đơn giá sản phẩm</label>
                <input type="text" class="field text large"  name="product_price"  id="product_price"/>

                <p class="instruct">Đơn giá sản phẩm (bắt buộc) </p>
        </div>
         <div class="g4">
                <label>Chất liệu sản phẩm</label>
                <input type="text" class="field text large"  name="product_material"  id="product_material"/>
                <p class="instruct">Thông số kỹ thuật,Chất liệu sản phẩm (không bắt buộc) </p>
        </div>
        <div class="g12">
                <label >Hình ảnh sản phẩm
                </label>
                 <input type="hidden" name="product_image" id="product_image"/>
                <img src="" id="product_image_display" width="250px">
                <p class="instruct">Hình ảnh  sản phẩm (không bắt buộc),nếu chưa có hình sẽ được đăng hình mặc định.Click vào hình để xem kích thước thật </p>
        </div>
       
        
         
        <div class="g12">
                <label>Mô tả,ghi chú sản phẩm</label>
                <textarea rows="1" cols="30" class="field textarea small" name="product_description" id="product_description">  </textarea>          
                <p class="instruct">Ghi chú dành cho sản phẩm(không bắt buộc)</p>
        </div>
        <div class="g6">
                <label>Ngày phát hành sản phẩm</label>
                <input type="text" class="field text large datepicker"  name="product_release_dt"  id="product_release_dt"/>
                <p class="instruct">Ngày phát hành sản phẩm (không bắt buộc) </p>
        </div>
        <div class="g6">
                <label>Ngày kết thúc sản phẩm</label>
                <input type="text" class="field text large datepicker"  name="product_expire_dt"  id="product_expire_dt"/>
                <p class="instruct">Ngày kết thúc sản phẩm (không bắt buộc) </p>
        </div>
        <div class="g12">
                <label>Trạng thái/Đặc điểm</label>
                <select  id="product_featured" name="product_featured" class="field select addr"> 
                    <option selected='selected' value='normal'>Sản phẩm bình thường</option>
                    <option value='featured'>Sản phẩm tiêu biểu (hot)</option>
                </select>
                 <select  id="product_status"  name="product_status" class="field select addr"> 
                    <option selected='selected' value='enable'>Phát hành (theo ngày phát hành)</option>
                    <option value='disable'>Tạm ngưng</option>
                </select>    
                <p class="instruct">Chọn tình trạng sản phẩm</p>
        </div>
        <div class="g12">
              <span class="right">
               <select  id="next_action"  class="field select addr"> 
                    <option value='next' selected='selected' >Thêm sản phẩm và tiếp tục</option>
                    <option value='preview'>Xem trước </option>
                    <option value='list'>Trở về danh sách</option>
                    <option value='front'>Xem trên trang chủ</option>
                </select>    
                <a id="action" class="btn i_arrow_right icon blue" >Thực hiện</a>
            </span>
        </div>
 
	</form>       
</section>
<footer>Developed by HT-In-Motion </footer>
</body>
</html>
