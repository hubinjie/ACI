<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 楼栋信息列表
        <div class='panel-tools'>
            <div class='btn-group'>
                 <a class="btn " href="<?php echo base_url('adminpanel/loudong/add')?>"><span class="glyphicon glyphicon-plus"></span> 添加 </a>             </div>
            <div class='badge'><?php echo count($data_list)?></div>
        </div>
    </div>
        <div class='panel-filter '>
      <div class='row'>
        <div class='col-md-12'>
        <form class="form-inline" role="form" method="get">
          <div class="form-group">
<label for="keyword" class="control-label form-control-static">关键词</label>
<input class="form-control" type="text" name="keyword"  value="<?php echo isset($data_info['keyword'])? $data_info['keyword']:"";?>" id="keyword" placeholder="请输入关键词"/></div>
<div class="form-group">
<label for="keywords" class="form-control-static">楼栋面积:</label>
<input class="form-control" size="3" type="number"  name="loudong_area_1"  id="loudong_arealoudong_area1" placeholder="楼栋面积大于等于范围"/> - <input class="form-control" size="3" type="number"  name="loudong_area_2"  id="loudong_arealoudong_area2" placeholder="楼栋面积小于等于范围"/></div>
<button type="submit" name="dosubmit" value="搜索" class="btn btn-success"><i class='glyphicon glyphicon-search'></i></button>        </form>
        </div>
      </div> 
    </div>
          <form method="post" id="form_list"  action="<?php echo base_url('adminpanel/loudong/delete_all')?>"  > 
    <div class='panel-body '>
    <?php if($data_list):?>
        <table class="table table-hover dataTable" id="checkAll">
          <thead>
            <tr>
              <th>#</th>
                            <?php $css=""; $next_url = base_url('adminpanel/loudong?order=loudong_name&dir=desc'); ?>
              <?php if(($order=='loudong_name'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/loudong?order=loudong_name&dir=asc'); ?>
              <?php } elseif (($order=='loudong_name'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">楼栋名称</th>
              <th   nowrap="nowrap">楼栋面积</th>
              <th   nowrap="nowrap">楼栋管理员</th>
              <th   nowrap="nowrap">创建者</th>
              <th   nowrap="nowrap">创建时间</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($data_list as $k=>$v):?>
            <tr>
              <td><input type="checkbox" name="pid[]" value="<?php echo $v['loudong_id']?>" /></td>
                             <td><?php echo $v['loudong_name']?></td>
                            <td><?php echo $v['loudong_area']?></td>
                            <td><?php echo $v['loudong_manager']?></td>
                            <td><?php echo $v['user_id']?></td>
                            <td><?php echo $v['created']?></td>
              <td>
                            	<a href="<?php echo base_url('adminpanel/loudong/readonly/'.$v['loudong_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-share-alt"></span> 查看</a>
                                            <a href="<?php echo base_url('adminpanel/loudong/edit/'.$v['loudong_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit"></span> 修改</a>
                                            <button type="button" class="btn btn-default btn-xs delete-btn" value="<?php echo $v['loudong_id'];?>"><span class="glyphicon glyphicon-remove"></span> 删除</button>
                
              </td>
            </tr>
            <?php endforeach;?>
            
          </tbody>
        </table> 
    	</div>
      <div class="panel-footer">
        <div class="pull-left">
          <div class="btn-group">
                  <button type="button" class="btn btn-default" id="reverseBtn"><span class="glyphicon glyphicon-ok"></span> 反选</button>
            <button type="button" id="deleteBtn"  class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 删除勾选</button>
                 </div>
      </div>
        <div class="pull-right">
        <?php echo $pages;?>
        </div>
      </div> 
      </form>  
  </div>
<?php else:?>
    <div class="no-result">-- 暂时数据 -- </div>
<?php endif;?>

	<script language="javascript" type="text/javascript">
	require(['/scripts/adminpanel/loudong/lists.js']); 
</script>
    