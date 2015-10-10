define(function (require) {
	 var $ = require('jquery');
        message = require('message'),
        bootstrap = require('bootstrap'),
        bootstrapValidator = require('bootstrapValidator'),
        jui = require('jquery-ui'),
        jde = require('jquery-ui-dialog-extend'),
		aci = require('aci');

		$(function () {

            $('#validateform').bootstrapValidator({
				message: '输入框不能为空',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
   
					 loudong_id: {
						 validators: {
							notEmpty: {
								message: '楼栋 不能为空'
							}
						 }
					 },

   
					 loudongfangjian_name: {
						 validators: {
							notEmpty: {
								message: '房间号 不能为空'
							}
						 }
					 },

   
					 loudongfangjian_area: {
						 validators: {
							notEmpty: {
								message: '房间面积 不能为空'
							}
						 }
					 },

				}
			}).on('success.form.bv', function(e) {
				
				e.preventDefault();
				$("#dosubmit").attr("disabled","disabled");
				
				$.scojs_message("正在保存，请稍等...", $.scojs_message.TYPE_ERROR);
				$.ajax({
					type: "POST",
					url: is_edit?SITE_URL+"adminpanel/loudongfangjian/edit/"+id:SITE_URL+"adminpanel/loudongfangjian/add/",
					data:  $("#validateform").serialize(),
					success:function(response){
						var dataObj=jQuery.parseJSON(response);
						if(dataObj.status)
						{
							$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
							aci.GoUrl(SITE_URL+'adminpanel/loudongfangjian/',1);
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
});
