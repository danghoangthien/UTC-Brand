<?php
        require("LinkExtractor.class.php");
        $obj_linkextractor = new LinkExtractor();
        //$url="https://www.google.co.in";
        if(isset($_POST['submit']))
        {
            $geturl=$_POST['url'];          
            $findlink=$_POST['search_url'];   
            $finddomain=$_POST['search_domain'];   
            $url=$obj_linkextractor->FetchUrl($geturl);
         
            echo "<HR><br/>Result<br/><br/>";
            echo "<h3>All Links</h3><hr><br/>";
            $arrayLinks=$obj_linkextractor->GetAllLinks();
            for( $a = 0, $b = count( $arrayLinks );$a<$b; $a++ )
            {
                echo $arrayLinks[$a]."<br />";
            }
			 echo "<h3>All Emails</h3><hr><br/>";
			 $arrayLinks=$obj_linkextractor->GetAllEmails();
            for( $a = 0, $b = count( $arrayLinks );$a<$b; $a++ )
            {
                echo $arrayLinks[$a]."<br />";
            }
            $chkurl=$obj_linkextractor->FindExistLink($findlink);
            echo "<h3>URL Finding</h3><hr><br/>";
            if($chkurl)
            {
                echo "<strong>Given URL Exists.<strong> <br/>";
            }else
            {
                echo $obj_linkextractor->GetError();
            }
           $arrayLinks=$obj_linkextractor->GetDomainNames();
         
            $arrayLinks=(array_values($arrayLinks));

            echo "<h3>All Domain Names</h3><hr><br/>";
            for( $a = 0; $a<count($arrayLinks); $a++ )
            {
                echo $arrayLinks[$a];
                echo "<br/>";
            }
           
  

            $chkdomain=$obj_linkextractor->FindDomainName($finddomain);
            echo "<h3>Domain Name Finding</h3><hr><br/>";
            if($chkdomain)
            {
                echo "<strong>Give Domain Name Exists.<br/></strong>";
            }else
            {
              echo $obj_linkextractor->GetError();
            }
           

           
           
        }       
?>

<form action="<?= $PHP_SELF ?>" method="POST">
<Strong>Url Should begin with http://(for example http://www.google.com)</strong>
<TABLE>
<TR>
    <TD>URL: </TD>
    <TD><input type="text" name="url" value=""/></TD>
</TR>
<TR>
    <TD>Search For URL : </TD>
    <TD><INPUT TYPE="text" NAME="search_url"></TD>
</TR>
<TR>
    <TD>Search For Domain : </TD>
    <TD><INPUT TYPE="text" NAME="search_domain"></TD>
</TR>
<TR>
    <TD><INPUT TYPE="submit" name="submit"></TD>
    <TD><INPUT TYPE="reset"></TD>
</TR>
</TABLE>
<br/><br/>
<br/><br/>


</form> 