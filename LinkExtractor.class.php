<?php
/*
    Author :- Hastimal C. Shah

    Link Extractor class
 
    Objective: To extract all links, domain names, emails from a given url.

    Make different function for different task

    Function 1: This should return all unique links in an array                          ===  COMPLETED
    Function 2: This should return all unique domain names in the page                   ===  COMPLETED
    Function 3: This should return all email addresses in the page                       ===  COMPLETED
    Function 4: This should check if a particular link exists in the page or not         ===  COMPLETED
    Function 5: This should check if a particular Domain exists or not in the page       ===  COMPLETED

    Enchancement work to do
        1) Validation is pending.             === COMPLETED
        2) GET All Email address is pending.  === COMPLETED

*/
class LinkExtractor
{
   
    var $mLinkReg = Array("/(?i)<a([^\a]+?)href='([^\a]+?)'/i",
                          "/(?i)<a([^\a]+?)href=\"([^\a]+?)\"/i",
                          "/(?i)<a([^\a]+?)href=([^\a]+?)[ |>]/i"
                            );
    var $mContent ='';
    var $mUrlToFetch ;
    var $mError='';
    var $mHostName='';
    var $gLinkExtractor_linkRecipient = array();
    var $mEmail=Array();
    var $mDomainName=Array();
    var $mAllLinks = array();

       
    function LinkExtractor($url="") // In Constructor global array is declared to store all links.
    {
       
        if( "" != $url)
        {
            $this->mAllLinks = $this->FetchUrl($url);
        }
    }

  // This function extract urls from a given url;
    function FetchUrl($url)
    {        
        $this->mUrlToFetch=$url;
        if(true==$this->_ValidateUrl($this->mUrlToFetch))
        {
            if( $fp = fopen( $this->mUrlToFetch, "r" ) )
            {
                while( $text = fread( $fp, 8192 ) )
                {
                    $this->mContent .= $text;
                }
                fclose( $fp );
                $referer = parse_url($this->mUrlToFetch);
                //$this->mHostName = $referer['scheme'];
                //$this->mHostName .= "://";
                $this->mHostName .= $referer['host'];
                preg_replace_callback($this->mLinkReg,Array(&$this,'__PushLinkToArray'),$this->mContent);
                return true;
            }
            else
            {
                $this->mError="File Opening Error";   
                return false;
            }
         }else
         {
            $this->mError="Invalid URL. ";
            return false;
         }
    }
   
    function FetchAllEmail($url)
    {   
        $this->mUrlToFetch=$url;
        if(true==$this->_ValidateUrl($this->mUrlToFetch))
        {
            if( $fp = fopen( $url, "r" ) )
            {
                while( $text = fread( $fp, 8192 ) )
                {
                    $this->mContent .= $text;
                }
                $this->mContent = htmlentities($this->mContent);
                fclose( $fp );
                   
                $res = preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",
                 $this->mContent,$matches);

                if ($res)
                {
                     foreach(array_unique($matches[0]) as $email)
                    {
                        $this->mEmail[]=$email;
                    }
                }
                else
                {
                    $this->mError="No Email Found ";
                    return;
                }     
                return true;   
           }
           else
           {
                return false;
           }
        }else
        {
            $this->mError="Invalid URL. ";
            return false;
        }
    }

// This function returns the Link Array;
    function GetAllLinks()
    {
        $referer;
        $linkarray=array();

        for($a=0;$a<count($this->gLinkExtractor_linkRecipient);$a++)
        {   
            $referer=parse_url($this->gLinkExtractor_linkRecipient[$a]);
           
            if(empty($referer['scheme']))
            {
               
                if(!empty($referer['path']))
                {
                    $linkarray[$a]="http://";
                    if(empty($referer['host']))
                    {
                        $linkarray[$a].=$this->mHostName;
                    }
                    else
                    {
                        if(!empty($referer['path']))
                        {
                            $linkarray[$a].=$referer['host'];
                        }
                    }
                    if(!empty($referer['path']))
                    {
                        $linkarray[$a].='/'.str_replace("./","",$referer['path'].$referer['query']);
                    }
                }
             }else
             {
                 
                if(empty($referer['path']))
                {
                    $linkarray[$a].="http://".$referer['host'];
                }
                else
                {
                    $linkarray[$a].="http://".$referer['host'].$referer['path'];
                }
             
              }
      }  
        $this->gLinkExtractor_linkRecipient=$linkarray;
        return $this->gLinkExtractor_linkRecipient;
    }

   function GetAllEmails()
    {
        return $this->mEmail;
    }

// This function find the given link in given page;
    function FindExistLink($find_url)
    {
        if(true==$this->_ValidateUrl($find_url))
        {
            $arraylinks=$this->GetAllLinks();
            $checkflag='';
            for( $a = 0, $b = count( $arraylinks ); $a < $b; $a++ )
            {   
                if(true==eregi($find_url, $arraylinks[$a]))
                {
                    $checkflag=true;
                    break;
                }
                else
                {
                      $checkflag=false;
                }
            }
            if(true==$checkflag)
            {
                return true;
            }
            else
            {
                $this->mError="Given is Not Exist. ";
                return false;
            }
        }else
        {
            $this->mError="Invalid URL. ";
            return false;
        }
    }


// This function Get all Unique Domain Names in given page.
    function GetDomainNames()
    {
        $arraylinks=$this->GetAllLinks();
        $checkflag='';
        for( $counter = 0, $counts = count($arraylinks); $counter < $counts; $counter++ )
        {
            $referer = parse_url($arraylinks[$counter]);
            $this->mDomainName[$counter] = $referer['host'];
        }
         $this->mDomainName = array_unique($this->mDomainName);
        return $this->mDomainName;
    }


// This function Find Domain Names in given page;
    function FindDomainName($domain_name)
    {
        if(!empty($domain_name))
        {
            $arraylinks=$this->GetDomainNames();
            $arraylinks=array_values($arraylinks);
            $checkflag='';
            for( $a = 0, $b = count( $arraylinks ); $a < $b; $a++ )
            {
                if(true==eregi($domain_name, $arraylinks[$a]))
                {
                    $checkflag=true;
                    break;
                }
                else
                {
                      $checkflag=false;
                }
            }
            if($checkflag==true)
            {
                return true;
            }
            else
            {
                $this->mError="Given Domain Name Not Exist.";
                return false;
            }
        }else
        {
            $this->mError="Domain Name Cannot be Blank.";
            return false;
        }
     }

    function GetError()
    {
        return $this->mError;
    }



     function _ValidateUrl($url)
    {
        $ret = false;
        $pattern ="^((http://|https://|file://){0,1}"           // type 
                  .'([a-z0-9-]{1,32}[.]){1,10}([a-z0-9]){2,3}'  // domain 
                  .'(:[0-9]{1,5}){0,1}'                         // port 
                  .'([/]{1,3}[a-z0-9_-~.]{0,64}){0,16}'         // directory 
                  .'([?][a-z0-9=%;+]+){0,1}$|$)';
        if(!empty($url))
        {
            if(eregi($pattern, $url))
            {
                $ret = true;
            }
        }
        return $ret;
       
    }

   


 // This function push the hyperlinks found in GetLinkExtractor function.
    function __PushLinkToArray( $replacement )
    {
        //global $gLinkExtractor_linkRecipient;
        array_push($this->gLinkExtractor_linkRecipient, htmlspecialchars( $replacement[2] ) );
//        print_r($this->gLinkExtractor_linkRecipient);
    }
}
 
?> 