<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

$js_path = $base_url . '/' . $theme_path . '/js/';
$image_path = $base_url . '/' . $theme_path . '/images/';

drupal_add_library('system', 'ui.dialog');

drupal_add_css($theme_path . '/css/iconfont.css');
drupal_add_css($theme_path . '/css/dialog.css');
drupal_add_css($theme_path . '/css/account.css');
drupal_add_css($theme_path . '/css/popuptip.css');

drupal_add_js('var js_path=\'' . $js_path . '\';var image_path=\'' . $image_path . '\';', 'inline');
drupal_add_js($theme_path . '/js/banks.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/recharge.js');
?>
<div class="p20bs color-white-bg fn-clear" id="pg-account-recharge">
  <form class="ui-form" method="post" id="regchargeForm" name="checkinForm">
    <div class="bankList" id="bankList">
      <div class="title mb20">选择充值方式</div>
      <dl class="clearfix" id="banks"></dl>
      <label for="bank" class="error errorforbank" style="display:none">请选择充值方式</label>
    </div>

    <div class="inputbox">
      <div class="title">填写充值金额</div>
      <div class="wrap mt20">
        <div class="ui-form-item">
          <label class="ui-label">账户余额</label>
          <em class="value" id="rechargeRemain">0.00</em>元
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>充值金额</label>
          <input type="text" name="amount" value="" style="display:none">
          <input class="ui-input" type="text" name="amount" id="rechargeAmount" value="" autocomplete="off">元
          <label class="error" for="rechargeAmount" style="display: none;"></label>
        </div>
        <div class="ui-form-item">
          <label class="ui-label">充值费用</label>
          <em class="value" id="rechargePoundage">0.00</em>元
          <i id="tips" class="iconfont tips"></i>
          <div class="ui-poptip fn-hide" id="tipCon" data-widget-cid="widget-1" style="display: none; left: 257px; position: absolute; top: -7px; z-index: 99;">
            <div class="ui-poptip-shadow">
              <div class="ui-poptip-container">
                <div class="ui-poptip-arrow ui-poptip-arrow-10">
                  <em></em>
                  <span></span>
                </div>
                <div class="ui-poptip-content" data-role="content">
                  <ol>充值费用按充值金额的0.5%由第三方平台收取，上限100元，超出部分由好易贷承担。</ol>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>实际支付金额</label>
          <em class="value" id="rechargePay">0.00</em>元
        </div>
        <input type="hidden" name="bankId" id="bankId">
        <input type="hidden" name="amountModified" id="amountModified" value="0">
        <div class="ui-form-item">
          <input id="sub-recharge" type="button" class="ui-button ui-button-mid ui-button-green" value="充 值">
        </div>
      </div>
    </div>
    <div class="notice">
      <div class="title">温馨提示</div>
      <ol>
        <li>为了您的账户安全，请在充值前认证身份、绑定手机以及设置提现密码。</li>
        <li>您的账户资金将由第三方平台托管。 </li>
        <li>请注意您的银行卡充值限制，以免造成不便。 </li>
        <li>禁止洗钱、信用卡套现、虚假交易等行为，一经确认，将终止该账户的使用。</li>
        <li>如果充值金额没有及时到账，请联系客服。</li>
      </ol>
    </div>
  </form>
  
</div>
