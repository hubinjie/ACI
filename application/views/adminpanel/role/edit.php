<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo current_url()?>" >

<div class='panel panel-default'>
	<div class='panel-heading'>
		<i class='glyphicon glyphicon-edit'></i>
		<?php echo $is_edit?"修改":"新增"?>用户资料
		<div class='panel-tools'>

			<div class='btn-group'>
				<?php aci_ui_a($folder_name,'role','index','',' class="btn  btn-sm pull-right"','<span class="glyphicon glyphicon-arrow-left"></span> 返回')?>

			</div>
		</div>
	</div>
	<div class='panel-body'>
		<fieldset>
			<div class="form-group">
				<label for="role_name" class="col-sm-2 control-label">用户组名</label>
				<div class="col-sm-9">
					<input type="text" name="role_name"  id="role_name"  value='<?php echo isset($data_info['role_name'])?$data_info['role_name']:'' ?>'  class="form-control validate[required]"  placeholder="请输入用户组名" >
				</div>
			</div>
			<div class="form-group">
				<label for="description" class="col-sm-2 control-label">用户组描述</label>
				<div class="col-sm-9">
					<textarea name="description"  id="description"  cols="45" rows="5" class="form-control  validate[required]" placeholder="请输入用户组描述" > <?php echo isset($data_info['description'])?$data_info['description']:'' ?></textarea>
				</div>
			</div>
		</fieldset>

	<div class='form-actions'>
		<?php aci_ui_button($folder_name,'role','edit','type="submit" id="dosubmit" class="btn btn-primary "','保存')?>
	</div>
	</div>
	</div>

</form>
<script language="javascript" type="text/javascript">
	var id="<?php echo $data_info['role_id']?>";
	var edit= <?php echo $is_edit?"true":"false"?>;
	var folder_name = "<?php echo $folder_name?>";
	require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
		require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/edit.js']);
	});
</script>