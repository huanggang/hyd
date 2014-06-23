<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/list.css');

drupal_add_js(drupal_get_path('theme','easyloan') . '/js/list.js');
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
    <li class="mt4">
    </li>
    <li class="mt4">
      <ul class="ui-filter-category category fn-clear" data-category="term">
        <li class="ui-filter-title color-gray-text">
          理财期限
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag all active">
          <input type="checkbox" name="term" value="all" checked="checked">
          <span>不限</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="term" value="TERM_1_3">
          <span>1-3个月</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="term" value="TERM_4_9">
          <span>4-9个月</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="term" value="TERM_10_18">
          <span>10-18个月</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="term" value="TERM_19">
          <span>19个月以上</span>
        </li>
      </ul>
    </li>
    <li class="mt4">
      <ul class="ui-filter-category category fn-clear" data-category="creditLevel">
        <li class="ui-filter-title color-gray-text">
          进度
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag all active">
          <input type="checkbox" name="creditLevel" value="all" checked="checked">
          <span>不限</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="creditLevel" value="CREDITLEVEL_AA">
          <span>招标中</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="creditLevel" value="CREDITLEVEL_A">
          <span>已满标</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="creditLevel" value="CREDITLEVEL_B">
          <span>还款中</span>
        </li>
        <li class="ui-filter-tag rrdcolor-dimgray-text category-tag condition">
          <input type="checkbox" name="creditLevel" value="CREDITLEVEL_C">
          <span>结束</span>
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
        <div class="fn-right">
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
          
        </div>
      </div>
          <ul class="ui-list ui-list-m ui-list-invest" id="loan-list">
            <li class="ui-list-header fn-clear" id="loan-list-header">
              <span class="ui-list-title fn-left color-gray-text w220">借款标题</span>
              <span class="ui-list-title fn-left color-gray-text w80">抵押类型</span>
              <span class="ui-list-title fn-left color-gray-text w110">还款方式</span>
              <span class="ui-list-title fn-left color-gray-text text-center w80">年利率</span>
              <span class="ui-list-title fn-left color-gray-text text-center w100">金额</span>
              <span class="ui-list-title fn-left color-gray-text text-center w60">期限</span>
              <span class="ui-list-title fn-left color-gray-text text-center w90">成立日</span>
              <span class="ui-list-title fn-left color-gray-text text-center w80">进度</span>
              <span class="ui-list-title fn-left color-gray-text text-center w90">投标</span>
            </li>
            <li class="ui-list-item fn-clear ">
              <span class="ui-list-field fn-left text-big w200 pr20">
                <a class="fn-left w80 rrd-dimgray fn-text-overflow" href="./invest/10001" target="_blank" title="资金周转">资金周转</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w210 rrd-dimgray fn-text-overflow" href="#" target="_blank" title="以房养老，周游世界">以房养老，周游世界，周游世界</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w210 rrd-dimgray fn-text-overflow" href="#" target="_blank" title="借钱供子女出国留学">借钱供子女出国留学</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w80 rrd-dimgray fn-text-overflow" href="./invest/10001" target="_blank" title="资金周转">资金周转</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w210 rrd-dimgray fn-text-overflow" href="#" target="_blank" title="以房养老，周游世界">以房养老，周游世界，周游世界</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w210 rrd-dimgray fn-text-overflow" href="#" target="_blank" title="借钱供子女出国留学">借钱供子女出国留学</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w80 rrd-dimgray fn-text-overflow" href="./invest/10001" target="_blank" title="资金周转">资金周转</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w210 rrd-dimgray fn-text-overflow" href="#" target="_blank" title="以房养老，周游世界">以房养老，周游世界，周游世界</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
                <a class="fn-left w210 rrd-dimgray fn-text-overflow" href="#" target="_blank" title="借钱供子女出国留学">借钱供子女出国留学</a>
              </span>
              <span class="ui-list-field fn-left w80">房产商铺</span>
              <span class="ui-list-field fn-left w110">一次性还本付息</span>
              <span class="ui-list-field fn-left num text-right w70 pr10"><em class="value">11.00</em>%</span>
              <span class="ui-list-field fn-left num text-right w70 pr30"><em class="value">20,000</em>元</span>
              <span class="ui-list-field fn-left num text-right w50 pr10"><em class="value">12</em>个月</span>
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
</ul>
      <div class="mt10 mb10 pagination-box ui-pagination simple-pagination" id="loan-list-pagination">
        <ul>
          <li class="active"><span class="current prev">Prev</span></li>
          <li class="active"><span class="current">1</span></li>
          <li><a href="#page-2" class="page-link">2</a></li>
          <li><a href="#page-3" class="page-link">3</a></li>
          <li><a href="#page-4" class="page-link">4</a></li>
          <li><a href="#page-5" class="page-link">5</a></li>
          <li class="disabled"><span class="ellipse">…</span></li>
          <li><a href="#page-21" class="page-link">21</a></li>
          <li><a href="#page-22" class="page-link">22</a></li>
          <li><a href="#page-2" class="page-link next">Next</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>