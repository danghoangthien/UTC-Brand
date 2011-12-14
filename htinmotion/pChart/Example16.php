<?php
 /*
     Example16 : Importing CSV data
 */

 // Standard inclusions   
 include("pChart/pData.class");
 include("pChart/pChart.class");
 include_once ("../../config.php");
 include_once ("../../htinmotion/orm/adodb5/adodb.inc.php");
include_once ("../../htinmotion/orm/general/general.php");
 // Dataset definition 
 $DataSet = new pData;
 $g= new general();
$at=unserialize(ATTEND);
$start=$at["week1"]["start"];
$end=$at["week1"]["end"];
$sql="	SELECT MAX(r.max_point) as highest,MAX(r.turn_datetime) AS latest,um.member_user from record r 
		INNER JOIN urc_member um 
		ON r.member_id=um.member_id
		WHERE r.turn_datetime between '$start' AND '$end'
		GROUP BY r.member_id
		ORDER BY highest DESC LIMIT 0,5";
$countdown=$g->getSQL($sql,0);
foreach($countdown as $c)
{
$DataSet->AddPoint($c["member_user"],"XLabel");  
$DataSet->AddPoint($c["highest"],"Diem so");  
//$DataSet->AddPoint($c["latest"],"Serie3");  
}

 $DataSet->AddAllSeries();
 $DataSet->RemoveSerie("XLabel"); 
    $DataSet->SetAbsciseLabelSerie("XLabel");   
	 
 //$DataSet->SetAbsciseLabelSerie();
 $DataSet->SetYAxisName("diem so");

 // Initialise the graph
 $Test = new pChart(700,230);
// $Test->reportWarnings("GD");
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->setGraphArea(60,30,680,180);
 $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
 $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
 $Test->drawGraphArea(255,255,255,TRUE);
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,90,2);
 $Test->drawGrid(4,TRUE,230,230,230,50);

 // Draw the 0 line
 $Test->setFontProperties("Fonts/tahoma.ttf",6);
 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

 // Draw the line graph
 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);
  $Test->setLineStyle(1,6);
 // Finish the graph
 $Test->setFontProperties("Fonts/tahoma.ttf",8);   
 $Test->drawLegend(590,40,$DataSet->GetDataDescription(),255,255,255);   
 $Test->setFontProperties("Fonts/tahoma.ttf",10);
 $Test->drawTitle(60,22,"Diem so 5 thanh vien cao nhat",50,50,50,585);
 $Test->Render("topfive.png");
?>