<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
$MAX_SIZE = 2000000;                      
//Allowable file Mime Types. Add more mime types if you want
$FILE_MIMES = array('image/jpeg','image/jpg','image/gif'
                   ,'image/png','application/msword', 'audio/mpeg'
             ,'audio/basic','audio/midi','audio/x-aiff'.'audio/x-mpegurl'
             ,'audio/x-pn-realaudio','audio/x-wav','video/mpeg','video/quicktime'
             ,'video/vnd.mpegurl','video/x-msvideo','video/x-sgi-movie'
             ,'image/bmp');
//Allowable file ext. names. you may add more extension names.            
$FILE_EXTS  = array('.zip','.jpg','.png','.gif','.bmp','.au ','.snd','.mid','. midi','. rar '
               ,'.mpga','. mp2','. mp3 ','.aif','. aiff','. aifc ','.m3u','.ram','. ra'
               ,'.wav','.wma','.mpeg',' .mpg',' .mpe ','.qt','. mov','.mxu','. m4u'
               ,'.avi','.movie'); 
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	if($_SERVER['SERVER_NAME'] == "localhost"){
		$targetPath = $_SERVER['DOCUMENT_ROOT'] ."/standard_project/". $_REQUEST['folder'] . '/';
	}
	else{
		$targetPath = $_SERVER['DOCUMENT_ROOT']. $_REQUEST['folder'] . '/';
	}
	$ext = findexts ($_FILES['Filedata']['name']) ;
	$rand=date('Y-m-d-H-i-s');
	$rename='pro_'.$rand.'.'.$ext;	
	$targetFile =  str_replace('//','/',$targetPath) .$rename;	
	 $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	 $fileTypes  = str_replace(';','|',$fileTypes);
	 
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		//mkdir(str_replace('//','/',$targetPath), 0755, true);	
		//echo $_REQUEST['folder'];	
		//	return;			 
		if(move_uploaded_file($tempFile,$targetFile)==true)
		{
			chmod($targetFile,0644);//echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);		
			echo  $rename;
			//echo $_REQUEST['folder'];	
			return;
		}
		else {echo 2;return;}
		
		
		//echo $_SERVER['DOCUMENT_ROOT'];
	// } else {
	// 	echo 'Invalid file type.';
	// }
}
//Mmaximum file size. You may increase or decrease.
function findexts ($filename) 
{ 
	$filename = strtolower($filename) ; 
	$exts = split("[/\\.]", $filename) ; 
	$n = count($exts)-1; 
	$exts = $exts[$n];
	 return $exts; 
}  

?>