<div class='panel panel-default'>
  <div class='panel-heading'>
    <i class='glyphicon glyphicon-list'></i> 菜单管理
    <div class='panel-tools'>
      <div class='btn-group'>
        <a class='btn' href='<?php echo current_url() ?>'>
          <i class='glyphicon glyphicon-refresh'></i>
          刷新
        </a>
        <?php aci_ui_a($folder_name,$controller_name,'add','0',' class="btn btn-sm pull-right"','<span class="glyphicon glyphicon-plus"></span> 添加菜单')?>
      </div>
    </div>
  </div>
  <form id="formlist" name="formlist" method="post">
  <div class="panel-body">

        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>图标</th>
              <th>菜单名称</th>
              <th>文件夹</th>
              <th>控制器</th>
              <th>方法</th>
              <th>左侧菜单</th>
              <th>系统菜单</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php echo $table_html;?>
          </tbody>
        </table>
  </div>
    <div class="panel-footer">
      <div class="pull-left">
        <div class="btn-group">
          <button type="button" class="btn btn-default" id="reverseBtn" ><span class="glyphicon glyphicon-ok"></span> 反选</button>
          <?php aci_ui_button($folder_name,$controller_name,'set_menu',' type="button" id="setMenuBtn" class="btn btn-default"','<span class="glyphicon glyphicon-remove"></span> 反设为左侧菜单')?>
          <?php aci_ui_button($folder_name,$controller_name,'delete',' type="button" id="deleteBtn"  class="btn btn-default" ','<span class="glyphicon glyphicon-remove"></span> 删除勾选')?>

        </div>
      </div>
    </div>
</form>
</div>

<script language="javascript" type="text/javascript">
  var folder_name="<?php echo $folder_name?>";
  var controller_name ="<?php echo $controller_name?>";
  require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
    require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/list.js']);
  });
</script>