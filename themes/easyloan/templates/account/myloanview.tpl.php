<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/loan.css');

drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/borrow_gold.js');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <form class="ui-form" method="post" id="borrowForm">
          <fieldset>
            <div class="loanboder">
            <legend>黄金抵押借款申请</legend>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>借款标题</label>
              <input class="ui-input w300" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>物品名称</label>
              <input class="ui-input w300" type="text" value="" name="name" id="name">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>重量</label>
              <input class="ui-input w80" type="text" value="" name="weight" id="weight"> 克
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>含量</label>
              <input class="ui-input w80" type="text" value="" name="purity" id="purity"> %
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>来源凭证</label>
              <input type="radio" class="certificate" name="certificate" value="0">无
              <input type="radio" class="certificate" name="certificate" value="1">有
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>计划用款</label>
              <input class="ui-input w80" type="text" value="" name="amount" id="amount"> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>计划用款时间</label>
              <input class="ui-input w40" type="text" value="" name="duration" id="duration"> 月
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>借款描述</label>
              <textarea class="ui-textarea" name="purpose" id="purpose" rows="6"></textarea>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>抵押资产说明</label>
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