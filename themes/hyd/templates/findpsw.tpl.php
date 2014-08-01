<?php
drupal_add_css(drupal_get_path('theme','hyd') . '/css/findpwd.css');
?>
<div id="pg-findPsw">
  <div class="container_12 mt20">
    <div class="grid_12">
      <div class="content color-white-bg p20bs">
        <div class="type">
          <!--a data-href="findPswByEmail" class="ui-button ui-button-mid ui-button-blue switch">使用绑定邮箱找回密码</a-->
          <a data-href="findPswByMobile" class="ui-button ui-button-mid ui-button-green switch">使用绑定手机号找回密码</a>
        </div>
        <div id="findPswByEmail" class="hidebox fn-hide" style="display: block;">
          <form data-name="notLoginFindPswByEmail" class="ui-form" method="post" id="notLoginFindPswByEmailForm" action="/findPwd!findByMailDo.action" novalidate="novalidate">
            <div class="inputs">
              <div class="ui-form-item">
                <label class="ui-label"><span class="ui-form-required">*</span>手机号码</label>
                <input class="ui-input" type="text" data-is="isEmail" name="email" id="email" value="">
              </div>
              <div class="ui-form-item">
                <label class="ui-label"><span class="ui-form-required">*</span>验证码</label>
                <input type="text" class="ui-input code" name="randCode" value="">
                <a href="javascript:void(0)"><img class="randImage" border="0" align="absmiddle" src="/image_https.jsp" alt="验证码"></a>
              </div>
              <div class="ui-form-item">
                <input type="submit" value="提 交" id="subNotLoginFindPswByEmailBt" class="ui-button ui-button-mid ui-button-green">
              </div>  
            </div>
          </form>
        </div>    
        <div id="findPswByMobile" class="hidebox fn-hide" style="display: none;">
          <form data-name="notLoginFindPswByMobile" class="ui-form" method="post" id="notLoginFindPswByMobileForm" action="/findPwd!findByMobileDo.action" novalidate="novalidate">
            <div class="inputs">
              <div class="ui-form-item">
                <label class="ui-label"><span class="ui-form-required">*</span>手机号</label>
                <input class="ui-input" type="text" name="mobile" id="mobile" data-is="isMobile" value="">
              </div>
              <div class="ui-form-item">
                <label class="ui-label"><span class="ui-form-required">*</span>验证码</label>
                <input type="text" class="ui-input code" name="randCode" value="">
                <a href="javascript:void(0)"><img class="randImage" border="0" align="absmiddle" src="/image_https.jsp" alt="验证码"></a>
              </div>
              <div class="ui-form-item">
                <input type="hidden" name="checkCode" value="other">
                <input type="submit" value="提 交" id="subNotLoginFindPswByMobileFormBt" class="ui-button ui-button-mid ui-button-green">
              </div>  
            </div>
          </form>
        </div>  
        <p class="info">若您无法使用上述方法找回，请联系客服400-027-XXXX</p>
      </div>
    </div>
  </div>
</div>