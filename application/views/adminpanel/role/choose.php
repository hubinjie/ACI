<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>

<?php if($data_list):?>
    <div class="panel panel-default">
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
                            <?php $fun_args ="'".$v['role_id']."','".$v['role_name']."'"; ?>
                            <a href="javascript:window.parent.get<?php echo ucfirst($control_id);?>(<?php echo $fun_args;?>)" class="btn btn-success btn-xs" title="选取当前"> 选取</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>
