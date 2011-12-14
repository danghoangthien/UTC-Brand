// JavaScript Document
//(function($) {
    $.fn.selectbind = function(options) {
  		// Our plugin implementation code goes here.
		var defaults = {
    		url			: "_Admin/view/family/DemoHandler.ashx",
    		clickbind	: function(){},
			changebind	: function(){}
  		};
		//var opts = $.extend(defaults, options);
		if ( options ) { 
       		var options=$.extend( defaults, options );
      	}
		return this.each(function() {
			var o = options;			
			//Assign current element to variable, in this case is SELECT element
            var obj = $(this); 
			obj.bind('click', o.clickbind);  
			obj.bind('change', o.changebind);    
			  
			$.ajax({
				url:o.url,
				data:{},
				type:"POST",
				dataType:"xml",
				success:function(xml){
					obj.html("");
					$(xml).find("option").each(function(){
						obj.append("<option>"+$(this).text()+"</option>");
					})					
				}				
			})
			
			//obj.append("<option>go</option>");  
	    });
	};
	//})(jQuery);