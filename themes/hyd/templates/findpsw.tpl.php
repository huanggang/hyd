<?php
$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/findpwd.css');

drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/valid_methods.js');
drupal_add_js($theme_path . '/js/messages.js');
drupal_add_js($theme_path . '/js/findpwd.js');
?>
<div id="pg-findPsw">
  <div class="container_12 mt20">
    <div class="grid_12">
      <div class="content color-white-bg p20bs" id="findPswByMobile">
          <div class="ui-form inputs">
            <div class="ui-form-item">
              <legend>用绑定手机找回密码</legend>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>手机号</label>
              <input class="ui-input" type="text" name="phone" id="phone" value="">
              <input type="button" id="getMobileCode" class="ui-button ui-button-green ui-button-small" value="获取验证码" />
            </div>
            <div class="ui-form-item fn-hide vcode">
              <label class="ui-label"><span class="ui-form-required">*</span>验证码</label>
              <input type="text" class="ui-input code" id="validateCode" name="validateCode" value="">
            </div>
            <div class="ui-form-item fn-hide vcode">
              <input type="hidden" name="checkCode" value="other">
              <input type="submit" value="提 交" id="subNotLoginFindPswByMobileFormBt" class="ui-button ui-button-mid ui-button-green">
            </div>
          </div>
        <p class="info">若您无法使用上述方法找回，请联系客服<?php print variable_get('easyloan_service_tel_number');?></p>
    </div>
  </div>
</div>