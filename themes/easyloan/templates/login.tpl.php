<?php

/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
  drupal_add_css(drupal_get_path('theme','easyloan') . '/css/login.css');
  // var_dump($form['name']);
  // var_dump($form['pass']);
  // var_dump($form['form_build_id']);
  // var_dump($form['form_id']);
  // var_dump($form['actions']);

  global $base_url;
  $img_path = $base_url . '/' . drupal_get_path('theme','easyloan') . '/images/';
?>
  <div id="pg-login">
    <div class="container_12">
      <div class="grid_5 push_7">
        <div class="loanapp p20bs color-white-bg loginbox">
          <form name="form_id" data-name="login" class="ui-form" method="post" id="<?php print $form['form_id']['#value']?>" novalidate="novalidate">
            <fieldset>
              <legend>登录</legend>
              <div class="ui-form-item">
                <label class="ui-label">请输入手机号/邮箱</label>
                <input class="ui-input input-icon" type="text" id="<?php print $form['form_id']['#id']?>" name="name" value="" data-is="isMobileOrEmail">
                <p class="placeholder" style="display: none;">请输入手机号/邮箱</p>
                <span class="icon input-icon-user"></span>
              </div>
              <div class="ui-form-item">
                <label class="ui-label">密码</label>
                <input class="ui-input input-icon" type="password" name="pass" data-is="isEmail">
                <p class="placeholder" style="display: none;">请输入密码</p>
                <span class="icon input-icon-key"></span>
              </div>
              <div class="ui-form-item ui-form-item-check">
                <input name="rememberme" id="rememberme" type="checkbox" checked="checked">
                <label for="rememberme">记住账户</label>
                <input name="auto" id="auto" type="checkbox" checked="checked">
                <label for="auto">下次自动登录</label>
                <a class="findpsw" href="<?php print $GLOBALS['base_url'] .'/user/password';?>">忘记密码</a>
              </div>
              <div class="ui-form-item">
                <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="登录" name="op" id="edit-submit">
                使用
                <a href="http://www.renrendai.com/oauth/qq/login!beForeQQLogin.action?type=1">腾讯账号</a>
                <a href="https://api.weibo.com/oauth2/authorize?client_id=915664347&amp;redirect_uri=http%3A%2F%2Fwww.renrendai.com%2Foauth%2Fweibo%2Flogin.action&amp;forcelogin=true">新浪微博</a>
                账号登录
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
