<?php
//2 neccessary library
include_once 'htinmotion/orm/adodb5/adodb.inc.php';
include_once 'htinmotion/orm/general/general.php';
include_once 'htinmotion/orm/resources/class.database.php';
include_once 'htinmotion/php-cut-html-string/cutstring.php';
//MODAL
$g=new general();
$sql="select * from consult where todaytopic_type_id IN(".DD_ID.",".LT_ID.",".GC_ID.",".SP_ID.") and content<>'' and status='enable' order by reply_datetime desc limit 0,2 ";
$con=$g->getSQL($sql,0);//print_r($con);
?>
	    </div>              
          <div class="topnews">
        <!--TU VAN / Limit desc: 250 characters-->
        <p>
        <a href="tu-van-chi-tiet.php?c_id=<?php echo $con[0]["consult_id"];?>"><?php echo truncate($con[0]["title"],60," ...",false,true );?></a><br>
    	<?php echo strip_tags(truncate($con[0]["content"],200," ...",false,true ));?>
        </p>
        <hr>
        <p>
        <a href="tu-van-chi-tiet.php?c_id=<?php echo $con[1]["consult_id"];?>"><?php echo truncate($con[1]["title"],60," ...",false,true );?></a><br>
    	<?php echo strip_tags(truncate($con[1]["content"],200," ...",false,true ));?>
        </p>
        <!-- HET TU VAN-->
	    </div>