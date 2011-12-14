<?
include "htinmotion/orm/adodb5/adodb.inc.php";
include "htinmotion/orm/general/general.php";
//session_unset();
if(!$_SESSION["turn"]){ echo "<script>location.href='index.php'</script>";return;}
if(isset($_SESSION["turn"]["in"])){echo "<script>location.href='results.php?'</script>";return;}
$_SESSION["turn"]["in"]=0;
unset($_SESSION["turn"]["log"]);
unset($_SESSION["turn"]["correct"]);
unset($_SESSION["turn"]["time"]);
$_SESSION["turn"]["dt"]=date("Y-m-d H:i:s");
$_SESSION["turn"]["week"]=CURRENT_WEEK;
$_SESSION["start"]=time();
$g=new general();
$partner_enroll["enroll_email"]			=$_SESSION["turn"]["email"];
$partner_enroll["enroll_dt"]			=$_SESSION["turn"]["dt"];
$partner_enroll["enroll_total_time"]	=$_SESSION["turn"]["time"];
$partner_enroll["enroll_total_answer"]	=0;
$partner_enroll["enroll_total_correct"]	=0;
$partner_enroll["week"]					=$_SESSION["turn"]["week"];
$g->executeInsert("partner_enroll",$partner_enroll,"");
$total=$g->getSQL("select count(*) as total from quiz where ".CURRENT_WEEK."='yes' " ,0);
$page=ceil($total[0]["total"]/3);
$selected=array();
for( $i=0;$i<$page;$i++)
{
	$start=$i*3;
	$arr[$i]=$g->getSQL("select * from quiz where ".CURRENT_WEEK."='yes'  limit $start,3" ,0);
}
function getAns($quiz_id){
	$g=new general();
	$ans=$g->getSQL("select * from quizanswer where quiz_id='".$quiz_id."' ORDER BY RAND()",0);
	return $ans;
}
?>
<script type="text/javascript">
$(document).ready(function(){

});
</script>
 