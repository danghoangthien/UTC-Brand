<?php
require_once 'excel_reader2.php';
/**
* Adds Function to excel reader class
*/
class ExcelReader extends Spreadsheet_Excel_Reader
{
	
	function dumptoarray($sheet=0) {
		$arr = array();

		for($row=1;$row<=$this->rowcount($sheet);$row++) {
			
			for($col=1;$col<=$this->colcount($sheet);$col++){
				
				$arr[$row][$col] = htmlentities($this->val($row,$col,$sheet));
				
			}
			
		}

		return $arr;
	}
	
	function _format_value($format,$num,$f) {
			// 49==TEXT format
			// http://code.google.com/p/php-excel-reader/issues/detail?id=7
			if ( (!$f && $format=="%s") || ($f==49) || ($format=="GENERAL") ) { 
				return array('string'=>$num, 'formatColor'=>null); 
			}

			// Custom pattern can be POSITIVE;NEGATIVE;ZERO
			// The "text" option as 4th parameter is not handled
			$parts = split(";",$format);
			$pattern = $parts[0];
			// Negative pattern
			if (count($parts)>2 && $num==0) {
				$pattern = $parts[2];
			}
			// Zero pattern
			if (count($parts)>1 && $num<0) {
				$pattern = $parts[1];
				$num = abs($num);
			}

			$color = "";
			$matches = array();
			$color_regex = "/^\[(BLACK|BLUE|CYAN|GREEN|MAGENTA|RED|WHITE|YELLOW)\]/i";
			if (preg_match($color_regex,$pattern,$matches)) {
				$color = strtolower($matches[1]);
				$pattern = preg_replace($color_regex,"",$pattern);
			}

			// In Excel formats, "_" is used to add spacing, which we can't do in HTML
			$pattern = preg_replace("/_./","",$pattern);

			// Some non-number characters are escaped with \, which we don't need
			$pattern = preg_replace("/\\\/","",$pattern);

			// Some non-number strings are quoted, so we'll get rid of the quotes
			$pattern = preg_replace("/\"/","",$pattern);

			// TEMPORARY - Convert # to 0
			$pattern = preg_replace("/\#/","0",$pattern);

			// Find out if we need comma formatting
			$has_commas = preg_match("/,/",$pattern);
			if ($has_commas) {
				$pattern = preg_replace("/,/","",$pattern);
			}

			// Handle Percentages
			if (preg_match("/\d(\%)([^\%]|$)/",$pattern,$matches)) {
				$num = $num * 100;
				$pattern = preg_replace("/(\d)(\%)([^\%]|$)/","$1%$3",$pattern);
			}
			
		
			//Handle Phone Numbers
			$phone_regex = "/\((\d{3})\) (\d{3})-(\d{4})/";
			if (preg_match($phone_regex,$pattern,$matches)) {

				$left = $matches[1];
				$middle = $matches[2];
				$right = $matches[3];
				$formatted = "(".substr($num,0,3).") ".substr($num,3,3)."-".substr($num,6,4);

				$pattern = preg_replace($phone_regex, $formatted, $pattern);
			}
			
			return array(
				'string'=>$pattern,
				'formatColor'=>$color
			);
			
			// Handle the number itself
			$number_regex = "/(\d+)(\.?)(\d*)/";

			if (preg_match($number_regex,$pattern,$matches)) {
				$left = $matches[1];
				$dec = $matches[2];
				$right = $matches[3];
				if ($has_commas) {
					$formatted = number_format($num,strlen($right));
				}
				else {
					$sprintf_pattern = "%1.".strlen($right)."f";
					$formatted = sprintf($sprintf_pattern, $num);
				}
				$pattern = preg_replace($number_regex, $formatted, $pattern);

			}

			return array(
				'string'=>$pattern,
				'formatColor'=>$color
			);
	}
}

?>