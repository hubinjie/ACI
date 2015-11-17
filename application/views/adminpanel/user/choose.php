<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<form class="form-inline" role="form" method="get">
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
                    <th>用户名</th>
                    <th>全名</th>
                    <th>邮箱</th>
                    <th>手机号</th>
                    <th>会员组</th>
                    <th>上次登录时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_list as $k => $v): ?>
                    <tr>
                        <td><input type="checkbox" name="pid[]" value="<?php echo $v['user_id'] ?>"/></td>
                        <td><?php echo $v['username'] ?></td>
                        <td><?php echo $v['fullname'] ?></td>
                        <td><?php echo $v['email'] ?></td>
                        <td><?php echo $v['mobile'] ?></td>
                        <td><?php echo group_name($v['group_id']) ?></td>
                        <td><?php echo $v['last_login_time'] ?></td>
                        <td>
                            <?php $fun_args ="'".$v['user_id']."','".$v['username']."'"; ?>
                            <a href="javascript:window.parent.get<?php echo ucfirst($control_id);?>(<?php echo $fun_args;?>)" class="btn btn-success btn-xs" title="选取当前"> 选取</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
        <div class="pull-left"></div>
        <div class="pull-right">
            <?php echo $pages;?>
        </div>
    </div>
<?php endif;?>
