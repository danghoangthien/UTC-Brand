<?php
require_once '../../config.php';
require_once 'ExcelReader.php';
$data = new ExcelReader("quiz_pattern9.xls",true);
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
include_once '../../htinmotion/php-cut-html-string/cutstring.php';
require_once('../../htinmotion/unicode/unicode.class.php');
header ( 'Content-type: text/html; charset=UTF-8' );
$ary = $data->dumptoarray();
echo $ary[2][3];
$g= new general();
$g->executeSQL("insert into quiztopic (quiztopic_content) value('".iconv("Windows-1252","utf-16le",$ary[2][3])."')");

$data = "<span style='color:green;'>Cần thiết lắm chứ, bạn sẽ ăn thật đầy đủ nhưng không quá no. Nếu không ăn sáng thì bạn chẳng thể nào tập trung vào công việc tốt được</span>";
$wanted_count = 110; 
//echo truncate($data,$wanted_count," ---",false,true );
$text_utf16 = unicode::utf8_to_utf16("Simple text with japanese character", false);
$text_utf8 = unicode::utf16_to_utf8("Simple text with japanese character",false);
echo $text_utf8."<br/>";
return;
$json = json_encode($ary);


print $json;
