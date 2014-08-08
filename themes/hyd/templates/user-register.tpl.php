<?php

$theme_path = drupal_get_path('theme','hyd');

drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/jquery.steps.min.js');
drupal_add_js($theme_path . '/js/valid_methods.js');
drupal_add_css($theme_path . '/css/reg.css');
drupal_add_js($theme_path . '/js/reg.js');

global $base_url;
if (isset($form['captcha'])) { 
  $form['captcha']['#theme_wrappers']                                       = NULL; 
  $form['captcha']['captcha_widgets']['captcha_response']['#title']         ='';
  $form['captcha']['captcha_widgets']['captcha_response']['#weight']        =-10; // for style 
  $form['captcha']['captcha_widgets']['captcha_response']['#description']   =''; 
  $form['captcha']['captcha_widgets']['captcha_response']['#required']      =false;
  $form['captcha']['captcha_widgets']['captcha_refresh']['#theme_wrappers'] =NULL;
  $form['captcha']['captcha_widgets']['captcha_response']['#attributes']['class']=array('ui-input','input-icon','code');  
}

?>
<div id="pg-reg" class="container_12"> 
  <div class="p20bs color-white-bg regbox"> 
    <div class="ui-form" id="reg"> 
      <fieldset>
        <input id="edit-user-register-timezone" name="timezone" value="28800" type="hidden">
        <?php 
          print $theme_path;
          print 'test';
          print drupal_render($form['form_build_id']);
          print drupal_render($form['form_id']);
          print drupal_render($form['account']['timezone']); 
          //if(empty($form['vcode'])){
        ?>
        <div class="ui-form-item">
          <h3>注册</h3>
        </div>
        <div class="ui-form-item">
          <label class="ui-label">昵称</label>
          <input type="text" name="name" id="edit-name" value="<?php print $form['account']['name']['#value'];?>" class="ui-input input-icon form-text required">
          <span class="icon input-icon-user"></span>
        </div>
        <!--div class="ui-form-item">
          <label class="ui-label">手机号</label>
          <input type="text" name="phone" id="edit-phone" value="<?php //print $form['account']['phone']['#value'];?>" class="ui-input input-icon form-text isMobile">
          <span class="icon input-icon-mobile"></span>
        </div-->
        <div class="ui-form-item">
          <label class="ui-label">密码</label>
          <input class="ui-input input-icon" type="password" name="pass[pass1]" id="edit-pass-pass1">
          <span class="icon input-icon-key"></span>
        </div>

        <div class="ui-form-item">
          <label class="ui-label">重复密码</label>
          <input class="ui-input input-icon" type="password" name="pass[pass2]" id="edit-pass-pass2">
          <span class="icon input-icon-key"></span>
        </div>
        <?php 
          if(isset($form['captcha'])&&isset($form['captcha']['#captcha_type'])){
            print drupal_render($form['captcha']['captcha_sid']);
            print drupal_render($form['captcha']['captcha_token']);
        ?>
        <div class="ui-form-item">
          <label class="ui-label">验证码</label>
          <?php print drupal_render($form['captcha']); ?>
          <span class="icon input-icon-lock"></span>
        </div>
        <?php } ?>
        <?php print drupal_render($form['pre']); ?>
        <div class="ui-form-item ui-form-item-check">
          <input type="checkbox" class="form-checkbox" value="0" name="agree" id="edit-agree"><span class="fn-left">我已阅读并同意</span>
          <a href="<?php print $base_url . '/' . $theme_path; ?>/agreement.html" target="_blank">《好易贷网站服务协议》</a>
        </div>
        <div class="ui-form-item">
          <input type="submit" name="submit" class="ui-button ui-button-mid ui-button-blue" value="注册" />
        </div>

      </fieldset>
    </div>
  </div>
</div>
