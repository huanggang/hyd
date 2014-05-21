<?php
/**
 * @file
 * Returns the HTML for the footer region.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728140
 */
global $base_url;
?>
<!-- Invest List -->
<div class="loan mb fn-clear">
  <div class="grid_12">
    <div class="list-title loan">
      <span class="on">投资列表</span>
    </div>
    <ul class="ui-list ui-list-m ui-list-invest" id="loan-list">
      <li class="ui-list-header fn-clear" id="loan-list-header">
        <span class="ui-list-title fn-left color-gray-text w220">借款标题</span>
        <span class="ui-list-title fn-left color-gray-text w80">抵押类型</span>
        <span class="ui-list-title fn-left color-gray-text w110">还款方式</span>
        <span class="ui-list-title fn-left color-gray-text text-center w80">年利率</span>
        <span class="ui-list-title fn-left color-gray-text text-center w100">金额</span>
        <span class="ui-list-title fn-left color-gray-text text-center w80">期限</span>
        <span class="ui-list-title fn-left color-gray-text text-center w90">成立日</span>
        <span class="ui-list-title fn-left color-gray-text text-center w80">进度</span>
        <span class="ui-list-title fn-left color-gray-text text-center w90">投标</span>
      </li>
      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w200 pr20">
          <a class="fn-left w80 rrd-dimgray fn-text-overflow" href="./lend/10001" target="_blank" title="资金周转">资金周转</a>
        </span>
        <span class="ui-list-field fn-left w80">房产商铺</span>
        <span class="ui-list-field fn-left w110">一次性还本付息</span>
        <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr30"><em class="value">12</em>个月</span>
        <span class="ui-list-field fn-left w90">2014-01-01</span>
        <span class="ui-list-field fn-left w80">
          <strong class="ui-progressbar-mid ui-progressbar-mid-100"><em>100</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-IN_PROGRESS">
            <span class="OPEN">投标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
          </a>
        </span>
      </li>

      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w200 pr20">
          <a class="fn-left w200 rrd-dimgray fn-text-overflow" href="./lend/10001" target="_blank" title="以房养老，周游世界">以房养老，周游世界，周游世界</a>
        </span>
        <span class="ui-list-field fn-left w80">房产商铺</span>
        <span class="ui-list-field fn-left w110">一次性还本付息</span>
        <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr30"><em class="value">12</em>个月</span>
        <span class="ui-list-field fn-left w90">2014-01-01</span>
        <span class="ui-list-field fn-left w80">
          <strong class="ui-progressbar-mid ui-progressbar-mid-100"><em>23</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-OPEN">
            <span class="OPEN">投标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
          </a>
        </span>
      </li>
      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w200 pr20">
          <a class="fn-left w200 rrd-dimgray fn-text-overflow" href="./lend/10001" target="_blank" title="借钱供子女出国留学">借钱供子女出国留学</a>
        </span>
        <span class="ui-list-field fn-left w80">房产商铺</span>
        <span class="ui-list-field fn-left w110">一次性还本付息</span>
        <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr30"><em class="value">12</em>个月</span>
        <span class="ui-list-field fn-left w90">2014-01-01</span>
        <span class="ui-list-field fn-left w80">
          <strong class="ui-progressbar-mid ui-progressbar-mid-100"><em>100</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-FIRST_READY">
            <span class="OPEN">投标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
          </a>
        </span>
      </li>
      <li class="ui-list-item fn-clear ">
        <span class="ui-list-field fn-left text-big w200 pr20">
          <a class="fn-left w80 rrd-dimgray fn-text-overflow" href="./lend/10001" target="_blank" title="资金周转">资金周转</a>
        </span>
        <span class="ui-list-field fn-left w80">房产商铺</span>
        <span class="ui-list-field fn-left w110">一次性还本付息</span>
        <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
        <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
        <span class="ui-list-field fn-left num text-right w50 pr30"><em class="value">12</em>个月</span>
        <span class="ui-list-field fn-left w90">2014-01-01</span>
        <span class="ui-list-field fn-left w80">
          <strong class="ui-progressbar-mid ui-progressbar-mid-100"><em>100</em>%</strong>
        </span>
        <span class="ui-list-field fn-left w90">
          <a class="ui-button ui-button-mid ui-button-blue ui-list-invest-button ui-list-invest-button-IN_PROGRESS">
            <span class="OPEN">投标</span>
            <span class="READY FIRST_READY">已满标</span>
            <span class="IN_PROGRESS">还款中</span>
          </a>
        </span>
      </li>

      <li class="ui-list-more">
        <a class="darkgray" href="lend" target="_blank">查看更多投资理财项目</a>
      </li>
    </ul>
  </div>
</div>