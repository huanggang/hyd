<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_js($theme_path . '/js/investments_front.js');
?>
<!-- Invest List -->
<div class="loan mb fn-clear">
  <div class="grid_12">
    <div class="list-title loan">
      <span class="on">投资列表</span>
    </div>
    <ul class="ui-list ui-list-m ui-list-invest">
      <li class="ui-list-header fn-clear" id="loan-list-header">
        <span class="ui-list-title fn-left color-gray-text w250 pl15 pr20">借款标题</span>
        <span class="ui-list-title fn-left color-gray-text text-center w60 pr20">年利率</span>
        <span class="ui-list-title fn-left color-gray-text text-center w100 pr20">金额</span>
        <span class="ui-list-title fn-left color-gray-text text-center w50 pr20">期限</span>
        <span class="ui-list-title fn-left color-gray-text text-center w80 pr20">成立日</span>
        <span class="ui-list-title fn-left color-gray-text text-center w80 pr20">到期日</span>
        <span class="ui-list-title fn-left color-gray-text text-center w70 pr20">进度</span>
        <span class="ui-list-title fn-left color-gray-text text-center w90"></span>
      </li>

      <li class="ui-list-more" id="products">
        <a class="darkgray" href="invest" target="_blank">查看更多投资理财项目</a>
      </li>
    </ul>
  </div>
</div>