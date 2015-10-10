<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo base_url('adminpanel/loudongfangjian/edit')?>" >
 <div class='panel panel-default '>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 楼栋房间信息 修改信息 
        <div class='panel-tools'>
            <div class='btn-group'>
            	<a class="btn " href="<?php echo base_url('adminpanel/loudongfangjian')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
            </div>
        </div>
    </div>
    <div class='panel-body '>
	<fieldset>
        <legend>基本信息</legend>
	  		  		<div class="form-group">
				<label for="loudong_id" class="col-sm-2 control-label form-control-static">楼栋</label>
				<div class="col-sm-9 ">
					<?php $options = process_datasource($this->method_config['dropdown_loudong_datasource'])?>
					<select class="form-control  validate[required]"  name="loudong_id"  id="loudong_id">
						<option value="">==请选择==</option>
<?php if($options)foreach($options as $option):?>
						<option value='<?php echo $option['val'];?>' <?php if(isset($data_info['loudong_id'])&&($data_info['loudong_id']==$option['val'])) { ?> selected="selected" <?php } ?>            ><?php echo $option['text'];?></option>
<?php endforeach;?>
					</select>

				</div>
			</div>
			  		<div class="form-group">
				<label for="loudongfangjian_name" class="col-sm-2 control-label form-control-static">房间号</label>
				<div class="col-sm-9 ">
					<input type="text" name="loudongfangjian_name"  id="loudongfangjian_name"  value='<?php echo isset($data_info['loudongfangjian_name'])?$data_info['loudongfangjian_name']:'' ?>'  class="form-control validate[required]"  placeholder="请输入房间号" >
				</div>
			</div>
			  		<div class="form-group">
				<label for="loudongfangjian_area" class="col-sm-2 control-label form-control-static">房间面积</label>
				<div class="col-sm-9 ">
					<input type="number" name="loudongfangjian_area"  id="loudongfangjian_area"  value='<?php echo isset($data_info['loudongfangjian_area'])?$data_info['loudongfangjian_area']:'' ?>'   class="form-control  validate[required,custom[integer]]" placeholder="请输入房间面积" >
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
	require(['/scripts/adminpanel/loudongfangjian/edit.js']); 
</script>
	
