<form class="form-horizontal" role="form" action="<?php echo current_url()?>" method="post" id="validateform" name="validateform">
    <div class='panel panel-default'>
    <div class='panel-heading'>
        <i class='icon-edit icon-large'></i>
        修改密码
    </div>
    <div class='panel-body'>
        <fieldset>
            <legend>请输入您的帐号信息</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label">原密码</label>
                    <div class="col-sm-4">
                        <input type="password" name="password1" class="form-control" placeholder="请输入原密码" autofocus >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-4">
                        <input type="password" name="password2" class="form-control" placeholder="请输入新密码" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">确认新密码</label>
                    <div class="col-sm-4">
                        <input type="password" name="password3" class="form-control" placeholder="请再次输入新密码" >
                    </div>
                </div>

        </fieldset>
        <div class='form-actions'>
            <button name="dosubmit" class="btn  btn-primary " type="submit">保存修改</button>
        </div>
    </div>
    </div>
</form>
<script language="javascript" type="text/javascript">
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/change_pwd.js']);
    });
</script>