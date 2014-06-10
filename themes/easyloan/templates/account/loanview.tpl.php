<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/loan.css');

drupal_add_js($theme_path . '/js/repayment_methods.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/loan_view.js');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <div class="loanboder">
          <legend><span id="category"></span>抵押借款</legend>
          <div class="ui-form-item">
            <label class="ui-label">借款标题</label>
            <span id="title"></span>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">借款金额</label>
            <span id="amount"></span> 元
          </div>
          <div class="ui-form-item">
            <label class="ui-label">借款利息</label>
            <span id="interest"></span> 元
          </div>
          <div class="ui-form-item">
            <label class="ui-label">年利率</label>
            <span id="rate"></span> %
          </div>
          <div class="ui-form-item">
            <label class="ui-label">还款方式</label>
            <span id="method"></span>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">逾期日利率</label>
            <span id="fine_rate"></span> %
          </div>
          <div class="ui-form-item">
            <label class="ui-label">逾期日利率计算方式</label>
            <span id="fine_is_single"></span>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">总罚金/已还罚金</label>
            <span id="fine"></span> 元
          </div>
          <div class="ui-form-item">
            <label class="ui-label">借款期限</label>
            <span id="duration"></span> 月
          </div>
          <div class="ui-form-item">
            <label class="ui-label">借款日期</label>
            <span id="start"></span>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">到期日期</label>
            <span id="end"></span>
          </div>
          <div class="ui-form-item" id="finished-div" style="display:none">
            <label class="ui-label">还清日期</label>
            <span id="finished"></span>
          </div>
          <div id="wait-div" style="display:none">
            <div class="ui-form-item">
              <label class="ui-label">待还本金</label>
              <span id="w_amount"></span> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">待还利息</label>
              <span id="w_interest"></span> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">尚欠本息</label>
              <span id="w_owned"></span> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">尚欠罚金</label>
              <span id="w_fine"></span> 元
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>