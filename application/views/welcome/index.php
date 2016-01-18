<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<?php echo template('public','header_view',array('date'=>$date))?>
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

          <div class="inner cover">
            <h1 class="cover-heading">欢迎使用ACI. <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=bad0214202bb89e4118c272a39b4cc81abf6bbae0ec7f46d68e5d4f06448cbda"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="ACI" title="ACI"></a></h1>
            <?php  if (version_compare(PHP_VERSION, '5.3.0') <= 0) :?>
            <p class="lead">很抱歉 ACI 要求最低PHP版本不能小于PHP 5.3</p>
            <?php else:?>
              <?php if(!isRewriteMod()&&function_exists('apache_get_version')): ?>
                <p class="lead">很抱歉您当前环境未开始 mod_rewrite </p>
              <?php elseif(site_url()!=curPageURL()):?>
                <p class="lead"> 安装说中的第一条不正确 ， 请修改 application/config/config.php 中的 $config['base_url'] = '<?php echo curPageURL()?>'; </p>
              <?php elseif($cache_chomd<755):?>
                <p class="lead"> application/cache 文件夹 权限不够，要求权限>=755以上 </p>
              <?php else:?>
                <p class="lead">恭喜您安装成功，默认管理帐号 test/test</p>
                <p class="lead">
                  <p>{title}</p>
                  <p>感谢@Alex 、 @青蛙 、 @zhanxing.tech </p>

                  <a href="<?php echo site_url('adminpanel')?>" class="btn btn-lg btn-default">进入后台管理</a>
                </p>
              <?php endif;?>
            <?php endif;?>

          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>
<?php echo template('public','footer_view')?>