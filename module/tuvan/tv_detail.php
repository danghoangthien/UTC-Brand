 <?php
//2 neccessary library
include_once 'htinmotion/orm/adodb5/adodb.inc.php';
include_once 'htinmotion/orm/general/general.php';
$g=new general();
if(isset($_GET["c_id"]))
{$sql="select * from consult where consult_id=".$_GET["c_id"];}
if(isset($_GET["t_id"]))
{
	if(strpos($_GET["t_id"],",")!==false)
	$sql="select * from consult where todaytopic_type_id IN(".$_GET["t_id"].") and content<>'' order by reply_datetime limit 0,1";
	else $sql="select * from consult where todaytopic_type_id=".$_GET["t_id"]." and content<>'' order by reply_datetime limit 0,1";
}
$con=$g->getSQL($sql,0);
if($con[0])
{
	$selected_id=$con[0]["todaytopic_id"];
	$type=$con[0]["todaytopic_type_id"];
	$display="style=''";
	if ($type==LT_ID) {$image="tuvan_menu_luyentap.jpg";}
	if ($type==SP_ID) {$image="tuvan_menu_sanpham.jpg";}
	if ($type==DD_ID || $type==GC_ID){$image="tuvan_menu_ddgc.jpg";}
?>
 	<img src="img/<? echo $image;?>" border="0" usemap="#Map">
        <div class="tuvanhoi">
     		<?php echo $con[0]["title"]; ?>
        </div>
        <div class="tuvandap">
         	<?php echo $con[0]["content"]; ?>
        </div>
        <div class="tuvanngay" >
        <strong>Thời gian hỏi:		</strong> <?php echo $con[0]["consult_datetime"];	?>| 
        <strong>Thời gian trả lời:	</strong> <?php echo $con[0]["reply_datetime"]; 		?>
        </div>
<?php }//end if $con>0?>