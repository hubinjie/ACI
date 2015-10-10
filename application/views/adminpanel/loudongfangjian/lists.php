<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 楼栋房间信息列表
        <div class='panel-tools'>
            <div class='btn-group'>
                 <a class="btn " href="<?php echo base_url('adminpanel/loudongfangjian/add')?>"><span class="glyphicon glyphicon-plus"></span> 添加 </a>             </div>
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
				<label for="loudong_id" class="col-sm-5 control-label form-control-static">楼栋</label>
				<div class="col-sm-7 ">
					<?php $options = process_datasource($this->method_config['dropdown_loudong_datasource'])?>
					<select class="form-control "  name="loudong_id"  id="loudong_id">
						<option value="">==不限==</option>
<?php if($options)foreach($options as $option):?>
						<option value='<?php echo $option['val'];?>' <?php if(isset($data_info['loudong_id'])&&($data_info['loudong_id']==$option['val'])) { ?> selected="selected" <?php } ?>            ><?php echo $option['text'];?></option>
<?php endforeach;?>
					</select>

				</div>
			</div>
<button type="submit" name="dosubmit" value="搜索" class="btn btn-success"><i class='glyphicon glyphicon-search'></i></button>        </form>
        </div>
      </div> 
    </div>
          <form method="post" id="form_list"  action="<?php echo base_url('adminpanel/loudongfangjian/delete_all')?>"  > 
    <div class='panel-body '>
    <?php if($data_list):?>
        <table class="table table-hover dataTable" id="checkAll">
          <thead>
            <tr>
              <th>#</th>
                            <?php $css=""; $next_url = base_url('adminpanel/loudongfangjian?order=loudong_id&dir=desc'); ?>
              <?php if(($order=='loudong_id'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/loudongfangjian?order=loudong_id&dir=asc'); ?>
              <?php } elseif (($order=='loudong_id'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">楼栋</th>
                            <?php $css=""; $next_url = base_url('adminpanel/loudongfangjian?order=loudongfangjian_name&dir=desc'); ?>
              <?php if(($order=='loudongfangjian_name'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/loudongfangjian?order=loudongfangjian_name&dir=asc'); ?>
              <?php } elseif (($order=='loudongfangjian_name'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">房间号</th>
              <th   nowrap="nowrap">房间面积</th>
              <th   nowrap="nowrap">创建时间</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($data_list as $k=>$v):?>
            <tr>
              <td><input type="checkbox" name="pid[]" value="<?php echo $v['loudongfangjian_id']?>" /></td>
                             <td><?php echo $v['loudong_id']?></td>
                            <td><?php echo $v['loudongfangjian_name']?></td>
                            <td><?php echo $v['loudongfangjian_area']?></td>
                            <td><?php echo $v['created']?></td>
              <td>
                            	<a href="<?php echo base_url('adminpanel/loudongfangjian/readonly/'.$v['loudongfangjian_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-share-alt"></span> 查看</a>
                                            <a href="<?php echo base_url('adminpanel/loudongfangjian/edit/'.$v['loudongfangjian_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit"></span> 修改</a>
                                            <button type="button" class="btn btn-default btn-xs delete-btn" value="<?php echo $v['loudongfangjian_id'];?>"><span class="glyphicon glyphicon-remove"></span> 删除</button>
                
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
	require(['/scripts/adminpanel/loudongfangjian/lists.js']); 
</script>
    