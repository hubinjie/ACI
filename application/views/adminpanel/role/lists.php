<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='glyphicon glyphicon-th-list'></i> 用户组管理列表
        <div class='panel-tools'>

            <div class='btn-group'>
                <?php aci_ui_a($folder_name, 'role', 'add', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-plus"></span> 添加') ?>
            </div>
            <div class='badge'><?php echo count($data_list) ?></div>
        </div>
    </div>


    <?php if ($data_list): ?>
    <div class="panel panel-body">
        <form method="post" id="form_list">
            <div class="table-responsive">

                <table class="table table-hover dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th nowrap="nowrap" width="70%">用户组名</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_list as $k => $v): ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $v['role_name'] ?></td>
                            <td>
                                <?php aci_ui_a($folder_name, 'role', 'edit', $v['role_id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-edit"></span> 修改') ?>
                                <?php if($v['role_id']!=SUPERADMIN_GROUP_ID):?>
                                <?php aci_ui_a($folder_name, 'role', 'setting', $v['role_id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-eye-open"></span> 权限分配') ?>
                                <?php aci_ui_a($folder_name, 'role', 'delete_one', $v['role_id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-edit"></span> 删除') ?>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

    </div>
    <?php if($pages):?>
    <div class=" panel-footer">
        <div class="pull-left">
        </div>
        <div class="pull-right">
            <?php echo $pages; ?>
        </div>
        </form>
    </div>
    <?php endif?>
</div>
<?php else: ?>
    <div class="panel panel-body">
        <div class="alert alert-warning" role="alert"> 暂无数据显示... 您可以进行新增操作</div>
    </div>
<?php endif; ?>
<script language="javascript" type="text/javascript">
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/list.js']);
    });
</script>