define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');
	require('jquery-ui-dialog-extend');
	require('bootstrapValidator');
	require('message');

	$(".uploadThumb_a").click(function(){
		$.extDialogFrame(SITE_URL+folder_name+"/user/upload/thumb/thumb/1",{model:true,width:600,height:250,title:'请上传...',buttons:null});
	});


	var validator_config = {
		message: '输入框不能为空',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			username: {
				message: '用户名不能为空',
				validators: {
					notEmpty: {
						message: '用户名不能为空'
					},
					stringLength: {
						min: 6,
						max: 30,
						message: '用户名请为6到30个字符之间'
					},
					remote: {
						url: SITE_URL+folder_name+'/user/check_username',
						message: '用户名已经存在，请更换用户名'
					},
					different: {
						field: 'password',
						message: '用户名不能和密码一样'
					}
				}
			},
			email: {
				validators: {
					notEmpty: {
						message: 'EMAIL不能为空'
					},
					emailAddress: {
						message: 'EMAIL地址格式不正确'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: '密码不能为空'
					},
					identical: {
						field: 'repassword',
						message: '两次密码不匹配'
					},
					different: {
						field: 'username',
						message: '密码不能和用户名一样'
					}
				}
			},
			repassword: {
				validators: {
					notEmpty: {
						message: '确认密码不能为空'
					},
					identical: {
						field: 'password',
						message: '两次密码不匹配'
					},
					different: {
						field: 'username',
						message: '密码不能和用户名一样'
					}
				}
			},
			mobile:{
				validators: {
					notEmpty: {
						message: '请输入手机号'
					},
					regexp: {
						regexp: /^[0-9\.]+$/,
						message: '手机号只能全为数字'
					}
				}
			},
			group_id: {
				validators: {
					notEmpty: {
						message: '请选择用户组'
					}
				}
			},
		}
	};

	if(edit){
		var validator_config = {
			message: '输入框不能为空',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: '请输入Email'
						}
					}
				},
				mobile: {
					validators: {
						notEmpty: {
							message: '请输入手机号'
						}
					}
				},
				group_id: {
					validators: {
						notEmpty: {
							message: '请选择用户组'
						}
					}
				},
				mobile:{
					validators: {
						notEmpty: {
							message: '请输入手机号'
						},
						regexp: {
							regexp: /^[0-9\.]+$/,
							message: '手机号只能全为数字'
						}
					}
				},
			}
		};
	}
	$('#validateform').bootstrapValidator(validator_config).on('success.form.bv', function(e) {
		e.preventDefault();

		$("#dosubmit").attr("disabled","disabled");


		$.scojs_message('请稍候...', $.scojs_message.TYPE_WAIT);
		$.ajax({
			type: "POST",
			url: edit?SITE_URL+folder_name+"/user/edit/"+id:SITE_URL+folder_name+"/user/add/",
			data:  $("#validateform").serialize(),
			success:function(response){
				var dataObj=jQuery.parseJSON(response);
				if(dataObj.status)
				{
					$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
					aci.GoUrl(SITE_URL+folder_name+'/user/index/',1);
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
