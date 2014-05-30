<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

$js_path = $base_url . '/' . $theme_path . '/js/';
$image_path = $base_url . '/' . $theme_path . '/images/';

drupal_add_css($theme_path . '/css/account.css');
drupal_add_css($theme_path . '/css/dialog.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js('var js_path=\'' . $js_path . '\';var image_path=\'' . $image_path . '\';var account_name=null;', 'inline');
drupal_add_js($theme_path . '/js/banks.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/bankcardadd.js');
drupal_add_js($theme_path . '/js/bankcard.js');
?>
<div id="pg-account-bank" class="p20bs color-white-bg fn-clear">
  <div id="bankList" class="bankList" >
    <div class="title">已添加银行卡</div>
    <div id="banklis" class="mt20">
      <ul class="fn-clear">
        <li>
          <a class="openLink addBank" tabindex="-1">
            <img src="<?php print $image_path; ?>add.jpg">
          </a>
          <div class="card"><a class="openLink addBank" tabindex="-1">新增银行卡</a></div>
        </li>
      </ul>
    </div>
  </div>
</div>