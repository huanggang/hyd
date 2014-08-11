<?php

  global $base_url; 
  $img_path = $base_url . '/' . drupal_get_path('theme','hyd') . '/images/';
  
  if (isset($form['captcha'])) { 
    $form['captcha']['#theme_wrappers']                                             = NULL; 
    $form['captcha']['captcha_widgets']['captcha_response']['#title']               = ''; 
    $form['captcha']['captcha_widgets']['captcha_response']['#weight']              = -10; // for style 
    $form['captcha']['captcha_widgets']['captcha_response']['#description']         = ''; 
    $form['captcha']['captcha_widgets']['captcha_response']['#required']            = false; 
    $form['captcha']['captcha_widgets']['captcha_refresh']['#theme_wrappers']       = NULL; 
    $form['captcha']['captcha_widgets']['captcha_response']['#attributes']['class'] = array('ui-input','input-icon','code');  
  }
  
  drupal_add_css(drupal_get_path('theme','hyd') . '/css/login.css');
  drupal_add_js(drupal_get_path('theme','hyd') . '/js/jquery.validate.min.js');
  drupal_add_js(drupal_get_path('theme','hyd') . '/js/valid_methods.js');
  drupal_add_js(drupal_get_path('theme','hyd') . '/js/login.js');

  $errors = form_get_errors();
?>
  <div id="pg-login">
    <div class="container_12">
      <div class="grid_5 push_7">
        <div class="loanapp p20bs color-white-bg loginbox">
          <form name="form_id" data-name="login" class="ui-form" method="post" id="<?php print $form['form_id']['#value']?>">
            <fieldset>
              <legend>登录</legend>
              <div class="ui-form-item">
                <input class="ui-input input-icon" type="text" id="<?php print $form['form_id']['#id']?>" name="name" value="">
                <span class="icon input-icon-user"></span>
                <?php 
                  if (isset($errors['name'])){
                    $msg = '<label for="edit-user-login" class="error">';
                    if (strpos($errors['name'], 'temporarily blocked') > 1){
                      print $msg . '您登陆失败次数过多，请晚些再登录</label>';
                    } else {
                      print $msg. '用户名或密码不对，请核对后重试</label>';
                    }
                  }
                ?>
              </div>
              <div class="ui-form-item">
                <input class="ui-input input-icon" id="pass" type="password" name="pass" data-is="isEmail">
                <span class="icon input-icon-key"></span>
              </div>

              <?php 
                  print drupal_render($form['captcha']['captcha_sid']); 
                  print drupal_render($form['captcha']['captcha_token']); 

                  hide($form['captcha']['captcha_sid']);
                  hide($form['captcha']['captcha_token']);

                  $output = render($form['captcha']); 

                  if (!empty($output) && $output != '<div class="captcha"></div>'){
              ?> 
              <div class="ui-form-item">
                <?php print $output; ?>
                <span class="icon input-icon-lock"></span>
                <?php 
                  if (isset($errors['captcha_response'])){
                    $msg = '<label for="edit-user-login" class="error">';
                      print $msg . '请输入正确的验证码</label>';
                  } 
                ?> 
              </div> 
              <?php 
                  } 
              ?>

              <div class="ui-form-item ui-form-item-check">
                <!--input name="rememberme" id="rememberme" type="checkbox" checked="checked">
                <label for="rememberme">记住账户</label>
                <input name="auto" id="auto" type="checkbox" checked="checked">
                <label for="auto">下次自动登录</label-->
                <a class="findpsw" href="<?php print $GLOBALS['base_url'] .'/user/password';?>">忘记密码</a>
              </div>
              <div class="ui-form-item">
                <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="登录" name="submit" id="edit-submit">
                <!--
                使用
                <a href="http://www.renrendai.com/oauth/qq/login!beForeQQLogin.action?type=1">腾讯账号</a>
                <a href="https://api.weibo.com/oauth2/authorize?client_id=915664347&amp;redirect_uri=http%3A%2F%2Fwww.renrendai.com%2Foauth%2Fweibo%2Flogin.action&amp;forcelogin=true">新浪微博</a>
                账号登录
                -->
              </div>
              <?php 
                print drupal_render($form['form_build_id']);
                print drupal_render($form['form_id']);
              ?>
            </fieldset>
          </form>
        </div>
        </div>
        <div class="grid_7 pull_5">
          <div class="logininfo">
            <img src="<?php print $img_path; ?>logininfopic.jpg">
            <h1>优选理财计划</h1>
            <p>以投资好易贷平台现有信贷产品为基础的稳健，安全，流动性好的投资计划理财操作更轻松，收益处理更灵活</p>
          </div>
        </div>
      </div>
    </div>