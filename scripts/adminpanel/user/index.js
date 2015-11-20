define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');

	$("#reverseBtn").click(function(){
		aci.ReverseChecked('pid[]');
	});

	$("#lockBtn").click(function(){
		var _arr = aci.GetCheckboxValue('pid[]');
		if(_arr.length==0)
		{
			alert("请先勾选明细");
			return false;
		}

		if(confirm("确定要反设置禁止登录？"))
		{
			$("#form_list").attr("action",SITE_URL+folder_name+"/user/lock/");
			$("#form_list").submit();
		}
	});

	$("#deleteBtn").click(function(){
		var _arr = aci.GetCheckboxValue('pid[]');
		if(_arr.length==0)
		{
			alert("请先勾选明细");
			return false;
		}

		if(confirm("确定要删除用户吗？"))
		{
			$("#form_list").attr("action",SITE_URL+folder_name+"/user/delete/");
			$("#form_list").submit();
		}
	});
});