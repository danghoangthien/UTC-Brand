<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<title>Excel Reader</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<style type="text/css" media="screen">
		body{
			font-family: Arial, "MS Trebuchet", sans-serif;
			font-size:.8em;
			color:#333;
		
		}
		/* Styling Entries */
		.entry{

			background:#efefef;
			padding:10px;
			border:1px solid #ddd;
			line-height:1.5em;
			margin:0 5px 5px 0px;
			width:400px;
			float:left;
			
			-moz-border-radius:10px;
			-webkit-border-radius:10px;
			-khtml-border-radius:10px;
			border-radius:10px;
			
			/*Inner shadow (Won't Validate)*/
			-moz-box-shadow: 2px 2px 3px #ddd; /* FF3.5 */
			-webkit-box-shadow: 2px 2px 3px #ddd; /* Saf3.0 , Chrome */
			box-shadow: 2px 2px 3px #ddd; /* Opera 10.5, IE 9.0 */
			
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#efefef', endColorstr='#dedede'); /* for IE */
				background: -webkit-gradient(linear, left top, left bottom, from(#efefef), to(#dedede)); /* for webkit browsers */
				background: -moz-linear-gradient(top,  #efefef,  #dedede); /* for firefox 3.6+ */
			

		}
		h4{
			margin:3px 0px;
			font-size:1.5em;
			color:#014A8D;
			text-shadow:0 1px 1px #fff;
		}
	</style>
</head>
<body>
	
	<div id="content">
		<h1 id="excelEntries">Hair Salons in Canada</h1>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
		$.getJSON("list.php",
	        function(data){
				var item = data;
				var content = "";
				
	          	for (var i in data) {
		
						// data[row][column] references cell from excel document.
						var name = data[i][1];
						var address = data[i][2];
						var city = data[i][3];
						var province = data[i][4];
						var postal = data[i][5];
						var phone = data[i][6];

					if (i > 1){

						content += "<div class='entry'>"+
						"<h4> "+name+ "</h4>"+
						"<strong>Address:</strong> "+address+"<br />"+
						"<strong>City:</strong> "+city+"<br />"+
						"<strong>Province:</strong> "+province+"<br />"+
						"<strong>Postal Code:</strong> "+postal+"<br />"+
						"<strong>Phone Number:</strong> "+phone+
						"</div>";
					}
	          	
		          };
				$('#content').append(content);
	        });
	</script>

	</body>
	
</body>
</html>