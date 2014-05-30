<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

$js_path = $base_url . '/' . $theme_path . '/js/';
$image_path = $base_url . '/' . $theme_path . '/images/';

drupal_add_css($theme_path . '/css/iconfont.css');
drupal_add_css($theme_path . '/css/account.css');
drupal_add_css($theme_path . '/css/dialog.css');
drupal_add_css($theme_path . '/css/popuptip.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js('var js_path=\'' . $js_path . '\';var image_path=\'' . $image_path . '\';var account_name=null;', 'inline');
drupal_add_js($theme_path . '/js/banks.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/bankcardadd.js');
drupal_add_js($theme_path . '/js/withdraw.js');
?>
<div class="p20bs color-white-bg fn-clear" id="pg-account-withdraw">
  <form class="ui-form" method="post" id="withdrawForm" name="withdrawForm">
    <div id="bankList" class="bankList">
      <div class="title">选择提现银行卡</div>
      <div id="banklis">
        <ul class="fn-clear">
          <li>
            <a class="openLink addBank" tabindex="-1">
              <img src="<?php print $image_path; ?>add.jpg">
            </a>
            <div class="card"><a class="openLink addBank" tabindex="-1">新增银行卡</a></div>
          </li>
        </ul>
      </div>

      <div class="fn-clear invisiblediv">
        <input class="fn-left invisible" type="hidden" name="bankId" id="bankId">
        <input class="fn-left invisible" type="hidden" name="cardNumber" id="cardNumber">
        <label for="bankId" class="error" style="display: none;">请选择提现银行卡</label>
      </div>
      <div class="operateBank fn-clear">
        <a data-toggle="更多银行卡 隐藏部分银行卡" id="moreBank" class="fn-left more-hide">更多银行卡</a>
        <a class="mgmtBank fn-right" id="mgmtBank" href="/account_management/bankcard">管理银行卡</a>
        <a class="addBank fn-right" tabindex="-1">添加银行卡</a>
      </div>
    </div>
    <div class="withdrawInputs mt20">
      <div class="title">填写提现金额</div>
      <div class="inputs">
        <div class="ui-form-item">
          <label class="ui-label">可用资金</label>
          <em class="value" id="withdrawRemain">0.00</em>元
          <input id="totalAmount" type="hidden" value="0.0">
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>提现金额</label>
          <input class="ui-input" type="text" name="amount" id="withdrawAmount" data-is="isAmount isEnough" autocomplete="off" disableautocomplete="">
          <label for="withdrawAmount" class="error" style="display: none;">提现金额不能为空</label>
        </div>
        <div class="ui-form-item">
          <label class="ui-label">提现费用</label>
          <em class="value" id="withdrawFee">0.00</em>元
          <i id="tips" class="iconfont tips"></i>
          <span class="info">提现费用将从您的好易贷账户余额中扣除</span>
          <div class="ui-poptip fn-hide" id="tipCon" data-widget-cid="widget-2" style="z-index: 99; position: absolute; left: 257px; top: -7px; display: none;">
            <div class="ui-poptip-shadow">
              <div class="ui-poptip-container">
                <div class="ui-poptip-arrow ui-poptip-arrow-10">
                  <em></em>
                  <span></span>
                </div>
                <div class="ui-poptip-content" data-role="content">
                  <p>第三方收取提现手续费：</p>
                  <table width="100%" class="tiptable">
                    <tbody>
                      <tr>
                        <th>2万元以下</th>
                        <th>2万元(含)-5万元</th>
                        <th>5万元(含)-100万元</th>
                      </tr>
                      <tr>
                        <td>1元/笔</td>
                        <td>3元/笔</td>
                        <td>5元/笔</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="ui-form-item">
          <label class="ui-label">实际扣除金额</label>
          <em class="value" id="withdrawReal">0.00</em>元
        </div>
        <div class="ui-form-item">
          <label class="ui-label">预计到账日期</label>
          <em id="withdrawDate"></em>
          <span class="info">1-2个工作日（双休日和法定节假日除外）之内到账</span>
        </div>
        <div class="ui-form-item">
          <label class="ui-label"><span class="ui-form-required">*</span>提现密码</label>
          <input class="ui-input" type="password" name="cashPassword" id="cashPassword" data-is="isPassWord">
          <a href="/account_management/security" class="findPsw" id="findPsw">忘记密码</a>
          <label for="cashPassword" class="error" style="display: none;">提现密码不能为空</label>
        </div>
        <input type="hidden" name="amountModified" id="amountModified" value="0">
        <input type="hidden" name="cashPassModified" id="cashPassModified" value="0">
        <div class="ui-form-item widthdrawBtBox">
          <input type="button" id="subWithdraw" class="ui-button ui-button-mid ui-button-green" value="提 现">
        </div>
      </div>
    </div>
    <div class="notice">
      <div class="title">温馨提示</div>
      <ol>
        <li>请确保您输入的提现金额，以及银行帐号信息准确无误。</li>
        <li>如果您填写的提现信息不正确可能导致提现失败，由此产生的提现费用将不予返还。 </li>
        <li>在双休日和法定节假日期间，用户可以申请提现，好易贷将在下一个工作日处理。由此造成的不便，请谅解！</li>
        <li>禁止洗钱、信用卡套现、虚假交易等行为，一经确认，将终止该账户的使用。</li>
      </ol>
    </div>
  </form>

</div>