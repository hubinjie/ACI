<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='glyphicon glyphicon-th-list'></i> 成员列表
        <div class='panel-tools'>

            <div class='btn-group'>
                <?php aci_ui_a($folder_name, 'user', 'add', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-plus"></span> 添加') ?>
            </div>
            <div class='badge'><?php echo count($data_list) ?></div>
        </div>
    </div>
    <div class='panel-filter '>
        <form class="form-inline" role="form" method="get">
            <div class="form-group">
                <label for="keyword" class="form-control-static control-label">关键词</label>
                <input class="form-control" type="text" name="keyword" value="<?php echo $keyword; ?>" id="keyword"
                       placeholder="请输入关键词"/></div>
            <button type="submit" name="dosubmit" value="搜索" class="btn btn-success"><i
                    class="glyphicon glyphicon-search"></i></button>
        </form>
    </div>
    <form method="post" id="form_list">

        <?php if ($data_list): ?>
            <div class='panel-body '>


                <table class="table table-hover dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
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
                            <td> <?php if ($v['is_lock']): ?><span
                                    class="glyphicon glyphicon-lock"></span><?php else: ?><span
                                    class="glyphicon glyphicon-user"></span><?php endif; ?></td>
                            <td><?php echo $v['username'] ?></td>
                            <td><?php echo $v['fullname'] ?></td>
                            <td><?php echo $v['email'] ?></td>
                            <td><?php echo $v['mobile'] ?></td>
                            <td><?php echo group_name($v['group_id']) ?></td>
                            <td><?php echo $v['last_login_time'] ?></td>
                            <td>
                                <?php aci_ui_a($folder_name, 'user', 'edit', $v['user_id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-edit"></span> 修改') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>

            </div>

            <div class="panel-footer">
                <div class="pull-left">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="reverseBtn"><span
                                class="glyphicon glyphicon-ok"></span> 反选
                        </button>
                        <?php aci_ui_button($folder_name, 'user', 'lock', ' class="btn btn-default" id="lockBtn" ', '<span class="glyphicon glyphicon-lock"></span> 反设置禁止登录') ?>
                        <?php aci_ui_button($folder_name, 'user', 'delete', ' class="btn btn-default" id="deleteBtn" ', '<span class="glyphicon glyphicon-remove"></span> 删除勾选') ?>
                    </div>
                </div>
                <div class="pull-right">
                    <?php echo $pages; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-warning" role="alert"> 暂无数据显示... 您可以进行新增操作</div>
        <?php endif; ?>
    </form>
</div>
</div>

<script language="javascript" type="text/javascript">
    var folder_name = "<?php echo $folder_name?>";
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/index.js']);
    });
</script>
