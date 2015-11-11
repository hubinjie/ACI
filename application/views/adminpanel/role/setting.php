<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<form method="post" id="form_list" action="<?php echo current_url() ?>">

    <div class='panel panel-default'>
        <div class='panel-heading'>
            <i class='icon-edit icon-large'></i>
            权限列表
            <div class='panel-tools'>

                <div class='btn-group'>
                    <?php aci_ui_a($folder_name, 'role', 'index', '', ' class="btn btn-sm pull-right"', '<span class="glyphicon glyphicon-arrow-left"></span> 返回') ?>
                </div>
            </div>
        </div>
        <div class='panel-body'>
            <fieldset>
                <legend><?php echo $data_info['role_name'] ?> 权限</legend>
                <table class="table table-hover dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th nowrap="nowrap">用户组</th>
                        <th>权限</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo $table_html ?>
                    </tbody>
                </table>
            </fieldset>

            <div class='form-actions'>
                <?php aci_ui_button($folder_name, 'role', 'setting', 'type="submit" id="dosubmit" class="btn btn-primary "', '保存设置') ?>
            </div>

        </div>
    </div>
</form>
<script language="javascript" type="text/javascript">
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/setting.js']);
    });
</script>