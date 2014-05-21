<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $base_url;
?>
<div class="p20bs color-white-bg">
<div class="fn-clear">
  <h3 class="text-xl">还款记录</h3>
  <ul class="ui-list ui-list-s mt10" id="transactions">
    <li class="ui-list-header color-gray-text fn-clear">
      <span class="ui-list-title w80 ph10 fn-left">时间</span>
      <span class="ui-list-title w120 ph10 fn-left">类型明细</span>
      <span class="ui-list-title w80 fn-left">收入</span>
      <span class="ui-list-title w80 fn-left">支出</span>
      <span class="ui-list-title w80 fn-left">余额</span>
      <span class="ui-list-title w80 fn-left">欠款</span>
      <span class="ui-list-title w80 fn-left">罚金</span>
      <span class="ui-list-title w80 fn-left">备注</span>
    </li>
    <li class="ui-list-item color-gray-text fn-clear dark">
      <span class="ui-list-field w80 ph10 fn-left">2014-01-01</span>
      <span class="ui-list-field w120 ph10 fn-left">先息后本月头支付</span>
      <span class="ui-list-field w80 fn-left text-right">10,000元</span>
      <span class="ui-list-field w80 fn-left text-right">8,000元</span>
      <span class="ui-list-field w80 fn-left text-right">2,000元</span>
      <span class="ui-list-field w80 fn-left text-right">1,000元</span>
      <span class="ui-list-field w80 fn-left text-right">200元</span>
      <span class="ui-list-field w80 fn-left text-center">没打算还</span>
    </li>
    <li class="ui-list-item color-gray-text fn-clear">
      <span class="ui-list-field w80 ph10 fn-left">2014-01-01</span>
      <span class="ui-list-field w120 ph10 fn-left">先息后本月头支付</span>
      <span class="ui-list-field w80 fn-left text-right">10,000元</span>
      <span class="ui-list-field w80 fn-left text-right">8,000元</span>
      <span class="ui-list-field w80 fn-left text-right">2,000元</span>
      <span class="ui-list-field w80 fn-left text-right">1,000元</span>
      <span class="ui-list-field w80 fn-left text-right">200元</span>
      <span class="ui-list-field w80 fn-left text-center">没打算还</span>
    </li>
    <li class="ui-list-item color-gray-text fn-clear dark">
      <span class="ui-list-field w80 ph10 fn-left">2014-01-01</span>
      <span class="ui-list-field w120 ph10 fn-left">先息后本月头支付</span>
      <span class="ui-list-field w80 fn-left text-right">10,000元</span>
      <span class="ui-list-field w80 fn-left text-right">8,000元</span>
      <span class="ui-list-field w80 fn-left text-right">2,000元</span>
      <span class="ui-list-field w80 fn-left text-right">1,000元</span>
      <span class="ui-list-field w80 fn-left text-right">200元</span>
      <span class="ui-list-field w80 fn-left text-center">没打算还</span>
    </li>
    <!-- 
      <li class="ui-list-status"> 
        <p class="color-gray-text">没有记录</p> 
      </li> 
    -->
    </ul>
    <div class="fn-right mt10 ui-pagination" id="transactions-pagination">
      <!--ul>
        <li class="active"><span class="current prev">Prev</span></li>
        <li class="active"><span class="current">1</span></li>
        <li><a href="#page-2" class="page-link">2</a></li>
        <li><a href="#page-3" class="page-link">3</a></li>
        <li><a href="#page-4" class="page-link">4</a></li>
        <li><a href="#page-5" class="page-link">5</a></li>
        <li class="disabled"><span class="ellipse">…</span></li>
        <li><a href="#page-22" class="page-link">22</a></li>
        <li><a href="#page-23" class="page-link">23</a></li>
        <li><a href="#page-2" class="page-link next">Next</a></li>
      </ul-->
    </div>
  </div>
</div>