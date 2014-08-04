<?php

global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/account.css');
drupal_add_js($theme_path . '/js/account.js');

drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/valid_methods.js');
drupal_add_js($theme_path . '/js/usersecurity.js');

$img_path = $base_url . '/' . $theme_path . '/images/';

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
            <form class="ui-form" method="post" id="modPswForm">
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>原密码</label>
                  <input type="password" id="oldPassword" name="oldPassword" class="ui-input" placeholder="请输入原登录密码">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>新密码</label>
                  <input type="password" id="newPassword" name="newPassword" class="ui-input" placeholder="6-16位字母、数字和符号(不包括空格)">
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
        <p id="validemail" class='red'>未设置</p>
        <div class="update"><a id="setemail">设置</a></div>
        <div id="pg-account-security-email" style="height:300px;clear:both;" class="fn-clear fn-hide">
          <div>
            
            <div id="emailSettingForm" class="content setFormBox">
              <form class="ui-form" method="post" id="setEmailForm">
                <div class="inputs">
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>邮箱</label>
                    <input type="text" name="email" id="email" class="ui-input">
                  </div>
                  <div class="ui-form-item">
                    <input type="submit" id="subSetEmailBt" value="提 交" class="ui-button ui-button-mid ui-button-green">
                  </div>  
                </div>
              </form>
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
        <div class="update"><a id="setmobile">设置</a></div>
        <div id="pg-account-security-mobile" style="height:400px;clear:both;" class="fn-clear fn-hide">

          <div id='mobileStep1' class="content">
            <div class="safety_step">
              <div class="bgline"></div>
              <div class="fourStep steps"> 
                <ul class="fn-clear"> 
                  <li class="one">解除原手机号码绑定</li>
                  <li class="no">验证新手机号码</li>
                  <li class="no">成功</li>
                </ul>
              </div>
            </div>
            <form id="modMobileByPhoneStepOneForm" class="ui-form">
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>原手机号码</label>
                  <span id='oldMobile'></span>
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>手机验证码</label>
                  <input class="ui-input" name="validateCode" id="validateCode" type="text" value=""/>
                  <input type="button" id="getMobileCodeWithoutMobile" class="ui-button ui-button-green ui-button-small" value="获取验证码" />
                </div>
                <div class="ui-form-item">
                  <input type="submit" value="下一步" id="subModMobileByPhoneStepOneBt" class="ui-button ui-button-mid ui-button-green" />
                </div> 
              </div>
            </form>
          </div>  

          <div id='mobileStep2' class="content fn-hide">
            <div class="safety_step">
              <div class="bgline"></div>
              <div class="fourStep steps"> 
                <ul class="fn-clear"> 
                  <li class="one">解除原手机号码绑定</li>
                  <li class="two">验证新手机号码</li>
                  <li class="no">成功</li>
                </ul>
              </div>
            </div>
            <form id="modMobileByPhoneStepTwoForm" class="ui-form" >
            <p class="info">原手机号码验证通过，请填写您的新手机号码。</p>
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label">新手机号码</label> 
                  <input type="text" id="phone" class="ui-input" name="phone">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label">手机验证码</label>
                  <input type="text" class="ui-input" name="validateCode2" id="validateCode2">
                  <input type="button" id="getMobileCode" class="ui-button ui-button-green ui-button-small" value="获取验证码" />
                </div>
                <div class="ui-form-item">
                  <input type="submit" value="下一步" id="subModMobileByPhoneStepTwoBt" class="ui-button ui-button-mid ui-button-green">
                </div>  
              </div>
            </form>
          </div>  

          <div id='mobileStep3' class="content fn-hide">
            <div class="safety_step">
              <div class="bgline"></div>
              <div class="fourStep steps"> 
                <ul class="fn-clear"> 
                  <li class="one">验证手机号码</li>
                  <li class="no">成功</li>
                </ul>
              </div>
            </div>
            <form id="modMobileByPhoneStepThreeForm" class="ui-form" >
            <p class="info">请填写您要绑定的手机号码。</p>
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label">手机号码</label> 
                  <input type="text" id="newphone" class="ui-input" name="newphone">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label">手机验证码</label>
                  <input type="text" class="ui-input" name="validateCode3" id="validateCode3">
                  <input type="button" id="getNewMobileCode" class="ui-button ui-button-green ui-button-small" value="获取验证码" />
                </div>
                <div class="ui-form-item">
                  <input type="submit" value="绑定号码" id="subModMobileByPhoneStepThreeBt" class="ui-button ui-button-mid ui-button-green">
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
          <span id="spSetCashPswLink"><a id="setCashPswLink">设置</a></span>
          <span id="spModCashPswLink" class="fn-hide"><a id="modCashPswLink">修改</a> | <a id="findCashPswLink">找回</a></span>
        </div>
        <div id="pg-account-security-cash-pass" style="height:400px;clear:both;" class="fn-clear fn-hide">

          <div id="setCachePassDiv" class="content">
            <p class="info">为了您的账户安全，请定期更换提现密码，并确保提现密码设置与登录密码不同。</p>
            <form id="setCashPswForm" class="ui-form">
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>提现密码</label>
                  <input class="ui-input" name="cashPassword" type="password" id="cashPassword" placeholder="请输入提现密码">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>确认提现密码</label>
                  <input class="ui-input" name="cashPassword2" id="cashPassword2" type="password" placeholder="请再次输入提现密码">
                </div>
                <div class="ui-form-item">
                  <input type="submit" value="提 交" id="subSetCashPswBt" class="ui-button ui-button-mid ui-button-green">
                </div>  
              </div>
            </form>
          </div>

          <div id="modCachePassDiv" class="content fn-hide"> 
            <p class="info">为了您的账户安全，请定期更换提现密码，并确保提现密码设置与登录密码不同。</p>
            <form id="modCashPswForm" class="ui-form">
              <div class="inputs">
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>原提现密码</label>
                  <input class="ui-input" name="cashPasswordOld" type="password" id="cashPasswordOld" placeholder="请输入原提现密码">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>新提现密码</label>
                  <input class="ui-input" name="newCashPwd" id="newCashPwd" type="password" placeholder="6-16位字母、数字和符号(不包括空格)">
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>确认提现密码</label>
                  <input class="ui-input" name="newCashPwd2" id="newCashPwd2" type="password" placeholder="请再次输入新提现密码">
                </div>
                <div class="ui-form-item">
                  <input type="submit" value="提 交" id="subModCashPswBt" class="ui-button ui-button-mid ui-button-green">
                </div>  
              </div>
            </form>
          </div>
        </div>

        <div id="pg-account-security-find-cash-pass" style="height:400px;clear:both;" class="fn-clear fn-hide">

          <div class="content p20" id="mobileCashPassStep0">
            <p class="info">请先绑定手机</p>  
          </div>  

          <div class="content p20" id="mobileCashPassStep1">
            <form id="findCashPswFormStepOneForm" class="ui-form">
              <div class="inputs">
                <div class="ui-form-item clearboth">
                  <label class="ui-label">绑定的手机号码</label> <span id="cashcodephone"></span>
                </div>
                <div class="ui-form-item">
                  <label class="ui-label"><span class="ui-form-required">*</span>手机验证码</label>
                  <input type="text" class="ui-input code" name="validateCode4" id="validateCode4" value="">
                  <input type="button" id="getMobileCodeFindCashPass" class="ui-button ui-button-green ui-button-small" value="获取验证码">
                </div>
                <div class="ui-form-item">
                   <label class="ui-label"><span class="ui-form-required">*</span>输入新提现密码</label>
                   <input type="password" class="ui-input" name="newFindCashPwd" id="newFindCashPwd" />
                 </div>
                 <div class="ui-form-item">
                   <label class="ui-label"><span class="ui-form-required">*</span>再次输入新提现密码</label>
                   <input type="password" class="ui-input" name="newFindCashPwd2" id="newFindCashPwd2" />
                 </div>
                <div class="ui-form-item">
                  <input type="submit" value="重设密码" id="subFindCashPswStepOneBt" class="ui-button ui-button-mid ui-button-green">
                </div>  
              </div>
            </form>
          </div>  
        </div>

        
      </div>
    </li>
  </ul>
</div>