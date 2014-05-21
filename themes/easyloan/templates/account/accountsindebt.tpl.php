<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/itemlist.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $base_url;
?>
<div class="p20bs color-white-bg">
<div class="fn-clear">
  <h3 class="text-xl">欠款账户</h3>
  <ul class="ui-list ui-list-s mt10" id="transactions">
    <li class="ui-list-header color-gray-text fn-clear">
      <span class="ui-list-title w60 ph10 fn-left">昵称</span>
      <!--span class="ui-list-title w50 fn-left">姓名</span-->
      <span class="ui-list-title w60 ph10 fn-left">借款标题</span>
      <span class="ui-list-title w80 fn-left">抵押类型</span>
      <span class="ui-list-title w80 fn-left">借款金额</span>
      <span class="ui-list-title w60 fn-left">借款利息</span>
      <span class="ui-list-title w60 fn-left">年利率</span>
      <span class="ui-list-title w60 fn-left">还款方式</span>
      <span class="ui-list-title w60 fn-left">借款期限</span>
      <span class="ui-list-title w80 fn-left">借款日期</span>
      <span class="ui-list-title w80 fn-left">还款记录</span>
    </li>
    <li class="ui-list-item color-gray-text fn-clear">
      <span class="ui-list-field w60 ph10 fn-left" title="习近平"><a>TheBigBoss</a></span>
      <span class="ui-list-field w60 ph10 fn-left">借钱买房</span>
      <span class="ui-list-field w80 fn-left">机动车抵押</span>
      <span class="ui-list-field w80 fn-left text-right">1,000元</span>
      <span class="ui-list-field w60 fn-left text-center">18%</span>
      <span class="ui-list-field w60 fn-left text-center">18%</span>
      <span class="ui-list-field w60 two-line fn-left">先息后本月头支付</span>
      <span class="ui-list-field w60 fn-left text-center">18个月</span>
      <span class="ui-list-field w80 fn-left">2014-04-04</span>
      <span class="ui-list-field w80 fn-left text-center"><a href="accountsindebt/123456" target="_blank"  class="ui-button ui-button-small ui-button-blue">查看</a></span>
    </li>
    <li class="ui-list-item color-gray-text fn-clear">
      <span class="ui-list-field w60 ph10 fn-left" title="李克强"><a>The2ndBoss</a></span>
      <span class="ui-list-field w60 ph10 fn-left">买车急用</span>
      <span class="ui-list-field w80 fn-left">黄金抵押</span>
      <span class="ui-list-field w80 fn-left text-right">80,000元</span>
      <span class="ui-list-field w60 fn-left text-center">12%</span>
      <span class="ui-list-field w60 fn-left text-center">12%</span>
      <span class="ui-list-field w60 two-line fn-left">先息后本月头支付</span>
      <span class="ui-list-field w60 fn-left text-center">12个月</span>
      <span class="ui-list-field w80 fn-left">2014-04-04</span>
      <span class="ui-list-field w80 fn-left text-center"><a href="accountsindebt/123457" target="_blank" class="ui-button ui-button-small ui-button-blue">查看</a></span>
    </li>
    <li class="ui-list-item color-gray-text fn-clear">
      <span class="ui-list-field w60 ph10 fn-left" title="彭丽媛"><a>The3rdBoss</a></span>
      <span class="ui-list-field w60 ph10 fn-left">借钱还债</span>
      <span class="ui-list-field w80 fn-left">其他抵押</span>
      <span class="ui-list-field w80 fn-left text-right">9,000元</span>
      <span class="ui-list-field w60 fn-left text-center">20%</span>
      <span class="ui-list-field w60 fn-left text-center">20%</span>
      <span class="ui-list-field w60 two-line fn-left">先息后本月头支付</span>
      <span class="ui-list-field w60 fn-left text-center">3个月</span>
      <span class="ui-list-field w80 fn-left">2014-04-04</span>
      <span class="ui-list-field w80 fn-left text-center"><a href="accountsindebt/123458" target="_blank" class="ui-button ui-button-small ui-button-blue">查看</a></span>
    </li>
    <!-- 
      <li class="ui-list-status"> 
        <p class="color-gray-text">没有记录</p> 
      </li> 
    -->
    </ul>
    <div class="fn-right mt10 ui-pagination" id="transactions-pagination">
      <ul>
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
      </ul>
    </div>
  </div>
</div>