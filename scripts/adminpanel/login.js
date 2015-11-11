define(function (require) {
	var $ = require('jquery');
	require('cookie');
	require('bootstrap');
	require('bootstrapValidator');
	require('message');
	var aci= require('aci');

	if(top!=self) if(self!=top) top.location=self.location;

	if ($.cookie("rmbUser") =="true") {
		$("#rmbUser").attr("checked", true);
		$("#username").val($.cookie("userName"));
		$("#password").val($.cookie("passWord"));
	}

	$("#dosubmit").removeAttr("disabled");
	$('#validateform').bootstrapValidator({
		message: '输入项不能为空',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			username: {
				validators: {
					notEmpty: {
						message: '请输入用户名'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: '请输入密码'
					}
				}
			}


		}
	}).on('success.form.bv', function(e) {

		e.preventDefault();
		$("#dosubmit").attr("disabled","disabled");
		$.scojs_message('正在登录，请稍候...', $.scojs_message.TYPE_WAIT);

		if ($("#rmbUser").is(":checked") ) {
			var userName = $("#username").val();
			var passWord = $("#password").val();
			$.cookie("rmbUser","true", { expires: 7 });
			$.cookie("userName", userName, { expires: 7 });
			$.cookie("passWord", passWord, { expires: 7 });
		}
		else {
			$.cookie("rmbUser","false", { expires: -1 });
			$.cookie("userName", '', { expires: -1 });
			$.cookie("passWord", '', { expires: -1 });
		}

		$.ajax({
			type: "POST",
			url: $("#validateform").attr("action"),
			data:  $("#validateform").serialize(),
			success:function(response){
				var dataObj=jQuery.parseJSON(response);
				if(dataObj.status)
				{
					$.scojs_message('登录成功，正在进入进入用户中心...', $.scojs_message.TYPE_OK);
					aci.GoUrl(dataObj.next_url,1);
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

	}).on('error.form.bv',function(e){ $.scojs_message('输入项不能为空', $.scojs_message.TYPE_ERROR);$("#dosubmit").removeAttr("disabled");});


});