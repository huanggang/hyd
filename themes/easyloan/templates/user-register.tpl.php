<?php
/**
 * @file
 * Returns the HTML for a the user-register form.
 *
 */
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/jquery.validate.min.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/jquery.steps.min.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/reg.js');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/reg.css');
//drupal_add_js(drupal_get_path('theme','easyloan') . '/js/counter.js');
//drupal_add_js(drupal_get_path('theme','easyloan') . '/js/regvcode.js');


$f = drupal_get_form('user_register_form'); // use this to retrieve the captcha 
if ($f['captcha']) { 
  $form['captcha'] = $f['captcha'];
  $form['captcha']['#theme_wrappers']                                       = NULL; 
  $form['captcha']['captcha_widgets']['captcha_response']['#title']         ='';
  $form['captcha']['captcha_widgets']['captcha_response']['#weight']        =-10; // for style 
  $form['captcha']['captcha_widgets']['captcha_response']['#description']   =''; 
  $form['captcha']['captcha_widgets']['captcha_response']['#required']      =false;
  $form['captcha']['captcha_widgets']['captcha_refresh']['#theme_wrappers'] =NULL;
  $form['captcha']['captcha_widgets']['captcha_response']['#attributes']['class']=array('ui-input','input-icon','code');  
}

?>
<div id="pg-reg">
  <div class="container_12"> 
    <div class="p20bs color-white-bg regbox"> 
      <div data-name="register" class="ui-form" id="reg"> 
        <h3>注册</h3>
        <section>
          <input id="edit-user-register-timezone" name="timezone" value="28800" type="hidden">
          <?php 
            print drupal_render($form['form_build_id']);
            print drupal_render($form['form_id']);
            print drupal_render($form['account']['timezone']); 
            if(empty($form['vcode'])){
          ?>
          <div class="ui-form-item">
            <label class="ui-label">昵称</label>
            <input type="text" name="name" id="edit-name" value="<?php print $form['account']['name']['#value'];?>" class="ui-input input-icon form-text required">
            <span class="icon input-icon-user"></span>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">手机号</label>
            <input type="text" name="phone" id="edit-phone" value="<?php print $form['account']['phone']['#value'];?>" class="ui-input input-icon form-text isMobile">
            <span class="icon input-icon-mobile"></span>
          </div>
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
            <input type="checkbox" class="form-checkbox" value="0" name="agree" id="edit-agree">我已阅读并同意
            <a href="/agreement/rv_webservice.html" target="_blank">《好易贷网站服务协议》</a>
          </div> 
          <!--div class="ui-form-item">
            <?php
              //print drupal_render($form['next']);
            ?> 
          </div-->
        </section>
        <h3>验证</h3>
        <section>
          <legend>短信已发送至您手机，请输入短信中的验证码，确保您的手机号真实有效</legend>
          <div class="ui-form-item">
            <label class="ui-label">手机号确认</label>
            <label class="input-icon form-text">
            <?php
              print variable_get('phone'); //$form['account']['phone']['#value'];
            ?>
            </label>
          </div>
          <div class="ui-form-item"> 
            <label class="ui-label">验证码</label> 
            <input type="text" value="" name="vcode" id="edit-vcode" class="ui-input input-icon form-text">
            <span class="icon input-icon-lock"></span> 
          </div> 
          <div class="ui-form-item"> 
            <?php 
              print drupal_render($form['prev']); 
              print drupal_render($form['finish']);
            ?>
          </div>
          <div class="ui-form-item">
          如果您在1分钟之内没有收到验证码，请退回<strong>上一步</strong>填写新号码<br /> 或 <span id="countdown"><span id="seconds">60</span>秒后</span><a id="resend">重新获取</a>
          </div>
          <?php } ?>
        </section>
      </div>
    </div>
  </div>
</div>