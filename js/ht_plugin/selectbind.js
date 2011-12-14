// JavaScript Document
//(function($) {
    $.fn.selectbind = function(options) {
  		// Our plugin implementation code goes here.
		var defaults = {
			data		: "",
    		url			: "",
			template	: "",
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
			
			
			  
			$.ajax({
				url:o.url,
				data:o.data,
				type:"POST",
				dataType:"json",
				success:function(json){
			
					if(json.rows=="row")
					{
						obj.html('<option value="-1">Please select ... </option>');
					}
					else
					{
						//$(o.template).tmpl(json.rows,obj);
						obj.html($(o.template).tmpl(json.rows));
					}
					obj.bind('click', o.clickbind);  
					obj.bind('change', o.changebind);  
				}				
			})
			  
			//obj.append("<option>go</option>");  
	    });
	};
	//})(jQuery);