<?php
/**
 * @file
 * Returns the HTML for the footer region.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728140
 */
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
    <ul class="ui-list ui-list-m ui-list-invest" id="loan-list">
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
      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w250 pl15 pr20">
          <a class="fn-left w250 rrd-dimgray fn-text-overflow" href="/invest/10001" target="_blank" title="资金周转">(房产) 资金周转资金周转资金周转资金周转资金周转资金周转资金周转资金周转</a>
        </span>
        <span class="ui-list-field fn-left num text-right w60 pr20"><em class="value">11.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w100 pr20"><em class="value">20,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr20"><em class="value">12</em>个月</span>
        <span class="ui-list-field fn-left w80 pr20">2014-01-01</span>
        <span class="ui-list-field fn-left w80 pr20">2015-01-01</span>
        <span class="ui-list-field fn-left w70 pr20">
          <strong class="ui-progressbar-mid ui-progressbar-mid-20"><em>20</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-OPEN">
            <span class="OPEN">投&nbsp;&nbsp;&nbsp;&nbsp;标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
            <span class="OVER_DUE">逾期中</span>
            <span class="CLOSED">已结束</span>
          </a>
        </span>
      </li>

      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w250 pl15 pr20">
          <a class="fn-left w250 rrd-dimgray fn-text-overflow" href="/invest/10001" target="_blank" title="以房养老，周游世界">(房产) 以房养老，周游世界，周游世界</a>
        </span>
        <span class="ui-list-field fn-left num text-right w60 pr20"><em class="value">8.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w100 pr20"><em class="value">500,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr20"><em class="value">6</em>个月</span>
        <span class="ui-list-field fn-left w80 pr20">2014-01-01</span>
        <span class="ui-list-field fn-left w80 pr20">2014-06-01</span>
        <span class="ui-list-field fn-left w70 pr20">
          <strong class="ui-progressbar-mid ui-progressbar-mid-100"><em>100</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-FIRST_READY">
            <span class="OPEN">投&nbsp;&nbsp;&nbsp;&nbsp;标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
            <span class="OVER_DUE">逾期中</span>
            <span class="CLOSED">已结束</span>
          </a>
        </span>
      </li>
      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w250 pl15 pr20">
          <a class="fn-left w250 rrd-dimgray fn-text-overflow" href="/invest/10001" target="_blank" title="资金周转">(房产) 资金周转</a>
        </span>
        <span class="ui-list-field fn-left num text-right w60 pr20"><em class="value">18.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w100 pr20"><em class="value">2,500,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr20"><em class="value">3</em>个月</span>
        <span class="ui-list-field fn-left w80 pr20">2014-01-01</span>
        <span class="ui-list-field fn-left w80 pr20">2014-03-01</span>
        <span class="ui-list-field fn-left w70 pr20">
          <strong class="ui-progressbar-mid ui-progressbar-mid-100"><em>100</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-IN_PROGRESS">
            <span class="OPEN">投&nbsp;&nbsp;&nbsp;&nbsp;标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
            <span class="OVER_DUE">逾期中</span>
            <span class="CLOSED">已结束</span>
          </a>
        </span>
      </li>
      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w250 pl15 pr20">
          <a class="fn-left w250 rrd-dimgray fn-text-overflow" href="/invest/10001" target="_blank" title="借钱供子女出国留学">(房产) 借钱供子女出国留学</a>
        </span>
        <span class="ui-list-field fn-left num text-right w60 pr20"><em class="value">12.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w100 pr20"><em class="value">750,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr20"><em class="value">36</em>个月</span>
        <span class="ui-list-field fn-left w80 pr20">2014-01-01</span>
        <span class="ui-list-field fn-left w80 pr20">2017-01-01</span>
        <span class="ui-list-field fn-left w70 pr20">
          <strong class="ui-progressbar-mid ui-progressbar-mid-100"><em>100</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-OVER_DUE">
            <span class="OPEN">投&nbsp;&nbsp;&nbsp;&nbsp;标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
            <span class="OVER_DUE">逾期中</span>
            <span class="CLOSED">已结束</span>
          </a>
        </span>
      </li>

      <li class="ui-list-more">
        <a class="darkgray" href="invest" target="_blank">查看更多投资理财项目</a>
      </li>
    </ul>
  </div>
</div>