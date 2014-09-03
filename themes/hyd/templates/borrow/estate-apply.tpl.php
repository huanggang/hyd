<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/loan.css');

drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/facing.js');
drupal_add_js($theme_path . '/js/borrow_estate.js');
drupal_add_js($theme_path . '/js/borrow_validate.js');

drupal_add_css($theme_path . '/css/iconfont.css');
drupal_add_library('system', 'ui.dialog');
drupal_add_css($theme_path . '/css/dialog.css');

drupal_add_js('var uid=' . strval($user->uid), 'inline');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <form class="ui-form" method="post" id="borrowForm">
          <fieldset>
            <div class="loanboder">
            <legend>房产抵押借款申请</legend>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>借款标题</label>
              <input class="ui-input w300" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>房产坐落</label>
              <input class="ui-input w300" type="text" value="" name="address" id="address">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>建筑面积</label>
              <input class="ui-input w80" type="text" value="" name="area" id="area"> 平米
            </div>
            <div class="ui-form-item">
              <label class="ui-label">楼层</label>
              <input class="ui-input w40" type="text" value="" name="floor" id="floor"> 层, 共
              <input class="ui-input w40" type="text" value="" name="height" id="height"> 层
            </div>
            <div class="ui-form-item">
              <label class="ui-label">朝向</label>
              <select name="facing" id="facing">
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>建成年份</label>
              <input class="ui-input w40" type="text" value="" name="year" id="year"> 年
            </div>
            <div class="ui-form-item">
              <label class="ui-label">实际用途</label>
              <input class="ui-input w300" type="text" value="" name="usage" id="usage">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">银行贷款</label>
              <input type="radio" class="has_loan" name="has_loan" value="0">无
              <input type="radio" class="has_loan" name="has_loan" value="1">有
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>房产证</label>
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