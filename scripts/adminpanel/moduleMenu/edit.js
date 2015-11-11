define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');
	require('bootstrapValidator');
	require('message');

	$('#parent_id').change(function(){

		var depth = $("#parent_id").find("option:selected").attr("depth");
		if(depth>1){
			$("#show-url").show();
			$("#show-where").hide();
		}else{
			$("#show-url").hide();
			$("#show-where").show();
		}

	});

	$('#parent_id').change();

	$('#validateform').bootstrapValidator({
		message: '输入框不能为空',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			menu_name: {
				validators: {
					notEmpty: {
						message: '请输入菜单名称'
					}
				}
			}
		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();

		$("#dosubmit").attr("disabled","disabled");
		$.scojs_message("正在保存，请稍等...", $.scojs_message.TYPE_WAIT);
		$.ajax({
			type: "POST",
			url: edit?SITE_URL+folder_name+"/"+controller_name+"/edit/"+menu_id:SITE_URL+folder_name+"/"+controller_name+"/add/",
			data:  $("#validateform").serialize(),
			success:function(response){
				var dataObj=jQuery.parseJSON(response);
				if(dataObj.status)
				{
					$.scojs_message('操作成功...', $.scojs_message.TYPE_OK);
					window.location.href=SITE_URL+folder_name+'/'+controller_name+'/';
				}else
				{
					$.scojs_message(dataObj.tips, $.scojs_message.TYPE_ERROR);
					$("#dosubmit").removeAttr("disabled");
				}
			},
			error: function (request, status, error) {
				$.scojs_message(request.responseText, $.scojs_message.TYPE_ERROR);
				$("#dosubmit").removeAttr("disabled");
			}
		});


	}).on('error.form.bv',function(e){ $.scojs_message('带*号不能为空', $.scojs_message.TYPE_ERROR);$("#dosubmit").removeAttr("disabled");});


});
