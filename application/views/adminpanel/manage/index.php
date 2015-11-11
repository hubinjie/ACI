<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>

<div class="panel">
    <div class="panel-body">
        <div class="row placeholders">
            <?php if (isset($menu_data)) foreach ($menu_data as $k => $v): ?>
                <div class="col-xs-12 col-sm-3 ">
                    <a href="<?php echo $v['url'] ?>"><p class="circle"><i class="fa fa-<?php echo $v['css_icon'] ?> fa-4x"></i></p>
                    <h4><?php echo $v['menu_name'] ?></h4></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/index.js']);
    });
</script>