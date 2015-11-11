<div class='panel panel-default'>
    <div class='panel-heading'>
        <i class='glyphicon glyphicon-edit'></i> 菜单管理<?php echo $is_edit?"修改资料":"新增资料"?>
        <div class='panel-tools'>
            <div class='btn-group'>
                <a class='btn' href='<?php echo current_url() ?>'>
                    <i class='glyphicon glyphicon-refresh'></i>
                    刷新
                </a>
                <?php aci_ui_a($folder_name, $controller_name, 'index', '', ' class="btn btn-sm pull-right"', '<span class="glyphicon glyphicon-arrow-left"></span> 返回') ?>
            </div>
        </div>
    </div>
    <div class="panel-body">

        <form name="validateform" id="validateform" class="form-horizontal"
              action="<?php echo site_url($folder_name.'/'.$controller_name.'/edit') ?>" method="post">


            <div class="form-group">
                <label class="col-sm-2 control-label">上级菜单</label>

                <div class="col-sm-5">
                    <select name="parent_id" id="parent_id" class=" form-control">
                        <option value="0">作为一级菜单</option>
                        <?php echo $select_categorys; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">菜单名称</label>

                <div class="col-sm-5">
                    <input type="text" name="menu_name" value="<?php echo $data_info['menu_name'] ?>"
                           class="validate[required] form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">图标CSS</label>

                <div class="col-sm-5">
                    <input type="text" name="css_icon" value="<?php echo $data_info['css_icon'] ?>"
                           class="validate[required] form-control"/>
                    <p class="help-block"><a href="http://fontawesome.dashgame.com/" target="_blank">请输入fontawesome 图标CSS</a> </p>
                </div>
            </div>
            <div class="form-group" id="show-url" style="display: none">
                <label class="col-sm-2 control-label">URL</label>

                <div class="col-sm-5">
                    <select class="form-control" name="menu_url">
                        <?php echo folder_controller_method_options($data_info['folder'], $data_info['controller'], $data_info['method']); ?>
                    </select>
                </div>
            </div>
            <div class="form-group" id="show-where" style="display: none">
                <label class="col-sm-2 control-label">菜单所属位置</label>

                <div class="col-sm-5">
                    <label class=" control-label"><input type="radio" name="show_where"
                                                         value="0" <?php echo ($data_info['show_where']==0) ? 'checked="checked"' : '' ?> />
                        用户中心</label>&nbsp;&nbsp;<label class="control-label"><input type="radio" name="show_where"
                                                                                 value="1" <?php echo ($data_info['show_where']==1) ? 'checked="checked"' : '' ?>/>
                        管理中心</label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">是否显示菜单</label>

                <div class="col-sm-5">
                    <label class=" control-label"><input type="radio" name="is_display"
                                                         value="1" <?php echo ($data_info['is_display']) ? 'checked="checked"' : '' ?> />
                        是</label>&nbsp;&nbsp;<label class="control-label"><input type="radio" name="is_display"
                                                                                 value="0" <?php echo (!$data_info['is_display']) ? 'checked="checked"' : '' ?>/>
                        否</label>
                </div>
            </div>

            <div class='form-actions'>
                <?php aci_ui_button($folder_name,$controller_name, 'edit', ' type="submit" id="dosubmit" class="btn btn-primary" ', '保存') ?>
            </div>
        </form>
    </div>
</div>


<script language="javascript" type="text/javascript">

    var menu_id =<?php echo $data_info['menu_id']?>;
    var edit =<?php echo $is_edit?"true":"false"?>;
    var folder_name="<?php echo $folder_name?>";
    var controller_name ="<?php echo $controller_name?>";
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/edit.js']);
    });
</script>