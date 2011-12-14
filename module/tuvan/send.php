<?php
include_once 'htinmotion/orm/resources/class.database.php';
include_once 'htinmotion/orm/generated_classes/class.consult.php';
include_once 'template/admin/raiseerror.php';
if($_POST)
{
	$error=array();$con=new consult();
	$pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/";//	memid
	if(strlen($_POST["username"])==0 || $_POST["username"]=="Họ tên"){$error[0]=INVALID_NAME;}
	else{$con->username=$_POST["username"];}
	if(strlen($_POST["email"])<4 || !preg_match($pattern,$_POST["email"]) || $_POST["email"]=="Email"){$error[1]=INVALID_EMAIL; }
	else{$con->email=$_POST["email"];}
	if(strlen($_POST["title"])<5 || $_POST["title"]=="Vui lòng đánh tiếng Việt có dấu."){$error[2]=INVALID_TITLE;}
	else{$con->title=$_POST["title"];}
	if($_POST["todaytopic_type_id"]=="-1"){$error[3]=INVALID_CAT;}
	else $con->todaytopic_type_id= $_POST["todaytopic_type_id"];
	if(sizeof($error)==0)
	{
		$con->consult_datetime= date("Y-m-d h:i:s");		
		$con->status= 'disable';
		$con->insert();
		redirect(CONSULT_SUCCESS,"tu-van.php");	
	}
	else $message= appendError($error);
	
}
?>
<div id="tuvanform">
        <!-- TU VAN FORM -->       
        <form action="?" method="post" name="tuvanform">
        <input name="username" type="text" value="Họ tên" 
        onmouseover="if(this.value=='Họ tên'){this.value='';}" onmouseout="if(this.value==''){this.value='Họ tên';}"
        /><input name="email" type="text" value="Email" 
        onmouseover="if(this.value=='Email'){this.value='';}" onmouseout="if(this.value==''){this.value='Email';}"
        /><select name="todaytopic_type_id">
        <option value="-1">Phân l&#7885;ai</option>
        <option value="<?php echo SP_ID ?>">Sản phẩm</option>
        <option value="<?php echo DD_ID ?>">Dinh dưỡng </option>
        <option value="<?php echo GC_ID ?>">Giảm cân</option>
        <option value="<?php echo LT_ID ?>">Luyện tập </option>

        </select>
        <textarea name="title" onmouseover="if(this.value=='Vui lòng đánh tiếng Việt có dấu.')this.value=''">Vui lòng đánh tiếng Việt có dấu.</textarea>
        <div id="error">
        <?php echo $message;?>
        </div> 
        <input name="tuvan-submit" type="submit" value="" class="button">
        </form>
        <p align="left">
        <a href="#" onclick="popup('popUpChuyenGia')"><img src="img/space.gif" width="200" height="70"></a>
        </p>         
</div><!--/TU VAN FORM-->