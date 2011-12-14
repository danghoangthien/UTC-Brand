<?
//$lv="../../";
include_once ($lv."config.php");
include_once $lv.'htinmotion/php-cut-html-string/cutstring.php';
include_once $lv.'htinmotion/orm/adodb5/adodb.inc.php';
include_once $lv.'htinmotion/orm/general/general.php';
$g=new general();
//get latest from 6 category
$lt=$g->getSQL(
	"
	(select * from contest where contest_active='enable' and contest_type=1   limit 0,1)
	union all
	(select * from contest where contest_active='enable' and contest_type=2  limit 0,1)
	union all
	(select * from contest where contest_active='enable' and contest_type=3  limit 0,1)
	union all
	(select * from contest where contest_active='enable' and contest_type=4  limit 0,1)
	union all
	(select * from contest where contest_active='enable' and contest_type=5  limit 0,1)
	order by contest_date desc
	",0);
/*echo "<pre>";
print_r($lt);
echo "</pre>";*/
//$tof["contest_type"]="3";
//print_r  (find_type($lt,$tof));
function find_type($arr,$pair)
{
	$has=-1;
	$key=array_keys($pair);
	$value=$pair[$key[0]];
	foreach($arr as $ak=>$av)
	{
		foreach($av as $k=>$v )
		{
			if($k==$key[0] &&  $v==$value)
			{
				$has=$ak;
			}
		}
		
	}
	return $has;
}
?>