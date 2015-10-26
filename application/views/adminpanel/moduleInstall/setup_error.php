<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 模块安装失败提示
        <div class='panel-tools'>
            <div class='btn-group'>
                <?php aci_ui_a($folder_name,'manage','index','',' class="btn "','<span class="glyphicon glyphicon-arrow-left"></span> 返回')?>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="jumbotron">
        <div class="container">
            <h2>模块安装失败：（ </h2>
            <?php if($check_result)foreach($check_result as $k=>$v):?>
            <p><?php echo $v['error']?></p>
            <?php endforeach;?>
        </div>
    </div>
</div>
