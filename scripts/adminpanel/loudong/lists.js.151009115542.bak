define(function (require) {
	 var $ = require('jquery');
        message = require('message'),
        bootstrapValidator = require('bootstrapValidator'),
		aci = require('aci');
		
		
		$(function () {
        
        $("#reverseBtn").click(function(){
			aci.ReverseChecked('pid[]')
		});
        
        $("#deleteBtn").click(function(){
			var _arr = aci.GetCheckboxValue("pid[]");
            if(_arr.length==0)
            {
                alert("请先勾选明细");
                return false;
            }
            if(confirm('确定要删除吗?'))
            {
                $("#form_list").submit();
            }
		});
        
         $(".delete-btn").click(function(){
			var v = $(this).val();
			if(confirm('确定要删除吗?'))
			{
				window.location.href= SITE_URL+ "adminpanel/loudong/delete_one/"+v;
			}
		});
            
            $('#validateform').bootstrapValidator({
				message: '输入框不能为空',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					 loudong_name: {
						 validators: {
							notEmpty: {
								message: '楼栋名称 不能为空'
							}
						 }
					 },
					 loudong_area: {
						 validators: {
							notEmpty: {
								message: '楼栋面积 不能为空'
							}
						 }
					 },
					 loudong_manager: {
						 validators: {
							notEmpty: {
								message: '楼栋管理员 不能为空'
							}
						 }
					 },
					 loudong_remark: {
						 validators: {
							notEmpty: {
								message: '楼栋备注 不能为空'
							}
						 }
					 },
				}
			}).on('success.form.bv', function(e) {
				
				e.preventDefault();
				$("#dosubmit").attr("disabled","disabled");
				
				//for ( instance in CKEDITOR.instances )  CKEDITOR.instances[instance].updateElement();
				
				$.scojs_message("正在保存，请稍等...", $.scojs_message.TYPE_ERROR);
				$.ajax({
					type: "POST",
					url: edit?SITE_URL+"adminpanel/loudong/edit/"+id:SITE_URL+"adminpanel/loudong/add/",
					data:  $("#validateform").serialize(),
					success:function(response){
						var dataObj=jQuery.parseJSON(response);
						if(dataObj.status)
						{
							$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
							aci.GoUrl(SITE_URL+'adminpanel/loudong/',1);
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
