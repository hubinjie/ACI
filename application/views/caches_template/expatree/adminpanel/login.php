<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<?php include template('adminpanel','header'); ?>
<script language="javascript" type="text/javascript">
    <!--
    if(top!=self)
        if(self!=top) top.location=self.location;

    function saveUserInfo() {
        if ($("#rmbUser").is(":checked") ) {
            var userName = $("#user").val();
            var passWord = $("#pass").val();
            $.cookie("rmbUser","true", { expires: 7 });
            $.cookie("userName", userName, { expires: 7 });
            $.cookie("passWord", passWord, { expires: 7 });
        }
        else {
            $.cookie("rmbUser","false", { expires: -1 });
            $.cookie("userName", '', { expires: -1 });
            $.cookie("passWord", '', { expires: -1 });
        }

        return true;
    }

    $(document).ready(function() {
        if ($.cookie("rmbUser") =="true") {
            $("#rmbUser").attr("checked", true);
            $("#user").val($.cookie("userName"));
            $("#pass").val($.cookie("passWord"));
        }
    });
    -->
</script>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="/" ><div class="tsLogo "></div></a>
            </div>
            <div class="col-md-6">
                <a href="/register.htm" class="btn btn-default pull-right">注 册</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <form class="form-signin" role="form" action="<?php echo current_url()?>" onsubmit="return saveUserInfo()" method="post" name="myform">
        <div class="form-signin-body">

            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" id="user" name="username" class="form-control" placeholder="请输入管理帐号" aria-describedby="basic-addon1" required autofocus>
            </div>

            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" id="pass" name="password" class="form-control" placeholder="请输入管理密码" aria-describedby="basic-addon1" required autofocus>
            </div>

            <button class="btn  btn-primary btn-block" type="submit">登录</button>

            <div class="checkbox">
                <label>
                    <input type="checkbox" id="rmbUser" value="remember-me"> 在此设备上保存登录
                </label>
            </div>
        </div>
        <div class="form-signin-footer"> <a><i class="glyphicon glyphicon-question-sign"></i> 忘记密码？</a></div>
    </form>
    <?php include template('adminpanel','footer'); ?>