<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/account.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/loan_categories.js');
drupal_add_js($theme_path . '/js/repayment_methods.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/investment_set.js');
?>
<div class="loanapp loanapp p20bs color-white-bg">
  <div class="loanboder">
    <h3 class="text-xl">发布投资项目&mdash;募集资金</h3>
    <div class="ui-form-item mt10">
      <label class="ui-label">借款标题</label>
      <span id="app_title"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">借款人</label>
      <span id="app_name"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">抵押类型</label>
      <span id="app_category"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">借款金额</label>
      <span id="app_amount"></span> 元
    </div>
    <div class="ui-form-item">
      <label class="ui-label">借款利息</label>
      <span id="app_interest"></span> 元
    </div>
    <div class="ui-form-item">
      <label class="ui-label">年利率</label>
      <span id="app_rate"></span> %
    </div>
    <div class="ui-form-item">
      <label class="ui-label">还款方式</label>
      <span id="app_method"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">借款时间</label>
      <span id="app_duration"></span> 个月
    </div>
    <div class="ui-form-item">
      <label class="ui-label">起始日期</label>
      <span id="app_start"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">到期日期</label>
      <span id="app_end"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">逾期日利率</label>
      <span id="app_fine_rate"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">逾期日利率计算方式</label>
      <span id="app_fine_is_single"></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">放款日期</label>
      <span id="app_created"></span>
    </div>
    <hr />
    <form class="ui-form" method="post" id="setForm">
      <fieldset>
        <div class="ui-form-item mt20">
          <label class="ui-label"><span class="ui-form-required">*</span>募集金额</label>
          <input class="ui-input" type="text" value="" name="amount" id="amount"> 元
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>年利率</label>
          <input class="ui-input" type="text" value="" name="rate" id="rate"> %
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>还款方式</label>
          <select name="method" id="method">
          </select>
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>投资起点金额</label>
          <input class="ui-input" type="text" value="" name="minimum" id="minimum"> 元
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>追加投资起点金额</label>
          <input class="ui-input" type="text" value="" name="step" id="step"> 元
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>成立日期</label>
          <input class="ui-input" type="text" value="" name="start" id="start"> (例如: 2007/03/26)
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>到期日期</label>
          <input class="ui-input" type="text" value="" name="end" id="end"> (例如: 2007/03/26)
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>逾期日利率</label>
          <input class="ui-input" type="text" value="" name="fine_rate" id="fine_rate"> %
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>逾期日利率计算方式</label>
          <input type="radio" class="fine_rate_is_single" name="fine_rate_is_single" value="-1" checked="checked">绝不逾期
          <input type="radio" class="fine_rate_is_single" name="fine_rate_is_single" value="1">单利
          <input type="radio" class="fine_rate_is_single" name="fine_rate_is_single" value="0">复利
        </div>
        <div class="ui-form-item">
          <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="发布" id="apply">
        </div>
      </fieldset>
    </form>
  </div>
</div>