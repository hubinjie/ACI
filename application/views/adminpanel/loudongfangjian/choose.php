<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><form class="form-inline" role="form" method="get">
      <div class="form-group">
        <div class="input-group">
          <input class="form-control" name="keyword" type="text" value="<?php echo $keyword;?>" placeholder="请输入关键词">
        </div>
      </div>
      <button type="submit" name="dosubmit" class="btn btn-success">搜索...</button>
    </form>
<hr/>
<?php if($data_list):?>
<div class="panel panel-default">
<div class="table-responsive">
        <table class="table table-hover dataTable"> 
          <thead>
            <tr>
              <th>#</th>
              <?php unset($fields_caption[0]);foreach($fields_caption as $k=>$v):?>
              <th nowrap="nowrap"><?php echo $v;?></th>
               <?php endforeach;?>
               <th nowrap="nowrap">选择</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($data_list as $k=>$v):?>
          <?php $new_fields = $fields; $first_key = $new_fields[0]; $first_value= $v[$first_key];  ?>
            <tr>
            <td><?php echo $k+1?></td>
              <?php unset($new_fields[0]);$caption=NULL;foreach($new_fields as $kk=>$vv): $caption[] =$v[$vv];?>
              <td><?php echo $v[$vv]?></td>
               <?php endforeach;?>
              <td><?php $fun_args ="'".$first_value."','".implode($concat_char,$caption)."'"; ?>
              <a href="javascript:window.parent.get<?php echo ucfirst($control_id);?>(<?php echo $fun_args;?>)" class="btn btn-success btn-xs" title="选取当前"> 选取</a></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
    	</div>
      <div class="pull-left"></div>
      <div class="pull-right">
      <?php echo $pages;?>
      </div>
</div>
<?php endif;?>
