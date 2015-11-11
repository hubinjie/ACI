<h3 class="page-header">
<?php aci_ui_a($folder_name,'moduleInstall','index','',' class="btn btn-info btn-sm pull-right"','<span class="glyphicon glyphicon-plus"></span> 安装新模块')?>  模块管理器 </h3>
<div class="alert alert-success alert-dismissible" role="alert">
  <strong>友情提示</strong> 不需要的模块可以停用，停用后的模块可以再次启用，也可以停用后直接删除。
</div>
<div class="panel panel-default">
<div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>模块名称</th>
              <th>版本</th>
              <th>作者</th>
              <th>简介</th>
              <th>最后修改时间</th> 
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php $k=0;if($datalist) foreach($datalist as $v):?>
            <tr>
              <td><?php echo $k+1?></td>
              <td><?php echo $v['moduleCaption']?></td>
              <td>version: <?php echo number_format($v['version'],2)?></td>
              <td><a href="<?php echo $v['website']?>" target="_blank"><?php echo $v['coder']?></a></td>
              <td><?php echo $v['description']?></td>
              <td><?php echo $v['lastUpdate']?></td>
              <td>
                <?php if(!$v['system']):?>
              	<?php if($v['works']):?>
                
                <?php aci_ui_a($folder_name,"moduleInstall",'uninstall',$v['moduleName'],' class="btn btn-default btn-xs"','<span class="glyphicon glyphicon-stop"></span> 停用')?>
               <a href="<?php echo base_url($v['moduleUrl'])?>" target="_blank" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-send"></span> 查看</a>
                <?php else:?>
                <?php aci_ui_a($folder_name,"moduleInstall",'reinstall',$v['moduleName'],' class="btn btn-info btn-xs"','<span class="glyphicon glyphicon-play"></span> 启用')?>
                <?php aci_ui_a($folder_name,"moduleInstall",'delete',$v['moduleName'],' class="btn btn-default btn-xs"','<span class="glyphicon glyphicon-remove"></span> 删除')?>
                <?php endif;?>
                <?php else:?>
                <button type="button" class="btn btn-default btn-xs "><span class="glyphicon glyphicon-lock"></span>系统模块无法操作</button>
                <?php endif;?>
              </td>
            </tr>
            <?php $k++;endforeach;?>
          </tbody>
        </table>
    	</div>

    <script language="javascript" type="text/javascript">
        require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
            require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/index.js']);
        });
    </script>