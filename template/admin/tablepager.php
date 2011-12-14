<?php
function generatePagerHTML($level_patern)
{
	
$html="<div class='pager' id='pager' style=''>";
$html.="<br/><br/>";
$html.="<form>"	;
$html.="<img class='first' src=$level_patern"."image/first.png>"	;	
$html.="<img class='prev' src=$level_patern"."image/prev.png>"	;
$html.="<input type='text' class='pagedisplay'>";
$html.="<img class='next' src=$level_patern"."image/next.png>"	;
$html.="<img class='last' src=$level_patern"."image/last.png>"	;				
$html.="<select class='pagesize'>";						
$html.="<option value='10' selected='selected'>10</option>";	
$html.="<option value='20'>20</option>";	
$html.="<option value='30'>30</option>";		
$html.="<option value='40'>40</option>";					
$html.="</select></form></div>";						

echo $html;
							
							
							
								
}