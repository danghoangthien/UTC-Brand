<?php

	/*

		Calendar Events
		Date - Jan 14, 2005
		Author - Harish Chauhan	

		ABOUT
		This PHP script will generate HTML for calendar and manage and display 
		the events on specific dates
		
	*/

	//include_once("db.inc.php");

	Class CALEVENTS
	{
		var $host;
		var $user;
		var $password;
		var $database;
		var $db=NULL;
		
		function CALEVENTS($host=HOST,$user=USERNAME,$password=PASS,$database=DATABASE)
		{
			$this->setInfo($host,$user,$password,$database);
		}

		function setInfo($host,$user,$password,$database)
		{
			$this->host=$host;
			$this->user=$user;
			$this->password=$password;
			$this->database=$database;
			//$this->db=new DB();
			//$this->db->open($this->host,$this->user,$this->password,$this->database);
			$this->db=mysql_connect($this->host,$this->user,$this->password);
			mysql_select_db($this->database);
		}

		function drawCalendar()
		{
			$db_event=$this->db;

			if(isset($_GET['time']))
				$time=$_GET['time'];
			else
				$time=time();
			
			$today = getdate($time); 
			$mday = $today ['mday'];
			$mon  = $today ['mon'];   
			$year  = $today ['year'];  

			$time = mktime(0, 0, 0, $mon,1,$year);
			$today = getdate($time); 
			$wday  = $today ['wday'];  
			$year  = $today ['year'];  
			$weekday = $today ['weekday'];
			$month  = $today ['month'];
			$i= -$wday;
			$thisPage=$_SERVER['PHP_SELF'];
			$time = mktime(0, 0, 0, $mon+1,0,$year);
			$lastDay=date('j',$time);
			$sql="SELECT DATE_FORMAT(eventDate,'%d') AS day,eventContent,eventID,eventTitle FROM events WHERE eventDate BETWEEN  '$year/$mon/01' AND '$year/$mon/31'";	
			//$db_event->query($sql);
			$result=mysql_query($sql,$db_event);
			$events=array();
			
			//while($row_event=$db_event->fetchObject())
			//	$events[intval($row_event->day)].=$row_event->eventContent."<br><br>";
			while($row_event=mysql_fetch_object($result))
			{$events[intval($row_event->day)].=$row_event->eventTitle."<br><br>";
			$events[intval($row_event->day)].="$row_event->eventContent";
			}
		
			echo "<style>\n";
			echo ".event_cls {background-color: #04ADFF;color:#FFFFDD; font-weight: bold; text-decoration: none; cursor: hand;}\n";
			echo ".event_head{background-color: #99CC00;font-weight:bold;FONT-FAMILY: Verdana, Geneva, Arial, Helvetica, sans-serif;FONT-SIZE: 11px;}\n";
			echo ".event_col{background-color:#FFE4AE;color:#000095;FONT-FAMILY: Verdana, Geneva, Arial, Helvetica, sans-serif;FONT-SIZE: 11px;height:25px}\n";
			echo ".event_link {TEXT-DECORATION: none; color:#0DB0FF;}\n";
			echo "</style>";
			echo "<table width='344' border='0' align='center' cellspacing='1'>\n";
		    echo "<tr class='event_col' align='center'> \n";
			echo "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon,$mday,$year-1)."' title='Previous Year' class='event_link'>««</a></b></td>\n";
			echo "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon-1,$mday,$year)."' title='Previous Month' class='event_link'>«</a></b></td>\n";
			echo "<td colspan='4' class='event_col'> <b>$month $year</b></td>\n";
			echo "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon+1,$mday,$year)."' title='Next Month' class='event_link'>»</a></b></td>\n";
			echo "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon,$mday,$year+1)."' title='Next Year' class='event_link'>»»</a></b></td>\n";
			echo "</tr>\n";
			echo "<tr class='event_col' height='25'>\n";
			echo "<td width='12%'>&nbsp;</td>\n";
			echo "<td align='center' width='12%' class='event_head'>Sun</td>\n";
			echo "<td align='center' width='12%' class='event_head'>Mon</td>\n";
			echo "<td align='center' width='12%' class='event_head'>Tue</td>\n";
			echo "<td align='center' width='12%' class='event_head'>Wed</td>\n";
			echo "<td align='center' width='12%' class='event_head'>Thu</td>\n";
			echo "<td align='center' width='12%' class='event_head'>Fri</td>\n";
			echo "<td align='center' width='12%' class='event_head'>Sat</td>\n";
			echo "</tr>\n";
			echo "<script>\n";
			foreach($events as $key => $value)
			echo "evnt$key=\"$value\"\n";

			echo "function showevent(day)\n";
			echo "{";
			echo "	evnt=eval('evnt'+day);\n";
			echo "	mydiv=document.getElementById('event');\n";
			echo "	mydiv.innerHTML=evnt\n";
			echo "}";
			
			echo "</script>\n";
			for($j=0;$j<6;$j++){ 
			echo "<tr class='event_col'> \n";
			echo "<td width='12%' height='25'>&nbsp;</td>\n";
			for($k=0;$k<7;$k++){ 
			$i++;
			$cls="class='event_col'";
			if(array_key_exists($i,$events))
			$cls="class=event_cls onclick='showevent($i)'";
			echo "<td align='center' width='12%' height='25' $cls>\n";
			echo ($i>0&&$i<=$lastDay)?$i:'';
			echo "</td>";
			}
			echo "</tr>" ; }
			echo "<tr class='event_col'><td colspan=8>&nbsp;</td> </tr>\n";
			echo " <tr > <td colspan=8>\n";
			echo " <div id='event' style=' z-index:1000; left: 395px; top: 192px;'></div></td> </tr>	</table>\n";
		}

		function addEvent($event,$title,$member_id,$eventDate="",$lang='en')
		{
			$db_event=$this->db;
			if(empty($eventDate))
				$eventDate=date('Y-m-d');
			$sql="INSERT INTO events (eventDate,eventTitle,member_id,eventContent,langCode) VALUES('$eventDate','$title','$member_id','$event','$lang')";
			//$db_event->query($sql);
			mysql_query($sql,$db_event);
		}

		function updateEvent($event,$title,$member_id,$eventid,$eventDate="",$lang='en')
		{
			$db_event=$this->db;
			if(!empty($eventDate))
				$evenDate=",eventDate='$eventDate'";
			$sql="UPDATE events set eventContent='$event',eventTitle='$title',member_id='$member_id' $evenDate WHERE eventID='$eventid'";	
			//$db_event->query($sql);
			mysql_query($sql,$db_event);
		}
		
		function delEvent($deleventids)
		{
			$db_event=$this->db;
			$sql="DELETE FROM events WHERE eventID IN ($deleventids)";
			//$db_event->query($sql);
			mysql_query($sql,$db_event);
		}
	

	}

?>