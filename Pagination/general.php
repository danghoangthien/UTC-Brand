<?php   
  class general
  {
  	var $databasetype="mysql"; 
  	var $server = HOST;
    var $user   = USERNAME;
    var $password = PASS;
    var $database = DATABASE;
  	function general(){}
    function getSQL($sql,$mode=-1)
	    {	    	
	    	$db = ADONewConnection($this->databasetype); 
		    //$db->debug = true; 
			if(DEBUG) $db->debug = DEBUG; 
			
		    $db->Connect($this->server, $this->user, $this->password, $this->database); 
			if($mode==0) $db->SetFetchMode(ADODB_FETCH_ASSOC);
			if($mode==1) $db->SetFetchMode(ADODB_FETCH_NUM);
			$db->Execute("SET NAMES utf8"); 
		    $rs = $db->Execute($sql); 
		   	//return rs2html($rs,'border=2 cellpadding=3'); 
		   /*
	  		$arr=$rs->getRows();
	  		  	print "<pre>"; 
    			print_r($arr); 
    			print "</pre>"; 
	  		*/	
		    $arr=$rs->getRows();
		    return $arr;   		
	    }
	  function getSQL2($sql,$mode=-1)
	    {	    	
	    	$db = ADONewConnection($this->databasetype); 
		    //$db->debug = true; 
			if(DEBUG) $db->debug = DEBUG; 
			
		    $db->Connect($this->server, $this->user, $this->password, $this->database); 
			$db->SetFetchMode(ADODB_FETCH_ASSOC);
			$db->Execute("SET NAMES utf8"); 
		    $rs = $db->Execute($sql); 
		   	//return rs2html($rs,'border=2 cellpadding=3'); 
		   /*
	  		$arr=$rs->getRows();
	  		  	print "<pre>"; 
    			print_r($arr); 
    			print "</pre>"; 
	  		*/	
			return $rs;   		
		    $arr=$rs->getRows();
		    
	    }	
      function executeSQL($sql)
	    {	    	
	    	$db = ADONewConnection($this->databasetype); 
		    if(DEBUG) $db->debug = DEBUG; 
		    $db->Connect($this->server, $this->user, $this->password, $this->database); 
			$db->Execute("SET NAMES utf8"); 
		    $rs = $db->Execute($sql);		
	    }	
	  function getLoader($sql)
	  {
	  	 $assoc=$this->getSQL($sql,0);	 	  	 
	  	 return $assoc[0];
	  	
	  }  
	  function getOptionList($sql)
	  {
		 $optionList=array();
	  	 $assoc=$this->getSQL($sql,1);	  	 
	  	foreach($assoc as $v)
		{
			 $optionList[$v[0]]=$v[1];
		}
	  	return $optionList;
	  }  
	  function getCacheSQL($sec,$sql,$mode=0)
	    {	    	
	    	$db = ADONewConnection($this->databasetype); 
		    if(DEBUG) $db->debug = DEBUG; //$db->debug = true; 
		    $db->Connect($this->server, $this->user, $this->password, $this->database); 
			if($mode==0) $db->SetFetchMode(ADODB_FETCH_ASSOC);
			if($mode==1) $db->SetFetchMode(ADODB_FETCH_NUM);
			$db->Execute("SET NAMES utf8"); //$db->$ADODB_CACHE_DIR="../admin";
		    $rs = $db->CacheExecute($sec,$sql);	
			$arr=$rs->getRows();
			return $arr;	
	    }		
	  function flushCacheSQL($sql)
	  {	    	
	    	$db = ADONewConnection($this->databasetype); 
		    if(DEBUG) $db->debug = DEBUG; 
		    $db->Connect($this->server, $this->user, $this->password, $this->database); 
		    $db->CacheFlush($sql);		
	  }		
	  function executeInsert($table,$array,$subSQL="")
	  {
		  $columnList="(".implode(array_keys($array),",").")";
		  $valueList ="('".implode($array,"','")."')";
		  $pattern   ="INSERT INTO $table $columnList VALUES $valueList $subSQL";
		  $this->executeSQL($pattern);
		  return $this->executeSQL("SELECT LAST_INSERT_ID()");
	  }
	  function executeInsertADOBD($table,$array,$subSQL="")
	  {
		   $db = ADONewConnection($this->databasetype); 
		  if(DEBUG) $db->debug = DEBUG; 
		  $db->Connect($this->server, $this->user, $this->password, $this->database); 
		  return $db->AutoExecute($table, $array, 'INSERT'); 
	  }
	  function executeUpdate($table,$array,$subSQL="")
	  {
		  $pair=array();
		  foreach ($array as $k=>$v) $pair[]=$k."='$v'";
		  $pair=implode($pair,",");
		  $pattern="UPDATE $table SET $pair $subSQL";
		  $this->executeSQL($pattern);
	  }
	   function executeUpdateADOBD($table,$array,$subSQL="")
	  {
		  $db = ADONewConnection($this->databasetype); 
		  if(DEBUG) $db->debug = DEBUG; 
		  $db->Connect($this->server, $this->user, $this->password, $this->database);   
		  return $db->AutoExecute($table, $array, 'UPDATE',$subSQL); 
	  }
	  /*
	  public static DataSet Insert(string tableName,Hashtable ht) 
        {
            CreateConnection create = new CreateConnection();
            DataSet meta = DLL_General.GetMeta(db,tableName," ");
            string pattern = "INSERT INTO ["+meta.Tables[0].Rows[0][2]+"] ";            
            string columnList = "";
            
            columnList += "(";
            columnList += implodeListToString(ht.Keys, ",");
            columnList += ")";

            string valueList = "VALUES";

            valueList+="(N'";
            valueList += implodeListToString(ht.Values, "','");
            valueList=valueList.Substring(0, valueList.Length - 1);
            valueList += ")";

            string finalsql = pattern + columnList + valueList +" SELECT SCOPE_IDENTITY()";
            return create.ExecuteSQL(finalsql);
            
        }
		 public static DataSet Update(string tableName, Hashtable ht,string subSQL)
        {
            CreateConnection create = new CreateConnection();
            DataSet meta = DLL_General.GetMeta(db, tableName, " ");
            string pattern = " UPDATE [" + meta.Tables[0].Rows[0][2] + "] SET ";
            string command = "";
            foreach (DictionaryEntry de in ht)
            {
                command += "["+de.Key.ToString()+"]=N'" + de.Value.ToString()+"',";
            }
            command = command.Substring(0, command.Length - 1);
            
            string finalsql = pattern + command + subSQL ;
            return create.ExecuteSQL(finalsql);

        }
		
	  */
  }
  ?>