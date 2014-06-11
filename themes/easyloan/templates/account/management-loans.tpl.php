<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/loans.js');
?>
<div class="color-white-bg">
  <div class="ui-tab ui-tab-transparent">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="notyet">
        <a class="ui-tab-item-link">未放款</a>
      </li>
      <li class="ui-tab-item" data-name="lending">
        <a class="ui-tab-item-link">还款中</a>
      </li>
      <li class="ui-tab-item" data-name="finished">
        <a class="ui-tab-item-link">已结束</a>
      </li>
    </ul>
  </div>
  <div class="p20bs color-white-bg">
    <div class="ui-tab-content ui-tab-content-current fn-clear" data-name="notyet">
      <ul class="ui-list ui-list-s mt10" id="loan-list-1">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w120 ph10 fn-left title">借款标题</span>
          <span class="ui-list-title w80 fn-left">借款人</span>
          <span class="ui-list-title w80 fn-left">抵押类型</span>
          <span class="ui-list-title w100 fn-left text-right">计划用款</span>
          <span class="ui-list-title w100 fn-left">计划用款时间</span>
          <span class="ui-list-title w100 fn-left">申请日期</span>
          <span class="ui-list-title w100 fn-left last">审定放款</span>
        </li>
        <li class="ui-list-item fn-clear dark">
          <span class="ui-list-field w120 ph10 fn-left"><a>借钱结婚</a></span>
          <span class="ui-list-field w80 fn-left"><a>习近平1</a></span>
          <span class="ui-list-field w80 fn-left">房屋商铺</span>
          <span class="ui-list-field w100 fn-left text-right">10，000元</span>
          <span class="ui-list-field w100 fn-left text-center">2014-08-08</span>
          <span class="ui-list-field w100 fn-left text-center">2014-04-08</span>
          <span class="ui-list-field w100 fn-left text-center last">
            <a href="loans/123456" target="_blank" class="ui-button ui-button-small ui-button-blue">审定放款</a>
          </span>
        </li>
        <li class="ui-list-item fn-clear">
          <span class="ui-list-field w120 ph10 fn-left"><a>借钱炒房</a></span>
          <span class="ui-list-field w80 fn-left"><a>李克强</a></span>
          <span class="ui-list-field w80 fn-left">机动车抵押</span>
          <span class="ui-list-field w100 fn-left text-right">500，000元</span>
          <span class="ui-list-field w100 fn-left text-center">2014-08-08</span>
          <span class="ui-list-field w100 fn-left text-center">2014-04-08</span>
          <span class="ui-list-field w100 fn-left text-center last">
            <a href="loans/123457" target="_blank" class="ui-button ui-button-small ui-button-blue">审定放款</a>
          </span>
        </li>
      </ul>
      <div class="fn-left mt10" id="loan-total-1"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="loan-list-pagination-1">
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
    <div class="ui-tab-content fn-clear" data-name="lending">
      <ul class="ui-list ui-list-s mt10" id="loan-list-2">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w120 ph10 fn-left title">借款标题</span>
          <span class="ui-list-title w80 fn-left">借款人</span>
          <span class="ui-list-title w80 fn-left">抵押类型</span>
          <span class="ui-list-title w100 fn-left text-right">计划用款</span>
          <span class="ui-list-title w100 fn-left">计划用款时间</span>
          <span class="ui-list-title w100 fn-left">申请日期</span>
          <span class="ui-list-title w100 fn-left last">审定放款</span>
        </li>
        <li class="ui-list-item fn-clear dark">
          <span class="ui-list-field w120 ph10 fn-left"><a>借钱结婚</a></span>
          <span class="ui-list-field w80 fn-left"><a>习近平</a></span>
          <span class="ui-list-field w80 fn-left">房屋商铺</span>
          <span class="ui-list-field w100 fn-left text-right">10，000元</span>
          <span class="ui-list-field w100 fn-left text-center">2014-08-08</span>
          <span class="ui-list-field w100 fn-left text-center">2014-04-08</span>
          <span class="ui-list-field w100 fn-left text-center last">
            <a href="loans/123456" target="_blank" class="ui-button ui-button-small ui-button-blue">审定放款</a>
          </span>
        </li>
        <li class="ui-list-item fn-clear">
          <span class="ui-list-field w120 ph10 fn-left"><a>借钱炒房</a></span>
          <span class="ui-list-field w80 fn-left"><a>李克强2</a></span>
          <span class="ui-list-field w80 fn-left">机动车抵押</span>
          <span class="ui-list-field w100 fn-left text-right">500，000元</span>
          <span class="ui-list-field w100 fn-left text-center">2014-08-08</span>
          <span class="ui-list-field w100 fn-left text-center">2014-04-08</span>
          <span class="ui-list-field w100 fn-left text-center last">
            <a href="loans/123457" target="_blank" class="ui-button ui-button-small ui-button-blue">审定放款</a>
          </span>
        </li>
      </ul>
      <div class="fn-left mt10" id="loan-total-2"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="loan-list-pagination-2">
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
    <div class="ui-tab-content fn-clear" data-name="finished">
      <ul class="ui-list ui-list-s mt10" id="loan-list-3">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w120 ph10 fn-left title">借款标题</span>
          <span class="ui-list-title w80 fn-left">借款人</span>
          <span class="ui-list-title w80 fn-left">抵押类型</span>
          <span class="ui-list-title w100 fn-left text-right">计划用款</span>
          <span class="ui-list-title w100 fn-left">计划用款时间</span>
          <span class="ui-list-title w100 fn-left">申请日期</span>
          <span class="ui-list-title w100 fn-left last">审定放款</span>
        </li>
        <li class="ui-list-item fn-clear dark">
          <span class="ui-list-field w120 ph10 fn-left"><a>借钱结婚</a></span>
          <span class="ui-list-field w80 fn-left"><a>习近平3</a></span>
          <span class="ui-list-field w80 fn-left">房屋商铺</span>
          <span class="ui-list-field w100 fn-left text-right">10，000元</span>
          <span class="ui-list-field w100 fn-left text-center">2014-08-08</span>
          <span class="ui-list-field w100 fn-left text-center">2014-04-08</span>
          <span class="ui-list-field w100 fn-left text-center last">
            <a href="loans/123456" target="_blank" class="ui-button ui-button-small ui-button-blue">审定放款</a>
          </span>
        </li>
        <li class="ui-list-item fn-clear">
          <span class="ui-list-field w120 ph10 fn-left"><a>借钱炒房</a></span>
          <span class="ui-list-field w80 fn-left"><a>李克强</a></span>
          <span class="ui-list-field w80 fn-left">机动车抵押</span>
          <span class="ui-list-field w100 fn-left text-right">500，000元</span>
          <span class="ui-list-field w100 fn-left text-center">2014-08-08</span>
          <span class="ui-list-field w100 fn-left text-center">2014-04-08</span>
          <span class="ui-list-field w100 fn-left text-center last">
            <a href="loans/123457" target="_blank" class="ui-button ui-button-small ui-button-blue">审定放款</a>
          </span>
        </li>
      </ul>
      <div class="fn-left mt10" id="loan-total-3"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="loan-list-pagination-3">
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
</div>