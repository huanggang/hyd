<style>
li.content-type{
	margin-top: 10px;
}
</style>
<div id="pg-reg" class="container_12"> 
<div class="p20bs w920 fn-clear color-white-bg">
  <div class="fn-clear mb20">
    <h3 class="fn-left mr10">请选择发布内容类型</h3>
  </div>

  <ul class="ui-list ui-list-m " id="content-type-list">
  	<?php 
  		global $base_url;
  		$base_path = $base_url . '/';

  		foreach ($content as $key => $value) {
	?>
		<li class="content-type">
			<a href="<?php print $base_path . $value['link_path']; ?>" class="ui-button ui-button-blue ui-button-mid"><?php print $value['link_title']; ?></a>
		</li>
		<li class='info'><?php print $value['description']; ?></li>
	<?php 
  		}
  	?>

  </ul>
</div>
</div>