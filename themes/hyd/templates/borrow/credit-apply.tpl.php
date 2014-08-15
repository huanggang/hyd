<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/loan.css');

drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/borrow_credit.js');
drupal_add_js($theme_path . '/js/borrow_validate.js');

drupal_add_js('var uid=' . strval($user->uid), 'inline');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <form class="ui-form" method="post" id="borrowForm">
          <fieldset>
            <div class="loanboder">
            <legend>信用贷款借款申请</legend>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>借款标题</label>
              <input class="ui-input w300" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label required"><span class="ui-form-required">*</span>现工作单位</label>
              <input class="ui-input w300" type="text" value="" name="organization" id="organization">
            </div>
            <div class="ui-form-item">
              <label class="ui-label required"><span class="ui-form-required">*</span>当前职务</label>
              <input class="ui-input w300" type="text" value="" name="position" id="position">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>现单位工龄</label>
              <input class="ui-input w40" type="text" value="" name="years" id="years"> 年
              <input class="ui-input w40" type="text" value="" name="months" id="months"> 个月
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>平均月收入</label>
              <input class="ui-input w80" type="text" value="" name="income" id="income"> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>工作凭证</label>
              <input type="radio" class="certificate" name="certificate" value="0">无
              <input type="radio" class="certificate" name="certificate" value="1">有
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>计划用款</label>
              <input class="ui-input w80" type="text" value="" name="amount" id="amount"> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>计划用款时间</label>
              <input class="ui-input w40" type="text" value="" name="duration" id="duration"> 个月
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>借款详情</label>
              <textarea class="ui-textarea" name="purpose" id="purpose" rows="6"></textarea>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>信用说明</label>
              <textarea class="ui-textarea" name="asset_description" id="asset_description" rows="6"></textarea>
            </div>
            </div>
            <div class="ui-form-item">
              <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="立即申请" id="apply">
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>