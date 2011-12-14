</div><!-- #container-->
<div class="sidebar" id="sideLeft">			
<div class="article">
    <!-- Accordion -->     		
	<?php 					
					$general=new general();
					$arr=$general->getSQL("select *  from admin_navigation where navi_parent_id='0' and navi_id!='84' order by navi_index");
	?>	
	<div id="accordion">
	<?php 
					//print_r ($arr); 
					 foreach($arr as $k=>$v)
					{
						$id=$v["navi_id"];
						$navi_name=$v["navi_name"];
						$navi_url=$v["navi_url"];
						$navi_index=$v["navi_index"];						
						echo "<div><h3><a href='$navi_url'>$navi_name</a></h3><div><ul>";						
						$arr2=$general->getSQL("select *  from admin_navigation where navi_parent_id='$id' order by navi_index");
						 foreach($arr2 as $k2=>$v2)
						{
							$id2=$v2["navi_id"];
							$navi_name2=$v2["navi_name"];
							$navi_url2=$v2["navi_url"];
							$navi_index2=$v2["navi_index"];
							if (strpos($navi_url2, '?') !== false) 
								echo "<li><a href='../../../$navi_url2&active=$navi_index'>$navi_name2</a></li>";	
							else
								echo "<li><a href='../../../$navi_url2?active=$navi_index'>$navi_name2</a></li>";	
						}
						echo "</ul></div></div>";												
					}	
	?> 	   
	</div>  		   
		   <!-- END Accordion -->   
		<div id="datepicker"></div>


  </div>	<!-- END article -->   		
</div><!-- .sidebar#sideLeft -->
</div><!-- #middle-->
<?php ?>
