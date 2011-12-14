<?php 
session_start();
//1 database config
include '../../../config.php';
//2 neccessary library
include '../../../htinmotion/orm/adodb5/adodb.inc.php';
include '../../../htinmotion/orm/general/general.php';
include '../../../htinmotion/fckeditor/fckeditor.php';
//3 lay out
include '../../../template/admin/admin_head.php';
include '../../../template/admin/admin_header.php';
//4 code behind
include '../../../htinmotion/orm/resources/class.database.php';
include '../../../htinmotion/orm/generated_classes/class.todaytopic_type.php';
include '../../../htinmotion/orm/generated_classes/class.admin_navigation.php';
include '../../../htinmotion/formgenerator/formgenerator.php';
//5 raise error
include '../../../template/admin/raiseerror.php';
//coding structure
	if($_GET["log"]=="out")
	{
		session_destroy();
		echo"<script>jQuery.facebox('Logout Thành công')</script>";
	}
	if($_POST["username"])
	{	
			$g=new general();$error=array();
			if(!isset($_POST["username"]) || !isset($_POST["password"]))$error["input"]="please input username and password!!!";
			if(sizeof($error)==0)	
			{
				$arr=$g->getSQL("select * from admin where 
				username='".$_POST["username"]."' and 
				password='".md5($_POST["password"])."'",0);//print_r($arr);
				if (sizeof($arr)>0)	
				{
					//echo $arr[0]["Id"];
					$_SESSION["mem"]=$arr[0];
					$_SESSION["user_log"]=$arr[0]["Id"];
					redirect(SUCCESS_LOGIN,"../../../page/admin/account/info.php");
				}
			}
	}	
		echo "<div id='formAdmin'>";    
		//------create form & setup form	
		$g= new general();		
		
        $form=new Form();    
        $arr=array("title"=>"Administrator Login","name"=> "login","linebreaks"=>false,"action"=> "?","divs"=> true) ;   
        $form->setMulti($arr);      		        			  		        
        $form->addField("text", "username","User name(*)",false);	
        $form->addField("password", "password","Pass name(*)",false);	
		echo "<br/>";								   			             						      
        $form->display("Submit", "form1_submit");  
        $result=($form->getData());unset($form);echo "</div>";         																		           			
//lay out
include '../../../template/admin/admin_sidebar.php';
include '../../../template/admin/admin_footer.php';
?>