	function BMI()
	{
		var error=new Array();
		if(!Number($("#bmi_cao").val()) || Number($("#bmi_cao").val())<100 || Number($("#bmi_cao").val())>300)
		{
			error[0]='chỉ số chiều cao không hợp lệ';
			alert(error[0]);return;
		}
		if(!Number($("#bmi_nang").val()) ||Number($("#bmi_nang").val())<30 || Number($("#bmi_nang").val())>300)
		{
			error[1]=('chỉ số cân nặng không hợp lệ');
			alert(error[1]);return;
		}
		if(error.length==0)
		{
			var bmi=Math.round(Number($("#bmi_nang").val())/
			( (Number($("#bmi_cao").val())/100) * (Number($("#bmi_cao").val())/100)  ));
			location.href='cong-cu-chi-so-ket-qua.php?type=bmi&re='+bmi;
		}	
	}
	function FAT()
	{
		var error=new Array();
		if(!Number($("#fat_tuoi").val()) || Number($("#fat_tuoi").val())<1 || Number($("#fat_tuoi").val())>120)
		{
			error[0]='chỉ số tuổi không hợp lệ';
			alert(error[0]);return;
		}
		if(!Number($("#fat_cao").val()) || Number($("#fat_cao").val())<100 || Number($("#fat_cao").val())>300)
		{
			error[0]='chỉ số chiều cao không hợp lệ';
			alert(error[0]);return;
		}
		if(!Number($("#fat_nang").val()) ||Number($("#fat_nang").val())<30 || Number($("#fat_nang").val())>300)
		{
			error[1]=('chỉ số cân nặng không hợp lệ');
			alert(error[1]);return;
		}
		if(error.length==0)
		{
			var bmi=Math.round(Number($("#fat_nang").val())/
			( (Number($("#fat_cao").val())/100) * (Number($("#fat_cao").val())/100)  ));
			if($("#fat_gt").val()=="nam")
			{
				var gt= 51.6;
			}
			if($("#fat_gt").val()=="nu")
			{
				var gt= 63.7;
			}
			var fat=Math.round(gt-(735/bmi)+0.029*(Number($("#fat_tuoi").val())));
			location.href='cong-cu-chi-so-ket-qua.php?type=fat&re='+fat+"&gt="+$("#fat_gt").val();
		}
		
	}
	function HIPHOP()
	{
		var error=new Array();
		if(!Number($("#hiphop_eo").val()) || Number($("#hiphop_eo").val())<1 || Number($("#hiphop_eo").val())>300)
		{
			error[0]='chỉ số vòng eo không hợp lệ';
			alert(error[0]);return;
		}
		if(!Number($("#hiphop_mong").val()) ||Number($("#hiphop_mong").val())<1 || Number($("#hiphop_mong").val())>300)
		{
			error[1]=('chỉ số vòng mông không hợp lệ');
			alert(error[1]);return;
		}
		if(error.length==0)
		{
			var hip=roundVal(Number($("#hiphop_eo").val())/Number($("#hiphop_mong").val()));
			location.href='cong-cu-chi-so-ket-qua.php?type=hiphop&re='+hip+"&gt="+$("#hiphop_gt").val();
		}
		
	}
	function roundVal(val){
		var dec = 2;
		var result = Math.round(val*Math.pow(10,dec))/Math.pow(10,dec);
		return result;
	}


