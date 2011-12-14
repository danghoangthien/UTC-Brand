<?php
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
			$this->db=mysql_connect($this->host,$this->user,$this->password);
			mysql_select_db($this->database);
		}
		function drawCalendar($mem=-1)//by member_id
		{
			$db_event=$this->db;
			if(isset($_GET['time']))
				$time=$_GET['time'];
			else $time=time();					
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
			$sql="SELECT DATE_FORMAT(eventDate,'%d') AS day,eventDate,eventContent,eventID,eventTitle FROM events WHERE member_id=$mem AND eventDate BETWEEN  '$year/$mon/01' AND '$year/$mon/31'  ";	
			$result=mysql_query($sql,$db_event);
			$events=array();
			while($row_event=mysql_fetch_object($result))
			{
				$row_event->eventTitle=str_replace(array("\r\n", "\r", "\n"), "<br/>", $row_event->eventTitle);
				$row_event->eventContent=str_replace(array("\r\n", "\r", "\n"), "<br/>", $row_event->eventContent);
				$events[intval($row_event->day)].=
			"<span style='color:#81BE2E'>Ngày :</span><span id='edate' style='font-weight:900;padding-left:25px;color:#FF6600'>$row_event->eventDate</span><br/><br/><span style='color:#81BE2E'>Tiêu đề :</span><span id='etitle' style='font-weight:900;padding-left:25px;color:#FF6600'>$row_event->eventTitle</span><br><br><span style='color:#81BE2E'>Nội dung :</span><br/><br/><span id='econtent'>$row_event->eventContent </span>";				
			}
		   $eventCal="";
			$eventCAL.= "<style>\n";
			$eventCAL.= ".event_cls {color:#FF6600; font-weight: bold; text-decoration: none; cursor: hand;}\n";
			$eventCAL.= ".event_head{font-weight:bold;FONT-FAMILY: Verdana, Geneva, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;}\n";
			$eventCAL.= ".event_col{color:#FFF;FONT-FAMILY: Verdana, Geneva, Arial, Helvetica, sans-serif;FONT-SIZE: 10px;height:20px}\n";
			$eventCAL.= ".event_link {TEXT-DECORATION: none; color:#81BE2E}\n";
			$eventCAL.= "</style>";
			$eventCAL.= "<table width='180px' border='0' align='center' cellspacing='1'>\n";
		    $eventCAL.= "<tr class='event_col' align='center'> \n";
			$eventCAL.= "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon,$mday,$year-1)."' title='Previous Year' class='event_link' style='color:#FF6600;font-size:8px'> << </a></b></td>\n";
			$eventCAL.= "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon-1,$mday,$year)."' title='Previous Month' class='event_link' style='color:#FF6600;font-size:8px'> < </a></b></td>\n";
			$eventCAL.= "<td colspan='4' class='event_col'> <b>$month $year</b></td>\n";
			$eventCAL.= "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon+1,$mday,$year)."' title='Next Month' class='event_link'  style='color:#FF6600;font-size:8px'> > </a></b></td>\n";
			$eventCAL.= "<td width='12%'><b><a href='$thisPage?time=".mktime(0, 0, 0, $mon,$mday,$year+1)."' title='Next Year' class='event_link' style='color:#FF6600;font-size:8px'> >> </a></b></td>\n";
			$eventCAL.= "</tr>\n";
			$eventCAL.= "<tr class='event_col' height='20'>\n";
			$eventCAL.= "<td width='12%'>&nbsp;</td>\n";
			$eventCAL.= "<td align='center' width='12%' class='event_head'>Sun</td>\n";
			$eventCAL.= "<td align='center' width='12%' class='event_head'>Mon</td>\n";
			$eventCAL.= "<td align='center' width='12%' class='event_head'>Tue</td>\n";
			$eventCAL.= "<td align='center' width='12%' class='event_head'>Wed</td>\n";
			$eventCAL.= "<td align='center' width='12%' class='event_head'>Thu</td>\n";
			$eventCAL.= "<td align='center' width='12%' class='event_head'>Fri</td>\n";
			$eventCAL.= "<td align='center' width='12%' class='event_head'>Sat</td>\n";
			$eventCAL.= "</tr>\n";
			$eventCAL.= "<script>\n";
			foreach($events as $key => $value)
			$eventCAL.= "evnt$key=\"$value\"\n";
			$eventCAL.= "function showevent(day)\n";
			$eventCAL.= "{";
			$eventCAL.= "	evnt=eval('evnt'+day);\n";
			$eventCAL.= "	mydiv=document.getElementById('content2');\n";
			$eventCAL.= "	mydiv.innerHTML=evnt \n";
			$eventCAL.= "}";
			
			$eventCAL.= "</script>\n";
			for($j=0;$j<6;$j++){ 
			$eventCAL.= "<tr class='event_col'> \n";
			$eventCAL.= "<td width='12%' height='25'>&nbsp;</td>\n";
			for($k=0;$k<7;$k++){ 
			$i++;
			$cls="class='event_col'";
			if(array_key_exists($i,$events))
			$cls="class=event_cls onclick='showevent($i)'";
			$eventCAL.= "<td align='center' width='12%' height='25' $cls>\n";
			$eventCAL.= ($i>0&&$i<=$lastDay)?$i:'';
			$eventCAL.= "</td>";
			}
			$eventCAL.= "</tr>" ; }
			$eventCAL.= "<tr class='event_col'><td colspan=8>&nbsp;</td> </tr>\n";
			$eventCAL.= " <tr > <td colspan=8>\n";
			$eventCAL.= " </td> </tr>	</table>\n";
			return $eventCAL;
		}

		function addEvent($event,$title,$member_id,$eventDate="",$lang='en')
		{
			$db_event=$this->db;
			if(empty($eventDate))
				$eventDate=date('Y-m-d');
			$sql="INSERT INTO events (eventDate,eventTitle,member_id,eventContent,langCode) VALUES('$eventDate','$title','$member_id','$event','$lang')";
			mysql_query($sql,$db_event);
		}

		function updateEvent($event,$title,$member_id,$eventDate="",$lang='en')
		{
			$db_event=$this->db;
			if(!empty($eventDate))
				$evenDate=",eventDate='$eventDate'";
			$sql="UPDATE events set eventContent='$event',eventTitle='$title',member_id='$member_id' $evenDate   WHERE member_id='$member_id' AND eventDate='$eventDate'";	
			
			mysql_query($sql,$db_event);
		}
		
		function delEvent($deleventids)
		{
			$db_event=$this->db;
			$sql="DELETE FROM events WHERE eventID IN ($deleventids)";
			mysql_query($sql,$db_event);
		}	
	}

?>