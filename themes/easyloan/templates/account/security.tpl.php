<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $user;
?>
<div class="p20bs color-white-bg fn-clear" id="pg-account-security">
  <div class="title">安全信息</div>
  <ul class="security-ul mt20">
    <li>
      <div class="fn-clear">
        <div class="icon icon-nick"></div>
        <h3>昵称</h3>
        <p>已设置</p>
        <div class="update"><?php print $user->name;?></div>
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-id"></div>
        <h3>实名认证</h3>
        <p>44****************</p>
        <div class="update">朱**</div>
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-loginpsw"></div>
        <h3>登录密码</h3>
          <p>已设置</p>
        <div class="update">
          <a href="/account/resetPassword!toModify.action">修改</a>
        </div>
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-email"></div>
        <h3>绑定邮箱</h3>
        <p class="red">未设置</p>
        <div class="update"><a href="/account/bindRole.action?type=EMAIL">设置</a></div>
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-mobile"></div>
        <h3>绑定手机</h3>
        <p>158****6173</p>
        <div class="update"><a href="/account/bindMobile!goToModifyMobile.action">修改</a></div>
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-cashpsw"></div>
        <h3>提现密码</h3>
        <p>已设置</p>
        <div class="update">
          <a href="/account/cashPwd!toModify.action" id="modCashPswLink">修改</a> | <a href="/account/cashPwd!toFind.action" id="findCashPswLink">找回</a>
        </div>
      </div>
    </li>
  </ul>
</div>