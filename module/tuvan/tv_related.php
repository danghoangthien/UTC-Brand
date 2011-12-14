<?php 
include_once 'htinmotion/orm/adodb5/adodb.inc.php';
include_once 'htinmotion/orm/general/general.php';
if($type)
{
$sql_related = "select * from consult where todaytopic_type_id=$type and content<>'' order by reply_datetime desc limit 0,5";
$con=$g->getSQL($sql_related,0);
if ($type==LT_ID) {$image2="tuvan_luyentap2.jpg";}
if ($type==SP_ID) {$image2="tuvan_sanpham2.jpg";}
if ($type==DD_ID || $type==GC_ID){$image2="tuvan_ddgc2.jpg";}
?>  
  <div align="center"><img src="img/tuvan_cauhoikhac.jpg"></div>
        <a href="#"><img src="img/<? echo $image2;?>" width="280" height="170"></a>
        <div class="news">
        <a href="tu-van-chi-tiet.php?c_id=<? echo $con[0]["consult_id"]?>"><? echo $con[0]["title"]?></a>
        </div>
         <div class="news">
        <a href="tu-van-chi-tiet.php?c_id=<? echo $con[1]["consult_id"]?>"><? echo $con[1]["title"]?></a>
        </div>
         <div class="news">
        <a href="tu-van-chi-tiet.php?c_id=<? echo $con[2]["consult_id"]?>"><? echo $con[2]["title"]?></a>
        </div>
         <div class="news">
        <a href="tu-van-chi-tiet.php?c_id=<? echo $con[3]["consult_id"]?>"><? echo $con[3]["title"]?></a>
        </div>
         <div class="news">
        <a href="tu-van-chi-tiet.php?c_id=<? echo $con[4]["consult_id"]?>"><? echo $con[4]["title"]?></a>
        </div>
        
    <?php }//end if $type?> 