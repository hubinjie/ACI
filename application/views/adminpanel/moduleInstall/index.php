<div class='panel panel-default grid'>
<div class='panel-heading'>
    <i class='fa fa-table'></i> 模块安装
    <div class='panel-tools'>
        <div class='btn-group'>
            <?php aci_ui_a($folder_name,'manage','index','',' class="btn "','<span class="glyphicon glyphicon-arrow-left"></span> 返回')?>
        </div>
    </div>
</div>
</div>

<div class="col-md-12">
<div class="jumbotron">
	<div class="container">
      <h2>欢迎使用Auto Codeigniter </h2>
      <p>autocodeigniter.com 是基于开源Codeigniter的的扩展程序，如何您有任何问题或意见，请访问我们的网站。</p>
  	</div>
</div>
<?php if(!$supportZip):?>
    <div class="alert alert-danger" role="alert">
      <strong>提示：</strong> <br/>您的服务器不支持 ZipArchive ，请先开启。
    </div>
<?php else:?>
	<?php if($uploadChomd>=644&&$configChomd>=644):?>
  <?php if(!DEMO_STATUS):?>
    <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo  base_url($folder_name.'/'.$controller_name.'/check')?>" role="form" >
      <div class="form-group">
        <label class="col-sm-2 control-label">安装包</label>
        <div class="col-sm-10">
          <input type="file" id="autocodeigniterZipFile" name="autocodeigniterZipFile">
            <p class="help-block">请从autocodeigniter.com官方下载模块安装程序。</p>
        </div>
      </div>
     <div class="form-group">
        <label class="col-sm-2 control-label">官方文件校验码</label>
        <div class="col-sm-4">
          <input type="text" id="autocodeigniterCode" class="form-control" name="autocodeigniterCode">
            <p class="help-block">官方文件校验码简单校验文件真实性。</p>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <?php aci_ui_button('module','install','check',' type="submit" id="dosubmit" value="upload" class="btn btn-primary btn-lg" ','上传并检查安装环境...')?>
        </div>
      </div>
    </form>
    <?php else:?>
    <div class="form-group">
        <label class="col-sm-2 control-label">安装包</label>
        <div class="col-sm-10">
          <input type="file" id="autocodeigniterZipFile" name="autocodeigniterZipFile">
            <p class="help-block">请从autocodeigniter.com官方下载模块安装程序。</p>
        </div>
      </div>
     <div class="form-group">
        <label class="col-sm-2 control-label">官方文件校验码</label>
        <div class="col-sm-4">
          <input type="text" id="autocodeigniterCode" class="form-control" name="autocodeigniterCode">
            <p class="help-block">官方文件校验码简单校验文件真实性。</p>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <?php aci_ui_button('module','install','check',' type="submit" id="dosubmit" value="upload" class="btn btn-primary btn-lg" ','很抱歉当前为演示状态，安全考虑无法上传模块...')?>
        </div>
      </div>
    <?php endif;?>
    <?php else:?>
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
    <?php endif;?>
<?php endif;?>
</div>
<script language="javascript" type="text/javascript">
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/index.js']);
    });
</script>
