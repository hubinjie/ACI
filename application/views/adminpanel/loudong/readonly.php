<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><div class='panel panel-default '>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 楼栋信息 查看信息 
        <div class='panel-tools'>
            <div class='btn-group'>
            	<a class="btn " href="<?php echo base_url('adminpanel/loudong')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
            </div>
        </div>
    </div>
    <div class='panel-body '>
<div class="form-horizontal"  >
	<fieldset>
        <legend>基本信息</legend>
     
  	  		<div class="form-group">
				<label for="loudong_name" class="col-sm-2 control-label form-control-static">楼栋名称</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['loudong_name'])?$data_info['loudong_name']:'' ?>
				</div>
			</div>
	  		<div class="form-group">
				<label for="loudong_area" class="col-sm-2 control-label form-control-static">楼栋面积</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['loudong_area'])?$data_info['loudong_area']:'' ?>
				</div>
			</div>
	  		<div class="form-group">
				<label for="loudong_manager" class="col-sm-2 control-label form-control-static">楼栋管理员</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['loudong_manager'])?$data_info['loudong_manager']:'' ?>
				</div>
			</div>
	  		<div class="form-group">
				<label for="user_id" class="col-sm-2 control-label form-control-static">创建者</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['user_id'])?$data_info['user_id']:'' ?>
				</div>
			</div>
	  		<div class="form-group">
				<label for="created" class="col-sm-2 control-label form-control-static">创建时间</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['created'])?$data_info['created']:'' ?>
				</div>
			</div>
	    </fieldset>
	<fieldset>
        <legend>可选信息</legend>
     
  	  		<div class="form-group">
				<label for="loudong_remark" class="col-sm-2 control-label form-control-static">楼栋备注</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['loudong_remark'])?$data_info['loudong_remark']:'' ?>
				</div>
			</div>
	    </fieldset>
	</div>
</div>
</div>
