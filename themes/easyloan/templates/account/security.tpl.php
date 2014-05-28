<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');

drupal_add_js(drupal_get_path('theme','easyloan') . '/js/jquery.validate.min.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/usersecurity.js');
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
        <p id="ssn" class='red'>未设置</p>
        <div class="update" id="name"><a id="setname">设置</a></div>

        <div id="pg-account-security-ssn" style="height:300px;clear:both;" class="fn-clear fn-hide">
          <div class="content setFormBox">  
          <form class="ui-form" method="post" id="setIdForm">
            <div class="inputs">
              <div class="ui-form-item">
                <label class="ui-label"><span class="ui-form-required">*</span>真实姓名</label>
                <input type="text" name="realName" id="realName" class="ui-input"/>
              </div>
              <div class="ui-form-item">
                <label class="ui-label"><span class="ui-form-required">*</span>身份证号</label>
                <input type="text" name="idNo" id="idNo" class="ui-input" />
              </div>
              <div class="ui-form-item">
                <input type="submit" id="subSetIdBt" value="提 交" class="ui-button ui-button-mid ui-button-green" />
              </div>  
            </div>
          </form>
          </div>
          <div class="fn-hide success">
            <h3 class="info">实名认证设置成功!</h3>
            <a class="ui-button ui-button-mid ui-button-blue backBt" >返回</a>
          </div>
        </div>  
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-loginpsw"></div>
        <h3>登录密码</h3>  
        <p>已设置</p> 
        <div class="update"><a id="setpass">修改</a></div>
        <div id="pg-account-security-pass" style="height:300px;clear:both;" class="fn-clear fn-hide">
          <div class="content">
            <p class="info">为了您的账户安全，请定期更换登录密码，并确保登录密码设置与提现密码不同。</p>
            <form data-name="modpsw" action="/account/resetPassword!doModify.action" class="ui-form" method="post" id="modPswForm" novalidate="novalidate">
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>原密码</label>
                  <input type="password" id="oldPassword" name="oldPassword" class="ui-input" placeholder="请输入原登录密码">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>新密码</label>
                  <input type="password" id="newPassword" name="newPassword" class="ui-input" placeholder="6-12位字母、数字和符号(不包括空格)" data-is="isPassWord">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>确认新密码</label>
                  <input type="password" id="newPassword2" name="newPassword2" class="ui-input" placeholder="请再次输入您的新密码" onpaste="return false">
                </div>
                <div class="ui-form-item">
                  <input type="submit" id="subModPswBt" value="提 交" class="ui-button ui-button-mid ui-button-green" />
                </div>  
              </div>
            </form>
          </div>  
          <div class="fn-hide success">
            <h3 class="info">登录密码重置成功!</h3>
            <a class="ui-button ui-button-mid ui-button-blue backBt">返回</a>
          </div>
        </div>
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-email"></div>
        <h3>绑定邮箱</h3>
        <p id="email" class='red'>未设置</p>
        <div class="update"><a id="setemail">设置</a></div>
        <div id="pg-account-security-email" style="height:200px;clear:both;" class="fn-clear fn-hide">
          <div>
            <div class="content setFormBox">
              <form data-name="setEmail" action="/account/bindRole!sendEmail.action" class="ui-form" method="post" id="setEmailForm" novalidate="novalidate">
                <div class="inputs">
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>邮箱</label>
                    <input type="text" name="email" class="ui-input" data-is="isEmail">
                  </div>
                  <div class="ui-form-item">
                    <input type="submit" id="subSetEmailBt" value="提 交" class="ui-button ui-button-mid ui-button-green">
                  </div>  
                </div>
              </form>
            </div>
            <div class="fn-hide success">
              <h3 class="info">验证信息已发往你的邮箱,请前往验证!</h3>
              <a class="ui-button ui-button-mid ui-button-blue backBt">返回</a>
            </div>
          </div>

        </div>
      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-mobile"></div>
        <h3>绑定手机</h3>
        <p id="mobile" class='red'>未设置</p>
        <div class="update"><a id="setmobile">修改</a></div>

        <div id="pg-account-security-mobile" style="height:400px;clear:both;" class="fn-clear fn-hide">
          <div class="content">
            <div class="safety_step">
              <div class="bgline"></div>
              <div class="fourStep steps">
                <ul class="fn-clear">
                  <li class="one">验证原手机号码</li>
                  <li class="no">验证新手机号码</li>
                  <li class="no">成功</li>
                </ul>
              </div>
            </div>
            <form data-name="modMobileByPhoneStepOne" id="modMobileByPhoneStepOneForm" class="ui-form" method="post" action="/account/bindMobile!verifyOrigionalPhone.action">
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>原手机号码</label>
                  <span>153****0002</span>
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>手机验证码</label>
                  <input class="ui-input" name="validateCode" id="validateCode" type="text" value=""/>
                  <button id="getMobileCodeWithoutMobile" class="ui-button ui-button-green ui-button-small" >获取验证码</button>
                </div>
                <div class="ui-form-item fn-hide voice">
                          没收到短信？使用语音验证码进行手机验证。<br/>
                          来电号码 010-52278080 <button class="getVoiceCode ui-button ui-button-green ui-button-small" id="getVoiceCode">获取语音验证码</button>
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>提现密码</label>
                  <input class="ui-input" type="password" name="cashPassword" id="cashPassword" />
                </div>
                <div class="ui-form-item">
                  <input type="submit" value="下一步" id="subModMobileByPhoneStepOneBt" class="ui-button ui-button-mid ui-button-green" />
                </div> 
              </div>  
            </form>
          </div>  
        </div>

      </div>
    </li>
    <li>
      <div class="fn-clear">
        <div class="icon icon-cashpsw"></div>
        <h3>提现密码</h3>
        <p id="cash_pass" class='red'>未设置</p>
        <div class="update">
          <a id="modCashPswLink">修改</a> | <a id="findCashPswLink">找回</a>
        </div>
        <div id="pg-account-security-cash-pass" style="height:400px;clear:both;" class="fn-clear fn-hide">
          <div class="content">
            <p class="info">为了您的账户安全，请定期更换提现密码，并确保提现密码设置与登录密码不同。</p>
            <form data-name="modCashPsw" id="modCashPswForm" method="post" class="ui-form" action="/account/cashPwd!doModify.action" novalidate="novalidate">
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>原提现密码</label>
                  <input class="ui-input" name="cashPassword" type="password" id="cashPassword" placeholder="请输入原提现密码">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>新提现密码</label>
                  <input class="ui-input" name="newCashPwd" id="newCashPwd" type="password" placeholder="6-12位字母、数字和符号(不包括空格)" data-is="isPassWord">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>确认提现密码</label>
                  <input class="ui-input" name="newCashPwd2" id="newCashPwd2" type="password">
                </div>
                <div class="ui-form-item">
                  <input type="submit" value="提 交" id="subModCashPswBt" class="ui-button ui-button-mid ui-button-green">
                </div>  
              </div>
            </form>
            <p class="info">如果您在操作过程中出现问题，请点击页面右侧在线客服，或拨打好易贷客服电话：400-027-8080</p>
          </div>  
          <div class="fn-hide success">
            <h3 class="info">提现密码修改成功</h3>
            <a class="ui-button ui-button-mid ui-button-blue backBt">返回</a>
          </div>
        </div>
        <div id="pg-account-security-find-cash-pass" style="height:400px;clear:both;" class="fn-clear fn-hide">
          <div class="content">
            <div style="height: 100px;">
              <div class="safety_step">
                <div class="bgline"></div>
                <div class="threeStep steps">
                  <ul class="fn-clear">
                    <li class="one">验证手机号码</li>
                    <li class="no">重设提现密码</li>
                    <li class="no">成功</li>
                  </ul>
                </div>
              </div>
            </div>
            <form data-name="findCashPswStepOne" id="findCashPswFormStepOneForm" method="post" action="/account/bindMobile!verifyOrigionalPhone.action?go=cashPwd2" class="ui-form" novalidate="novalidate">
              <div class="inputs">
                <div class="ui-form-item clearboth">
                  <label class="ui-label">绑定的手机号码</label> <span>153****0002</span>
                </div>
                  <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>手机验证码</label>
                  <input type="text" class="ui-input code" name="validateCode" id="validateCode" value="">
                  <button id="getMobileCodeWithoutMobile" class="ui-button ui-button-green ui-button-small">获取验证码</button>
                  </div>
                  <div class="ui-form-item fn-hide voice">
                          没收到短信？使用语音验证码进行手机验证。<br>
                          来电号码 010-52278080 <button class="getVoiceCode ui-button ui-button-green ui-button-small" id="getVoiceCode">获取语音验证码</button>
                    </div>
                  <div class="ui-form-item">
                  <input type="submit" value="下一步" id="subFindCashPswStepOneBt" class="ui-button ui-button-mid ui-button-green">
                </div>  
              </div>
            </form>
          </div>  
        </div>



      </div>
    </li>
  </ul>
</div>