    <?php
    $date1 = "2011-07-09";
    $date2 = time();
     
    $dateArr = explode("-",$date1);
    $date1Int = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]) ;
    echo "$date1Int compare to $date2 difference is ".($date1Int-$date2);
    ?>