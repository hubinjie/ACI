define(function (require) {
    var $ = require('jquery');
    require('bootstrap');
    require('bootstrapValidator');
    require('message');
    require('jquery-ui-dialog-extend');
    var aci = require('aci');

    var validator_config = {
        message: '输入框不能为空',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            password2: {
                validators: {
                    notEmpty: {
                        message: '新密码不能为空'
                    },
                    identical: {
                        field: 'password3',
                        message: '与确认新密码不相符'
                    }
                }
            },
            password3: {
                validators: {
                    notEmpty: {
                        message: '确认新密码不能为空'
                    },
                    identical: {
                        field: 'password2',
                        message: '与新密码不相符'
                    }
                }
            },
            password1:{
                validators: {
                    notEmpty: {
                        message: '请输入原密码'
                    }
                }
            }
        }
    };

    $('#validateform').bootstrapValidator(validator_config).on('success.form.bv', function(e) {
        e.preventDefault();

        $("#dosubmit").attr("disabled","disabled");

        $.scojs_message('请稍候...', $.scojs_message.TYPE_WAIT);
        $.ajax({
            type: "POST",
            url: SITE_URL+"adminpanel/profile/change_pwd/",
            data:  $("#validateform").serialize(),
            success:function(response){
                var dataObj=jQuery.parseJSON(response);
                if(dataObj.status)
                {
                    $.scojs_message('密码修改成功，请重新登录...', $.scojs_message.TYPE_OK);
                    aci.GoUrl(SITE_URL+'adminpanel/manage/logout/',1);
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

    }).on('error.form.bv',function(e){ $.scojs_message('不能为空', $.scojs_message.TYPE_ERROR);$("#dosubmit").removeAttr("disabled");});


});