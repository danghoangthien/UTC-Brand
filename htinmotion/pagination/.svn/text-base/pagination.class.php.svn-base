<?php
/****
File name : pagination.class.php
Description : Class file which creates the pagination .
Author : Shijith. M
Date : 6th August 2008
****/
class pagination {

	var $fullresult;    // record set that contains whole result from database
	var $totalresult;   // Total number records in database
	var $query;         // User passed query
	var $resultPerPage; //Total records in each pages
	var $resultpage;	// Record set from each page
	var $pages;			// Total number of pages required
	var $openPage;		// currently opened page
	
/*
@param - User query
@param - Total number of result per page
*/
	function createPaging($query,$resultPerPage) 
	{
		$conn=mysql_connect(HOST, USERNAME, PASS);
		mysql_select_db(DATABASE,$conn);
		$this->query		=	$query;
		$this->resultPerPage=	$resultPerPage;
		$this->fullresult	=	mysql_query($this->query);
		$this->totalresult	=	mysql_num_rows($this->fullresult);
		$this->pages		=	$this->findPages($this->totalresult,$this->resultPerPage);
		if(isset($_GET['page']) && $_GET['page']>0) {
			$this->openPage	=	$_GET['page'];
			if($this->openPage > $this->pages) {
				$this->openPage	=	1;
			}
			$start	=	$this->openPage*$this->resultPerPage-$this->resultPerPage;
			$end	=	$this->resultPerPage;
			$this->query.=	" LIMIT $start,$end";
		}
		elseif($_GET['page']>$this->pages) {
			$start	=	$this->pages;
			$end	=	$this->resultPerPage;
			$this->query.=	" LIMIT $start,$end";
		}
		else {
			$this->openPage	=	1;
			$this->query .=	" LIMIT 0,$this->resultPerPage";
		}
		$this->resultpage =	mysql_query($this->query);
	}
/*
function to calculate the total number of pages required
@param - Total number of records available
@param - Result per page
*/
	function findPages($total,$perpage) 
	{
		$pages	=	intval($total/$perpage);
		if($total%$perpage > 0) $pages++;
		return $pages;
	}
	
/*
function to display the pagination
*/
	function displayPaging($id,$id_label) 
	{
		$self	=	$_SERVER['PHP_SELF'];
		//echo $self;
		if($this->openPage<=0) {
			$next	=	2;
		}

		else {
			$next	=	$this->openPage+1;
		}
		$prev	=	$this->openPage-1;
		$last	=	$this->pages;

		if($this->openPage > 1) {
			echo "<a href=$self?page=1"."&".$id_label."=$id>&lt;&lt;</a>&nbsp&nbsp;";
			echo "<a href=$self?page=$prev"."&".$id_label."=$id>&lt;</a>&nbsp&nbsp;";
		}
		else {
			echo "&lt;&lt;&nbsp&nbsp;";
			echo "&lt;&nbsp&nbsp;";
		}
		for($i=1;$i<=$this->pages;$i++) {
			if($i == $this->openPage) 
				echo "<a class='pg_current' style='color:#FF6600'>$i &nbsp&nbsp;</a>";
			else
				echo "<a  href=$self?page=$i"."&".$id_label."=$id>$i</a>&nbsp&nbsp;";
		}
		if($this->openPage < $this->pages) {
			echo "<a href=$self?page=$next"."&".$id_label."=$id>&gt;</a>&nbsp&nbsp;";
			echo "<a href=$self?page=$last"."&".$id_label."=$id>&gt;&gt;</a>&nbsp&nbsp;";
		}
		else {
			echo "&gt;&nbsp&nbsp;";
			echo "&gt;&gt;&nbsp&nbsp;";
		}	
	}
function displayPagingAjax($id,$id_label,$page,$result="result") 
	{
		$self	=	"$page";
		if(strpos($self,"?")!==false) 
		{$self=$self."&";}
		else $self=$self."?";
		
		//echo $self;
		if($this->openPage<=0) {
			$next	=	2;
		}

		else {
			$next	=	$this->openPage+1;
		}
		$prev	=	$this->openPage-1;
		$last	=	$this->pages;

		if($this->openPage > 1) {
			echo "<a onclick=\"ajaxLoadContent('".$self."page=1"."&".$id_label."=$id','".$result."')\" >&lt;&lt;</a>&nbsp&nbsp;";
			echo "<a onclick=\"ajaxLoadContent('".$self."page=$prev"."&".$id_label."=$id','".$result."')\" > &lt; </a>&nbsp&nbsp;";
		}
		else {
			echo "&lt;&lt;&nbsp&nbsp;";
			echo "&lt;&nbsp&nbsp;";
		}
		for($i=1;$i<=$this->pages;$i++) {
			if($i == $this->openPage) 
				echo "<a class='pg_current' style='color:#FF6600'>$i </a>&nbsp&nbsp;";
			else
				echo "<a onclick=\"ajaxLoadContent('".$self."page=$i"."&".$id_label."=$id','".$result."')\" >$i</a>&nbsp&nbsp;";
		}
		if($this->openPage < $this->pages) {
			echo "<a onclick=\"ajaxLoadContent('".$self."page=$next"."&".$id_label."=$id','".$result."')\" > > </a>&nbsp&nbsp;";
			echo "<a onclick=\"ajaxLoadContent('".$self."page=$last"."&".$id_label."=$id','".$result."')\" > >> </a>&nbsp&nbsp;";
		}
		else {
			echo "&gt;&nbsp&nbsp;";
			echo "&gt;&gt;&nbsp&nbsp;";
		}	
	}
}
?>