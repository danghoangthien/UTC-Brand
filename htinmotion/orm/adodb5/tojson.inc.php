<?php
/**
 * Creates JSON ( http://www.json.org/ ) from the ADODB record set
 *
 * @param 	object 		$rs 		- record set object
 * @param 	bool		$moveFirst	- determines whether recordset is returned to first record
 * @return 	string		$output		- resulting json string
 * @version V1.0  10 June 2006  (c) 2006 Rich Zygler ( http://www.boringguys.com/ ). All rights reserved.
 *
 *	Released under both BSD license and Lesser GPL library license. You can choose which license
 *	you prefer.
	
	Example output from query  "SELECT Name, Continent From Country LIMIT 10;"
	
	{"rows":[
		{"row":{"Name":"Afghanistan","Continent":"Asia"}},
		{"row":{"Name":"Netherlands","Continent":"Europe"}},
		{"row":{"Name":"Netherlands Antilles","Continent":"North America"}},
		{"row":{"Name":"Albania","Continent":"Europe"}},
		{"row":{"Name":"Algeria","Continent":"Africa"}},
		{"row":{"Name":"American Samoa","Continent":"Oceania"}},
		{"row":{"Name":"Andorra","Continent":"Europe"}},
		{"row":{"Name":"Angola","Continent":"Africa"}},
		{"row":{"Name":"Anguilla","Continent":"North America"}},
		{"row":{"Name":"Antigua and Barbuda","Continent":"North America"}}
	]}

*/

function rs2json($rs, $moveFirst = false)
{
	if (!$rs) {
		printf(ADODB_BAD_RS,'rs2json');
		return false;
	}

	$output = '';
	$rowOutput = '';
	
	$output .= '{"rows":';
	$totalRows = $rs->numRows();
	if($totalRows > 0)
	{
		$output .= '[';
		$rowCounter = 1;
		while ($row = $rs->fetchRow())
		{
			
			$rowOutput .= '{"row":{';
			
			$cols = count($row);
			$colCounter = 1;
			foreach ($row as $key => $val)
			{
				$rowOutput .= '"' . $key . '":';
				$rowOutput .= '"' . trim($val) . '"';
				
				if ($colCounter != $cols)
				{
					$rowOutput .= ',';
				}
				$colCounter++;
			}
			
			$rowOutput .= '}}';
			
			if ($rowCounter != $totalRows)
			{
				$rowOutput .= ',';
			}
			$rowCounter++;
		}
		$output .= $rowOutput . ']';
	}
	else 
	{
		$output .= '"row"';
	}
	
	$output .= '}';
	

	if ($moveFirst)
	{
		$rs->MoveFirst();
	}
	return $output;
}


?>