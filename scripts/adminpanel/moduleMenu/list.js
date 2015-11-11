define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');

	$("#reverseBtn").click(function(){
		aci.ReverseChecked('pid[]');
	});

	$("#setMenuBtn").click(function(){
		var _arr = aci.GetCheckboxValue('pid[]');
		if(_arr.length==0)
		{
			alert("请先勾选明细");
			return false;
		}

		if(confirm("确定要反设置左侧菜单？"))
		{
			$("#formlist").attr("action",SITE_URL+folder_name+"/"+controller_name+"/set_menu/");
			$("#formlist").submit();
		}
	});

	$("#deleteBtn").click(function(){
		var _arr = aci.GetCheckboxValue('pid[]');
		if(_arr.length==0)
		{
			alert("请先勾选明细");
			return false;
		}

		if(confirm("确定要删除菜单？"))
		{
			$("#formlist").attr("action",SITE_URL+folder_name+"/"+controller_name+"/delete/");
			$("#formlist").submit();
		}
	});

});
