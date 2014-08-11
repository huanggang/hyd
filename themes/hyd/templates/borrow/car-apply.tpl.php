<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/loan.css');

drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/vehicle_features.js');
drupal_add_js($theme_path . '/js/vehicle_status.js');
drupal_add_js($theme_path . '/js/borrow_car.js');
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
            <legend>机动车抵押借款申请</legend>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>借款标题</label>
              <input class="ui-input w300" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>机动车品牌</label>
              <input class="ui-input w300" type="text" value="" name="brand" id="brand">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>生产年份</label>
              <input class="ui-input w40" type="text" value="" name="year" id="year"> 年
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>车辆识别代码(车架号/VIN)</label>
              <input class="ui-input w300" type="text" value="" name="vin" id="vin">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">出厂日期</label>
              <input class="ui-input w80" type="text" value="" name="made" id="made"> (例如: 2007/03/26)
            </div>
            <div class="ui-form-item">
              <label class="ui-label">违章情况</label>
              <input class="ui-input w40" type="text" value="" name="violations" id="violations"> 次
            </div>
            <div class="ui-form-item">
              <label class="ui-label">登记日期</label>
              <input class="ui-input w80" type="text" value="" name="register" id="register"> (例如: 2007/03/26)
            </div>
            <div class="ui-form-item">
              <label class="ui-label">购车发票价格</label>
              <input class="ui-input w80" type="text" value="" name="price" id="price"> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">颜色</label>
              <input class="ui-input w80" type="text" value="" name="color" id="color">
            </div>
            <div class="ui-form-item" id="features">
              <label class="ui-label">车辆配置</label>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>行车里程</label>
              <input class="ui-input w80" type="text" value="" name="mileage" id="mileage"> 公里
            </div>
            <div class="ui-form-item">
              <label class="ui-label">过户次数</label>
              <input class="ui-input w40" type="text" value="" name="tranfers" id="tranfers"> 次
            </div>
            <div class="ui-form-item">
              <label class="ui-label">国产/进口</label>
              <input type="radio" class="oversea" name="oversea" value="0">国产
              <input type="radio" class="oversea" name="oversea" value="1">进口
            </div>
            <div class="ui-form-item">
              <label class="ui-label">车况</label>
              <select name="status" id="status">
              </select>
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