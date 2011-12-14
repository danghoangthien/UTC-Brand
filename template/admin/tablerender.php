<?php
/*
	@param 1: $field_arr (result from select pattern ex : select aaa as a, bbb as b)
	@param 2: 	$function_arr : $key = "action name" , $value = "action url+parsed id"
				ex: 
				array ("edit topic"=>"page/abs.php?topic_id=")
 */

function generateAdminTableHTML($header_arr,$field_arr,$function_arr,$title="Danh Sach")
{
						$align="valign=\"middle\"";
						$c=count($function_arr);
						$html.= "<h3 style='text-align:center'>$title</h3>";
						$html.= "<table id='myTable' class='tablesorter'>";
						$html.="<thead><tr>";
						foreach($header_arr as $k=>$v)
						{																				
								 $html.="<th style=''>$v</th>";										 																
						}
						if($c>0) $html.="<th colspan=$c >action</th>";	
						$html.="</tr></thead>";												
						$html.= "<tbody>";								
						 foreach($field_arr as $k=>$v)
						{
							$id=$v[0];													
							$html.= "<tr $align>";$y=1;							
							foreach ($v as $key=>$value)
							{
										if(strpos($key,"id")===false)
										{
											$html.= "<td >$value</td>"; 											
										}	
										//else																																	
							}
							//if()
							foreach ($function_arr as $k1=>$v1)
											{
												if($v1=="")
												{
													//$html.= "<td><a id='".$k1."_".$v[0]."' class='$k1' >$k1</a></td>"; 
													$html.= "<td><a id='".$v[0]."' class='$k1' >$k1</a></td>"; 
												}
												else
												{
													$v1.=$id;
													if($_GET["active"])
													$html.= "<td><a href='$v1&active=".$_GET["active"]."'>$k1</a></td>"; 
													else
													$html.= "<td><a  href='$v1'>$k1</a></td>"; 
												}													
											}																							
							$html.= "</tr>";						
						}	
					 
$html.= "</tbody>";		 
$html.= "</table>"	;					
echo $html;
							
							
							
								
}