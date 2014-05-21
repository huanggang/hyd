<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/tab.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/tab.js');
?>
      <div class="fn-clear p20bs color-orange-bg">
          <div class="fn-left box-summary-left">
            <h3 class="text-xl">已还利息总额</h3>
            <p class="num color-orange-text"><em>25,998.00</em>元</p>
            <p class="text-small">
              <span class="pr5">平均年利率</span>
              <span class="num-s"><em>12.88</em>%</span>
            </p>
            <br />
            <h3 class="text-xl">待还本息</h3>
            <p class="num color-orange-text"><em>39,888.45</em>元</p>
          </div>
          <div class="fn-left box-summary-right mt20">
            <br />
            <div class="color-dimgray-text">
            <p class="em-box">您最近30天应还本息，总额 <em>5,700.98</em>元</p>
            <hr class="mt10">
            <p class="em-box mt10">下次还款日期 <em>2014-05-18</em>，应还本息 <em>5700.98</em>元</p>
            <br />
          </div>
          </div>
      </div>
      <div class="mt20">
        <div class="ui-tab ui-tab-transparent" id="repayments-tab">
          <ul class="ui-tab-items">
            <li class="ui-tab-item ui-tab-item-current" data-name="repaying">
              <a class="ui-tab-item-link">我的借款</a>
            </li>
            <li class="ui-tab-item" data-name="repaid">
              <a class="ui-tab-item-link">借款申请</a>
            </li>
          </ul>
        </div>
        <div class="p20bs color-white-bg">
          <div id="repayments-tab-content">
            <div class="ui-tab-content fn-clear ui-tab-content-current" data-name="repaying">
              <ul class="ui-list ui-list-s repaying" id="repaying-list">
                <li class="ui-list-header color-gray-text fn-clear">
                  <span class="ui-list-title w60 ph10 fn-left">借款标题</span>
                  <span class="ui-list-title w60 fn-left">抵押类型</span>
                  <span class="ui-list-title w60 fn-left">借款金额</span>
                  <span class="ui-list-title w60 fn-left">借款利息</span>
                  <span class="ui-list-title w60 fn-left">年利率</span>
                  <span class="ui-list-title w60 fn-left">还款方式</span>
                  <span class="ui-list-title w60 fn-left">借款期限</span>
                  <span class="ui-list-title w100 fn-left-amount">借款日期</span>
                  <span class="ui-list-title w100 fn-left">到期日期</span>
                  <span class="ui-list-title w60 fn-left">总罚金</span>
                  <span class="ui-list-title w60 fn-left">还清日期</span>
                </li>
              <li class="ui-list-status">
                <p class="color-gray-text">没有记录</p>
              </li>
              </ul>
              <div class="fn-right mt10" id="repaying-list-pagination"></div>
            </div>
            <div class="ui-tab-content fn-clear" data-name="repaid">
              <ul class="ui-list ui-list-s repaid" id="repaid-list">
                <li class="ui-list-header color-gray-text fn-clear">
                  <span class="ui-list-title w110 ph10 fn-left">借款标题</span>
                  <span class="ui-list-title w110 fn-left">抵押类型</span>
                  <span class="ui-list-title w110 fn-left">计划用款</span>
                  <span class="ui-list-title w110 fn-left">计划用款时间</span>
                  <span class="ui-list-title w70 fn-left">申请状态</span>
                  <span class="ui-list-title w120 fn-left">申请时间</span>
                </li>
                <li class="ui-list-status">
                  <p class="color-gray-text">没有记录</p>
                </li>
              </ul>
              <div class="fn-right mt10" id="repaid-list-pagination"></div>
            </div>
          </div>
        </div>
      </div>