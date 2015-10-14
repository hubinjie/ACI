<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
{template 'public','header_view'}
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
            <h1 class="cover-heading">欢迎使用ACI.</h1>
            <p class="lead">恭喜您安装成功，默认管理帐号 test/test</p>
            <p class="lead">
              <a href="<?php echo site_url('adminpanel')?>" class="btn btn-lg btn-default">进入后台管理</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>
{template 'public','footer_view'}