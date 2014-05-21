<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');

global $base_url;
$img_path = $base_url . '/' . drupal_get_path('theme','easyloan') . '/images/';
?>
<div id="pg-account-bank" class="p20bs color-white-bg fn-clear">
         <div id="bankList" class="bankList" >
              <div class="title">已添加银行卡</div>
              <div id="banklis" class="mt20">
<ul class="fn-clear">

<li data-bank="92585">
<img alt="" title="" src="<?php print $img_path; ?>code_104.jpg">
<div>6247 **** **** 6247</div> 
<div class="card"><a href="/account/userBank!toModify.action?userBankId=92585" class="link mod openLink" tabindex="-1">修改</a><a href="/account/userBank!del.action?userBankId=92585" class="link del">删除</a></div>
</li>

<li><a href="/account/userBank!toAdd.action" class="openLink" tabindex="-1"><img src="<?php print $img_path; ?>add.jpg"></a><div class="card"><a href="/account/userBank!toAdd.action" class="openLink addBank" id="addBank" tabindex="-1">新增银行卡</a></div></li>
</ul>
</div>
</div>
</div>