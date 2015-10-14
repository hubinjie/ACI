<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<?php include template('public','header_view'); ?>
 <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">ACI(AutoCodeigniter.com)</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="<?php echo site_url()?>">首页</a></li>
                  <li><a href="http://www.autoCodeigniter.com">联系</a></li>
                </ul>
              </nav>
            </div>
          </div>

         <div class="panel panel-default">
              <div class="panel-body">
                <form id="testForm" name="testForm"  method="post">
                  <input type="hidden" name="flag" id="flag" value="1">
                  <div class="form-group">
                    <label >安装首页网址</label>
                    <input type="url" id="site_url"  name="site_url" value="http://localhost/" class="form-control"  placeholder="请输入首页网址" autofocus required>
                  </div>
                  <div class="form-group">
                    <label >MYSQL 主机地址</label>
                    <input type="text" id="mysql_url" name="mysql_url" class="form-control"   placeholder="请输入MYSQL主机地址，主机IP或者帐号" required>
                  </div>
                  <div class="form-group">
                    <label>MYSQL 主机帐号</label>
                    <input type="text" id="mysql_account" name="mysql_account"  class="form-control"  placeholder="请输入MYSQL主机用户名帐号" required>
                  </div>
                  <div class="form-group">
                    <label>MYSQL 主机密码</label>
                    <input type="password" id="mysql_password" name="mysql_password" class="form-control"  placeholder="请输入MYSQL主机帐号密码" required>
                  </div>
                  <div class="form-group">
                    <label>MYSQL 数据库名称</label>
                    <input type="text" id="mysql_db_name" name="mysql_db_name" class="form-control"  placeholder="请输入MYSQL数据库名称" required>
                  </div>
                  <button type="submit" class="btn btn-primary" id="dosubmit">下一步 <i class="glyphicon glyphicon-chevron-right"></i></button>
                </form>
              </div>
            </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div>

        </div>

      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#testForm").submit(function(e){
            e.preventDefault();
            var _site_url = $.trim($("#site_url").val());
            var _mysql_url = $.trim($("#mysql_url").val());
            var _mysql_account = $.trim($("#mysql_account").val());
            var _mysql_password = $.trim($("#mysql_password").val());
            var _mysql_db_name = $.trim($("#mysql_db_name").val());
            var _flag = parseInt($("#flag").val());
            if(_site_url==""){
              alert("请输入首页网址");
              $("#site_url").focus();
              return false;
            }
            if(_mysql_url==""){
              alert("请输入MYSQL主机地址，主机IP或者帐号");
              $("#mysql_url").focus();
              return false;
            }
            if(_mysql_account==""){
              alert("请输入MYSQL主机用户名帐号");
              $("#mysql_account").focus();
              return false;
            }
            if(_mysql_password==""){
              alert("请输入MYSQL主机帐号密码");
              $("#mysql_password").focus();
              return false;
            }
            if(_mysql_db_name==""){
              alert("请输入MYSQL数据库名称");
              $("#mysql_db_name").focus();
              return false;
            }


            $("#dosubmit").attr("disabled","disabled");
            $.ajax({
              type: "POST",
              url: "install",
              data:  $("#testForm").serialize(),
              success:function(response){
                var dataObj=jQuery.parseJSON(response);
                if(dataObj.status)
                {
                  if(_flag==1){
                    $("#flag").val("2");
                    //安装SQL
                    $.ajax({
                      type: "POST",
                      url: "install",
                      data:  $("#testForm").serialize(),
                      success:function(response){
                        var dataObj=jQuery.parseJSON(response);
                        if(dataObj.status)
                        {
                          alert("安装成功");
                          window.location.href="done";
                         
                        }else
                        {
                          alert(dataObj.tips);
                          $("#dosubmit").removeAttr("disabled");
                        }
                      },
                      error: function (request, status, error) {
                        alert(request.responseText);
                        $("#dosubmit").removeAttr("disabled");
                      }                  
                    });
                    //结束安装SQL

                  }else{
                    alert(dataObj.tips);
                  }
                }else
                {
                  alert(dataObj.tips);
                  $("#dosubmit").removeAttr("disabled");
                }
              },
              error: function (request, status, error) {
                alert(request.responseText);
                $("#dosubmit").removeAttr("disabled");
              }                  
            });
        });
      });
    </script>
<?php include template('public','footer_view'); ?>