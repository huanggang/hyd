<style>
#content-list table{
	width:920px;
	margin-top:20px;
}
#content-list table ul.links li{
	float: left;
	padding: 10px;
	width:20px;
	font-size: 13px
}
</style>
<div id="pg-reg" class="container_12"> 
<div class="p20bs w920 fn-clear color-white-bg">
  <div class="fn-clear mb20">
    <h3 class="fn-left mr10">内容管理</h3>
  </div>
  <div>
	<ul class="action-links">
		<li>
			<a href="/d71/node/add" class="ui-button ui-button-blue ui-button-mid">发布新内容</a>
		</li>
	</ul>
  </div>
  <ul class="ui-list ui-list-m " id="content-list">
  	<?php print drupal_render($form['filter']);?>
	<?php print drupal_render($form['admin']);?>
	<?php print drupal_render($form['form_id']);?>
	<?php print drupal_render($form['#type']);?>
	<?php print drupal_render($form['#build_id']);?>
	<?php print drupal_render($form['form_build_id']);?>
	<?php print drupal_render($form['#token']);?>
	<?php print drupal_render($form['form_token']);?>
  </ul>
</div>
</div>