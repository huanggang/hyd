<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/list.css');

drupal_add_js($theme_path . '/js/duration_ranges.js');
drupal_add_js($theme_path . '/js/investment_status.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/list.js');
drupal_add_js($theme_path . '/js/investments_list.js');
?>
<div class="pg-invest-list" id="pg-loan-list">
  <div class="container_12 mt10">
    <div class="p20bs color-white-bg fn-clear">
      <div class="filter fn-left">

        <div class="ui-filter" id="loan-list-filter">
          <div class="fn-clear ui-filter-header mb10">
            <h4 class="fn-left color-outerspace-text">筛选理财项目</h4>
            <!--a class="fn-left ui-filter-switcher">多选</a-->
          </div>
          <ul>
            <li class="mt4"></li>
            <li class="mt4">
              <ul class="ui-filter-category category fn-clear" data-category="duration" id="duration_conditions">
                <li class="ui-filter-title color-gray-text">理财期限</li>
                <li class="ui-filter-tag rrdcolor-dimgray-text category-tag all active">
                  <input type="checkbox" name="duration" value="0" checked="checked">
                  <span>不限</span>
                </li>
              </ul>
            </li>
            <li class="mt4">
              <ul class="ui-filter-category category fn-clear" data-category="status" id="status_conditions">
                <li class="ui-filter-title color-gray-text">进度</li>
                <li class="ui-filter-tag rrdcolor-dimgray-text category-tag all active">
                  <input type="checkbox" name="status" value="0" checked="checked">
                  <span>不限</span>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      
      <!--div class="guide fn-left last">
        <div class="guide-box">
          <h4 class="mb10">新手引导</h4>
          <ul>
            <li><a class="guide-question rrd-dimgray" href="/help/borrow.action#what-is-credit-level" target="_blank">什么是信用等级？</a></li>
            <li><a class="guide-question rrd-dimgray" href="/help/invest.action#what-is-credit-loan" target="_blank">什么是信用认证标？</a></li>
            <li><a class="guide-question rrd-dimgray" href="/help/invest.action#what-is-youxin-loan" target="_blank">什么是实地认证标？</a></li>
            <li><a class="guide-question rrd-dimgray" href="/help/invest.action#what-is-organization-loan" target="_blank">什么是机构担保标？</a></li>
          </ul>
        </div>
      </div-->
    </div>
  </div>
  
  <div class="container_12 mt20 color-white-bg">
    <div class="p20bs w920 fn-clear">
      <div class="fn-clear mb20">
        <h3 class="fn-left mr10">投资列表</h3>

        <!--div class="fn-right">
          <div class="fn-clear">
            <dl class="fn-left w170 text-center">
              <dt>累计成交总金额</dt>
              <dd class="num"><em class="value mr10">23.00</em>亿元</dd>
            </dl>
            <dl class="fn-left w170 border-lt text-center">
              <dt>累计成交总笔数</dt>
              <dd class="num"><em class="value mr10">46011</em>笔</dd>
            </dl>
            <dl class="fn-left w170 border-lt text-center">
              <dt>为用户累计赚取</dt>
              <dd class="num"><em class="value mr10">11792.75</em>万元</dd>
            </dl>
          </div>
        </div-->

      </div>
      <ul class="ui-list ui-list-m ui-list-invest" id="investment-list">
        <li class="ui-list-header fn-clear">
          <span class="ui-list-title fn-left color-gray-text w230 pl15 pr20">借款标题</span>
          <span class="ui-list-title fn-left color-gray-text text-center w60 pr20">年利率</span>
          <span class="ui-list-title fn-left color-gray-text text-center w100 pr20">金额</span>
          <span class="ui-list-title fn-left color-gray-text text-center w50 pr20">期限</span>
          <span class="ui-list-title fn-left color-gray-text text-center w80 pr20">成立日</span>
          <span class="ui-list-title fn-left color-gray-text text-center w80 pr20">到期日</span>
          <span class="ui-list-title fn-left color-gray-text text-center w70 pr20">进度</span>
          <span class="ui-list-title fn-left color-gray-text text-center w90"></span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="investment-total">0</span>条</div>
      <div class="mt10 mb10 pagination-box ui-pagination simple-pagination" id="investment-list-pagination">
      </div>
    </div>
  </div>
</div>