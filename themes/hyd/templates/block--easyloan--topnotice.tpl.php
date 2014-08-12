<?php

global $base_url;

if ($variables['block']->params){
  drupal_add_js(drupal_get_path('theme','hyd') . '/js/topnotice.js');
?>
<!-- Notice -->
<div class="notice mb fn-clear">
  <div class="notice-wrapper grid_12">
    <div class="notice-head fn-clear">
      <a href="javascript:void(0);" target="_blank" class="notice-title h5 fn-left color-gray-text w700 fn-text-overflow" id="notice-title"><?php print $variables['block']->params['title'];?></a>
      <span class="notice-date fn-left color-silver-text"><?php print $variables['block']->params['date'];?></span>
      <a class="notice-more fn-right ui-button ui-button-transparent ui-button-small darkgray" href="about/notices" target="_blank">更多公告</a>
    </div>
    <div class="notice-content color-dimgray-text" id="notice-content">
      <?php print $variables['block']->params['body'];?>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div style="text-align: right;">
      <span style="font-size:14px;"><?php print $variables['block']->params['publisher'];?></span></div>
    <div style="text-align: right;">
      <span style="font-size:14px;"><?php print $variables['block']->params['date1'];?></span></div>
    </div>
  </div>
</div>
<?php } ?>