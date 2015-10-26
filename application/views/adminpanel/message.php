<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<div class="container">
<div class="jumbotron">
  <h1>提示!</h1>
  <p><?php echo $msg; ?></p>
  <p>
  	 <?php if($url_forward=='goback' || $url_forward=='') {?>
	<a href="javascript:history.back();" >[返回上一步]</a>
	<?php } elseif($url_forward=="close") {?>
	<input type="button" name="close" value="关闭" onClick="window.close();">
	<?php } elseif($url_forward=="blank") {?>

	<?php } elseif($url_forward && !$returnjs) {
	?>
	<a href="<?php echo $url_forward?>">点击这里</a>
	<script language="javascript">setTimeout(function(){window.location.href='<?php echo $url_forward?>';},<?php echo $ms?>);</script>
	<?php }?>
	<?php if($returnjs) { ?> <script style="text/javascript"><?php echo $returnjs;?></script><?php } ?>
	<?php if ($dialog):?><script style="text/javascript">window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();</script><?php endif;?>
  </p>
</div>
</div>