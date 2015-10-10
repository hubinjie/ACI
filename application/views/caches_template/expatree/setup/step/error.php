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
                  <li class="active"><a href="#">安装</a></li>
                  <li><a href="#">联系</a></li>
                </ul>
              </nav>
            </div>
          </div>

         <div class="panel panel-default">
              <div class="panel-body">


        <?php if($uploadChomd==0):?>
            <div class="alert alert-danger" role="alert">
            <strong>提示：</strong> <br/>您的临时存储安装文件路径(<?php echo INTALL_UPLOAD_TEMP_PATH?>)不存在或没有创建权限。<br/>请检查上级目录是否给了可读可写的权限(777)！
        </div>
        <?php elseif($uploadChomd<644):?>
        <div class="alert alert-warning" role="alert">
          <strong>提示：</strong> <br/>您的临时存储安装文件路径(<?php echo INTALL_UPLOAD_TEMP_PATH?>)权限不足，当前权限值为:<?php echo $uploadChomd?>。<br/>请检查目录是否给了可读可写的权限(777)！
        </div>
        <?php endif;?>
        
        <?php if($configChomd==0):?>
            <div class="alert alert-danger" role="alert">
            <strong>提示：</strong> <br/>您的config文件路径(application/config/aci.php)不存在或没有创建权限。<br/>请检查上级目录是否给了可读可写的权限(777)！
        </div>
        <?php elseif($configChomd<644):?>
            <div class="alert alert-danger" role="alert">
            <strong>提示：</strong> <br/>您的config文件路径(application/config/aci.php)权限不足,当前权限值为:<?php echo $configChomd?>。<br/>请检查上级目录是否给了可读可写的权限(777)！
        </div>
        <?php endif;?>

        <a class="btn btn-primary" href="<?php echo base_url('setup/step/')?>">继续安装 <i class="glyphicon glyphicon-chevron-right"></i></a>



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
<?php include template('public','footer_view'); ?>