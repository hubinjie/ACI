<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo base_url('adminpanel/loudong/edit')?>" >
 <div class='panel panel-default '>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 楼栋信息 修改信息 
        <div class='panel-tools'>
            <div class='btn-group'>
            	<a class="btn " href="<?php echo base_url('adminpanel/loudong')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
            </div>
        </div>
    </div>
    <div class='panel-body '>
	<fieldset>
        <legend>基本信息</legend>
	  		  		<div class="form-group">
				<label for="loudong_name" class="col-sm-2 control-label form-control-static">楼栋名称</label>
				<div class="col-sm-9 ">
					<input type="text" name="loudong_name"  id="loudong_name"  value='<?php echo isset($data_info['loudong_name'])?$data_info['loudong_name']:'' ?>'  class="form-control validate[required]"  placeholder="请输入楼栋名称" >
				</div>
			</div>
			  		<div class="form-group">
				<label for="loudong_area" class="col-sm-2 control-label form-control-static">楼栋面积</label>
				<div class="col-sm-9 ">
					<input type="number" name="loudong_area"  id="loudong_area"  value='<?php echo isset($data_info['loudong_area'])?$data_info['loudong_area']:'' ?>'   class="form-control  validate[required,custom[integer]]" placeholder="请输入楼栋面积" >
				</div>
			</div>
			  		<div class="form-group">
				<label for="loudong_manager" class="col-sm-2 control-label form-control-static">楼栋管理员</label>
				<div class="col-sm-9 ">
					<input type="text" name="loudong_manager"  id="loudong_manager"  value='<?php echo isset($data_info['loudong_manager'])?$data_info['loudong_manager']:'' ?>'  class="form-control validate[required]"  placeholder="请输入楼栋管理员" >
				</div>
			</div>
			  				  			    </fieldset>
	<fieldset>
        <legend>可选信息</legend>
	  		  		<div class="form-group">
				<label for="loudong_remark" class="col-sm-2 control-label form-control-static">楼栋备注</label>
				<div class="col-sm-9 ">
					<textarea name="loudong_remark"  id="loudong_remark"  cols="45" rows="5" class="form-control " placeholder="请输入楼栋备注" > <?php echo isset($data_info['loudong_remark'])?$data_info['loudong_remark']:'' ?></textarea>
				</div>
			</div>
		    </fieldset>
	<div class='form-actions'>
        <button class='btn btn-primary ' type='submit' id="dosubmit">保存</button>
    </div>
</form>
	<script language="javascript" type="text/javascript">
	var is_edit =<?php echo ($is_edit)?"true":"false" ?>;
	var id =<?php echo $id;?>;
	require(['/scripts/adminpanel/loudong/edit.js']); 
</script>
	
