<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/iconfont.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');

global $base_url;
$img_path = $base_url . '/' . drupal_get_path('theme','easyloan') . '/images/';
?>
    <div class="p20bs color-white-bg fn-clear" id="pg-account-withdraw">
       <form class="ui-form" method="post" action="#" onsubmit="return false;">
         <div id="bankList" class="bankList">
            <div class="title">选择提现银行卡</div>
            <div id="banklis">
              <ul class="fn-clear">
              <li class="bankli" data-bank="92585">
                <img alt="" title="" src="<?php print $img_path; ?>code_308.jpg"><div class="card">6247 **** **** 6247</div><em></em> 
              </li>
              </ul>
            </div>
      
            <div class="fn-clear invisiblediv"><input class="fn-left invisible" type="text" name="userBankId" id="userBankId"></div>
            <div class="operateBank fn-clear">
              <a class="more-hide fn-left" id="moreBank" data-toggle="更多银行卡 隐藏部分银行卡" style="display: none;">更多银行卡</a>
              <a class="mgmtBank fn-right" id="mgmtBank" href="/account/info!bank.action">管理银行卡</a>
              <a class="addBank fn-right" href="/account/userBank!toAdd.action" tabindex="-1">添加银行卡</a>
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
              </div>
              <div class="ui-form-item">
                <label class="ui-label">提现费用</label>
                <em class="value" id="withdrawFee">0.00</em>元
                <i id="tips" class="iconfont tips"></i>
                <span class="info">提现费用将从您的好易贷账户余额中扣除</span>
                <div class="ui-poptip fn-hide" id="tipCon" data-widget-cid="widget-2">
              <div class="ui-poptip-shadow">
              <div class="ui-poptip-container">
                  <div class="ui-poptip-arrow ui-poptip-arrow-10">
                      <em></em>
                      <span></span>
                  </div>
                  <div class="ui-poptip-content" data-role="content">
                      <p>第三方收取提现手续费：</p>
                      <table width="100%" class="tiptable">
                  <tbody><tr>
                    <th>2万元以下</th>
                    <th>2万元(含)-5万元</th>
                    <th>5万元(含)-100万元</th>
                  </tr>
                  <tr>
                    <td>1元/笔</td>
                    <td>3元/笔</td>
                    <td>5元/笔</td>
                  </tr>
                 </tbody></table>
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
                <em id="withdrawDate">2014-03-03</em>
                <span class="info">1-2个工作日（双休日和法定节假日除外）之内到账</span>
              </div>
              <div class="ui-form-item">
                <label class="ui-label"><span class="ui-form-required">*</span>提现密码</label>
                <input class="ui-input" type="password" name="cashPassword" id="cashPassword" data-is="isPassWord">
                <a href="/account/info!security.action" class="findPsw" id="findPsw">忘记密码</a>
              </div>
              <div class="ui-form-item widthdrawBtBox">
                <input type="submit" id="subWithdraw" class="ui-button ui-button-mid ui-button-green" value="提 现">
              </div>  
            </div>
  
          </div>
        <div class="notice">
            <div class="title">温馨提示</div>
            <ol>
              <li>请确保您输入的提现金额，以及银行帐号信息准确无误。</li>
              <li>如果您填写的提现信息不正确可能会导致提现失败，由此产生的提现费用将不予返还。 </li>
              <li> 在双休日和法定节假日期间，用户可以申请提现，人人贷会在下一个工作日进行处理。由此造成的不便，请多多谅解！</li>
              <li> 平台禁止洗钱、信用卡套现、虚假交易等行为，一经发现并确认，将终止该账户的使用。</li>
            </ol>
          </div>
         </form>

    </div>