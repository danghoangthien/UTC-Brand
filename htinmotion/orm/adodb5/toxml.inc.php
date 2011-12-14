<?php

/**
 * Creates XML from the ADODB record set
 *
 * @param 	object 		$rs 		- record set object
 * @param 	bool		$moveFirst	- determines whether recordset is returned to first record
 * @return 	string		$xml		- resulting xml
 * @version V1.0  10 June 2006  (c) 2006 Rich Zygler ( http://www.boringguys.com/ ). All rights reserved.
 *
 *	Released under both BSD license and Lesser GPL library license. You can choose which license
 *	you prefer.
 */

function rs2xml($rs, $moveFirst = false)
{
	if (!$rs) {
		printf(ADODB_BAD_RS,'rs2xml');
		return false;
	}

	$xml = '';
	$totalRows = 0;

	$totalRows = $rs->numrows();
		
	$domxml = new DOMDocument('1.0', 'utf-8');
	$root = $domxml->appendChild($domxml->createElement('rows'));
	$root->setAttribute('total-rows', $totalRows);
	
	$row_count = 1;
	while($line = $rs->fetchRow())
	{
		$row = $root->appendChild($domxml->createElement('row'));

		foreach ($line as $col_key => $col_val)
		{
			$col = $row->appendChild($domxml->createElement('column'));
			$col->setAttribute('name', strtolower($col_key));
			$col->appendChild($domxml->createTextNode($col_val));
		}
		$row_count++;	
	}	
	$domxml->formatOutput = true;
	$xml = $domxml->saveXML();
	$domxml = null;	
	
	if ($moveFirst)
	{
		$rs->MoveFirst();
	}
	return $xml;		
}


?>