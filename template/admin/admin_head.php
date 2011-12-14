<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title></title>
	<meta name="title" content="" />	
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="../../../css/style.css" type="text/css" media="screen, projection"/><!--[if lte IE 6]><link rel="stylesheet" href="css/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->
    <link href="../../../css/redmond/jquery-ui-1.8.4.custom.css" rel="stylesheet"  type="text/css" />
	<link href="../../../css/form.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/theme.css" rel="stylesheet" type="text/css" />	
    <link type="text/css" media="screen" href="../../../js/facebox/facebox.css" rel="stylesheet"/>
	  <script type="text/javascript" src="../../../js/jquery.js"></script>
      <script type="text/javascript" src="../../../js/jquery.url2.js"></script>
	  <script type="text/javascript" src="../../../js/jquery.jqDock.min.js" ></script>	
	  <script type="text/javascript" src="../../../js/jquery-ui-1.8.4.custom.min.js"></script>  
      <script type="text/javascript" src="../../../js/facebox/facebox.js"></script> 
	  <script type="text/javascript" src="../../../js/tablesorter.js"></script>  
	  <script type="text/javascript" src="../../../js/tablesorterpager.js"></script>  
	
		<script type="text/javascript">
			function cs(title,msg)
			{
     		 console.log("%s: %o", title+":"+msg, this);
			 return this;
			 

			}
          function getURLParam(strParamName) {
              var strReturn = "";
              var strHref = window.location.href;
              if (strHref.indexOf("?") > -1) {
                  var strQueryString = strHref.substr(strHref.indexOf("?")).toLowerCase();
                  var aQueryString = strQueryString.split("&");
                  for (var iParam = 0; iParam < aQueryString.length; iParam++) {
                      if (
                      aQueryString[iParam].indexOf(strParamName.toLowerCase() + "=") > -1) {
                          var aParam = aQueryString[iParam].split("=");
                          strReturn = aParam[1];
                          break;
                      }
                  }
              }
              return unescape(strReturn);
          }
          function ajaxLoadContent(loadUrl, divID) {
              $("#" + divID).html("loading data .....");  
              $("#"+divID).load(loadUrl, function(responseText) {
              $("#"+divID).html(responseText);
              });
          }
          /*
          function getURLParam(name) {
              name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
              var regexS = "[\\?&]" + name + "=([^&#]*)";
              var regex = new RegExp(regexS);
              var results = regex.exec(window.location.href);
              if (results == null)
                  return "no";
              else
                  return results[1];
          }
          */
          function popUp(title) { $('#dialog').dialog({ title: title }).dialog('open'); return false; }

          function popUpCart(title, selector) { $(selector).dialog({ title: title }).dialog('open'); return false; }
          function popUpToolbar(title, selector) {
              $(".toolbarButton").button({
                  icons: {
                      primary: 'ui-icon-circle-arrow-e'
                  }
              });
              $('.dialogtoolbar').dialog({
                  autoOpen: false,
                  width: 400,
                  modal: true,
                  buttons: { "Close": function() { $(this).dialog("close"); } }
              }); //end dialog
           selector.dialog({ title: title }).dialog('open'); return false; }  
  
            


          $(function() {
              // Accordion
              $("#accordion").accordion({ header: "h3", autoHeight: false });
              var active = getURLParam("active");
              if (active != "no") { $("#accordion").accordion("option", "active", parseInt(active)); }

              $("#accordion ul li").button({
              icons: { secondary: 'ui-icon-gear' }
          });
          $(".toolbarButton").button({
              icons: {
                  primary: 'ui-icon-circle-arrow-e'
              }
          });
              // Dialog
              $('#dialog').dialog({
                  autoOpen: false,
                  width: 550,
                  modal: true,
                  buttons: { "Close": function() { $(this).dialog("close"); } }
              }); //end dialog
            

          })//end jquery function
          //admin button

          $(function() {
              $("#mixdock button:first")
		.button({
		    icons: { primary: 'ui-icon-suitcase' }
		})
		.next().button({
		    icons: { primary: 'ui-icon-pencil' }
		})
		.next().button({
		    icons: { primary: 'ui-icon-pencil' }
		})
		.next().button({
		    icons: { primary: 'ui-icon-arrowthick-1-e' }
		})
		.next().button({
		    icons: { primary: 'ui-icon-arrowthick-1-e' }
		});
			
              $("#formSection h2")
		.button({
		    icons: { primary: 'ui-icon-gear' }
		}).css("margin-left", "145px");

              $("#formSection button")
		.button({
		    icons: { primary: 'ui-icon-circle-check' }
		});
        
		$("#myTable a").button({
		    icons: { primary: 'ui-icon-circle-check' }
		});


          });

          //datetime picker
          $(function() {
              $("#datepicker").datepicker();
              $("#datepicker div").css("width", "220px");
              $(".ui-datepicker-title").css("width", "120px");
              $(".ui-datepicker-month").css("text-align", "left");
              $("#frontpage-articles a").css("margin-right", "0px");
              
              
          });
          //table sorter
          $(document).ready(function() 
      		    { 
      		        $("#myTable").tablesorter( {widgets: ['zebra']})
      		          		     .tablesorterPager({container: $("#pager")});        
      		    } 
      		); 
  		// admin form section
      
      </script>
</head>
<?php ?>