<?php
//drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/tab.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/itemlist.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/tab.js');
global $base_url;
?>
<div class="color-white-bg" id="withdrawappl">
  <div class="ui-tab ui-tab-transparent" id="withdrawappl-tab">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="checking">
        <a class="ui-tab-item-link">未转账</a>
      </li>
      <li class="ui-tab-item" data-name="checked">
        <a class="ui-tab-item-link">已转账</a>
      </li>
    </ul>
  </div>
  <div class="p20bs color-white-bg">
    <div id="repayments-tab-content">
      <div class="ui-tab-content ui-tab-content-current fn-clear" data-name="checking">
        <ul class="ui-list ui-list-s repaid" id="repaid-list">
          <li class="ui-list-header color-gray-text fn-clear">
            <span class="ui-list-title w50 ph10 fn-left title">开户名</span>
            <span class="ui-list-title w80 fn-left">提现金额</span>
            <span class="ui-list-title w50 fn-left">手续费</span>
            <span class="ui-list-title w100 fn-left">银行</span>
            <span class="ui-list-title w80 fn-left">支行</span>
            <span class="ui-list-title w120 fn-left">卡号</span>
            <span class="ui-list-title w100 fn-left">所在地</span>
            <span class="ui-list-title w80 fn-left">申请日期</span>
            <span class="ui-list-title w60 fn-left last">转账</span>
          </li>
          <li class="ui-list-item fn-clear dark">
            <span class="ui-list-field w50 ph10 fn-left"><a>习近平</a></span>
            <span class="ui-list-field w80 fn-left text-right">20,000元</span>
            <span class="ui-list-field w50 fn-left text-right">50元</span>
            <span class="ui-list-field w100 fn-left text-center">中国银行</span>
            <span class="ui-list-field w80 two-line fn-left">中国银行麓谷支行</span>
            <span class="ui-list-field w120 fn-left num-s">4563517512312312312</span>
            <span class="ui-list-field w100 two-line fn-left">湖南长沙岳麓区</span>
            <span class="ui-list-field w80 fn-left">2014-04-08</span>
            <span class="ui-list-title w60 fn-left last">
              <a class="ui-button ui-button-small ui-button-green">转账</a>
            </span>
          </li>
          <li class="ui-list-item fn-clear">
            <span class="ui-list-field w50 ph10 fn-left"><a>李克强</a></span>
            <span class="ui-list-field w80 fn-left text-right">3000元</span>
            <span class="ui-list-field w50 fn-left text-right">20元</span>
            <span class="ui-list-field w100 fn-left text-center">工商银行</span>
            <span class="ui-list-field w80 two-line fn-left">工商银行麓谷支行</span>
            <span class="ui-list-field w120 fn-left num-s">6222021001116245703</span>
            <span class="ui-list-field w100 two-line fn-left">湖南长沙岳麓区</span>
            <span class="ui-list-field w80 fn-left">2014-04-03</span>
            <span class="ui-list-title w60 fn-left last">
              <a class="ui-button ui-button-small ui-button-green">转账</a>
            </span>
          </li>
          </ul>
        <div class="fn-right mt10 ui-pagination simple-pagination" id="repaid-list-pagination">
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
      <div class="ui-tab-content fn-clear" data-name="checked">
        <ul class="ui-list ui-list-s repaid" id="repaid-list">
          <li class="ui-list-header color-gray-text fn-clear">
           <span class="ui-list-title w50 ph10 fn-left title">开户名</span>
            <span class="ui-list-title w80 fn-left">提现金额</span>
            <span class="ui-list-title w50 fn-left">手续费</span>
            <span class="ui-list-title w100 fn-left">银行</span>
            <span class="ui-list-title w80 fn-left">支行</span>
            <span class="ui-list-title w120 fn-left">卡号</span>
            <span class="ui-list-title w80 fn-left">所在地</span>
            <span class="ui-list-title w80 fn-left">申请日期</span>
            <span class="ui-list-title w80 fn-left last">转账日期</span>
          </li>
          <li class="ui-list-item fn-clear dark">
            <span class="ui-list-field w50 ph10 fn-left"><a>习近平</a></span>
            <span class="ui-list-field w80 fn-left text-right">20,000元</span>
            <span class="ui-list-field w50 fn-left text-right">50元</span>
            <span class="ui-list-field w100 fn-left text-center">中国银行</span>
            <span class="ui-list-field w80 two-line fn-left">中国银行麓谷支行</span>
            <span class="ui-list-field w120 fn-left num-s">4563517512312312312</span>
            <span class="ui-list-field w80 two-line fn-left">湖南长沙岳麓区</span>
            <span class="ui-list-field w80 fn-left">2014-04-08</span>
            <span class="ui-list-field w80 fn-left">2014-04-08</span>
          </li>
          <!--li class="ui-list-status">
            <p class="color-gray-text">没有记录</p>
          </li-->
          </ul>
        <div class="fn-right mt10" id="repaid-list-pagination">
          

        </div>
      </div>
    </div>
  </div>
</div>