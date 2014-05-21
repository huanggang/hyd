<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/iconfont.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');

drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $base_url;
$image_path = $base_url . '/sites/all/themes/easyloan/images/';
?>
	  <div class="p20bs color-white-bg fn-clear" id="pg-account-recharge">
	      <form class="ui-form" method="post" id="regchargeForm" name="checkinForm" target="_blank" action="#">
	        <div class="bankList" id="bankList">
	          <div class="title mb20">选择充值方式</div>
	          <dl class="clearfix" style="display: block;">
<dt>最近使用的充值方式</dt>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="ICBC" id="bank_recent0"><label for="bank_recent0"><img alt="中国工商银行" title="中国工商银行" src="<?php print $image_path; ?>code_102.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="CMB" id="bank_recent1"><label for="bank_recent1"><img alt="招商银行" title="招商银行" src="<?php print $image_path; ?>code_308.jpg"></label>
</dd>

 </dl>
	          <dl class="clearfix" style="display: none;">
<dt>充值银行</dt>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="ICBC" id="bank_1"><label for="bank_1"><img alt="中国工商银行" title="中国工商银行" src="<?php print $image_path; ?>code_102.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="ABC" id="bank_2"><label for="bank_2"><img alt="中国农业银行" title="中国农业银行" src="<?php print $image_path; ?>code_103.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="CMB" id="bank_5"><label for="bank_5"><img alt="招商银行" title="招商银行" src="<?php print $image_path; ?>code_308.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="TENPAY" value="COMM" id="bank_9"><label for="bank_9"><img alt="交通银行" title="交通银行" src="<?php print $image_path; ?>code_301.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="TENPAY" value="POSTGC" id="bank_7"><label for="bank_7"><img alt="中国邮政储蓄银行" title="中国邮政储蓄银行" src="<?php print $image_path; ?>code_403.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="GDB" id="bank_15"><label for="bank_15"><img alt="广东发展银行" title="广东发展银行" src="<?php print $image_path; ?>code_306.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="CIB" id="bank_8"><label for="bank_8"><img alt="兴业银行" title="兴业银行" src="<?php print $image_path; ?>code_309.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="CCB" id="bank_4"><label for="bank_4"><img alt="中国建设银行" title="中国建设银行" src="<?php print $image_path; ?>code_105.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="BOC" id="bank_3"><label for="bank_3"><img alt="中国银行" title="中国银行" src="<?php print $image_path; ?>code_104.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="SPDB" id="bank_12"><label for="bank_12"><img alt="上海浦东发展银行" title="上海浦东发展银行" src="<?php print $image_path; ?>code_310.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="CMBC" id="bank_17"><label for="bank_17"><img alt="中国民生银行" title="中国民生银行" src="<?php print $image_path; ?>code_305.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="CEB" id="bank_6"><label for="bank_6"><img alt="中国光大银行" title="中国光大银行" src="<?php print $image_path; ?>code_303.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="CITIC" id="bank_10"><label for="bank_10"><img alt="中信银行" title="中信银行" src="<?php print $image_path; ?>code_302.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="SDB" id="bank_16"><label for="bank_16"><img alt="平安银行" title="平安银行" src="<?php print $image_path; ?>code_307.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="HXB" id="bank_11"><label for="bank_11"><img alt="华夏银行" title="华夏银行" src="<?php print $image_path; ?>code_304.jpg"></label>
</dd>

 </dl>
	          <dl class="clearfix" style="display: none;">
<dt>充值渠道</dt>

<dd>
  <input type="radio" name="bank" data-type="QUICKPAY" value="QUICKPAY" id="bank_q1"><label for="bank_q1"><img alt="快钱" title="快钱" src="<?php print $image_path; ?>checkin_kq.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="TENPAY" value="TENPAY" id="bank_q4"><label for="bank_q4"><img alt="财付通" title="财付通" src="<?php print $image_path; ?>tenpay.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="YEEPAY" value="YEEPAY" id="bank_q3"><label for="bank_q3"><img alt="易宝" title="易宝" src="<?php print $image_path; ?>yeepay.jpg"></label>
</dd>

<dd>
  <input type="radio" name="bank" data-type="CHINAPNR" value="CHINAPNR" id="bank_q2"><label for="bank_q2"><img alt="汇付天下" title="汇付天下" src="<?php print $image_path; ?>chinapnr.jpg"></label>
</dd>

 </dl><p class="foldbox"><a>查看更多充值方式</a></p>
	          <label for="bank" class="error errorforbank" style="display:none"></label>
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
	              <input class="ui-input" type="text" name="amount" id="rechargeAmount" value="">元
	            </div>
	            <div class="ui-form-item">
	              <label class="ui-label">充值费用</label>
	              <em class="value" id="rechargePoundage">0.00</em>元
	              <i id="tips" class="iconfont tips"></i>
	              <div class="ui-poptip fn-hide" id="tipCon" data-widget-cid="widget-1">
					    <div class="ui-poptip-shadow">
					    <div class="ui-poptip-container">
					        <div class="ui-poptip-arrow ui-poptip-arrow-10">
					            <em></em>
					            <span></span>
					        </div>
					        <div class="ui-poptip-content" data-role="content">
					             <ol>
					            	充值费用按充值金额的0.5%由第三方平台收取，上限100元，超出部分由人人贷承担。
					            </ol>
					        </div>
					    </div>
					    </div>
				  </div>
	            </div>
	            
	            <div class="ui-form-item">
	              <input class="ui-input" type="checkbox" name="free" id="rechargeFree">
	              <span>使用最近到期的一张充值免费券（共 1张）</span>
	              <i id="tips2" class="iconfont tips"></i>
	              <div class="ui-poptip fn-hide" id="tipCon2" data-widget-cid="widget-2">
					    <div class="ui-poptip-shadow">
					    <div class="ui-poptip-container">
					        <div class="ui-poptip-arrow ui-poptip-arrow-10">
					            <em></em>
					            <span></span>
					        </div>
					        <div class="ui-poptip-content" data-role="content">
					        	<p>到期时间：</p>
					            <ol>
					            	
										<li>2014-04-12</li>
					            	
					            </ol>
					        </div>
					    </div>
					    </div>
				  </div>

	            </div>
	            
	            <div class="ui-form-item">
	              <label class="ui-label"><span class="ui-form-required">*</span>实际支付金额</label>
	              <em class="value" id="rechargePay">0.00</em>元
	            </div>
	            <input type="hidden" value="" id="payFeeType">
	            <input type="hidden" name="bankId" id="bankId">
	            <input type="hidden" name="paytype" id="paytype">
	            <div class="ui-form-item">
	            	<input id="sub-recharge" type="submit" class="ui-button ui-button-mid ui-button-green" value="充 值">
				</div>
	          </div>

	        </div>
	        <div class="notice">
	          <div class="title">温馨提示</div>
	          <ol>
	            <li>为了您的账户安全，请在充值前进行身份认证、手机绑定以及提现密码设置。</li>
	            <li>您的账户资金将由第三方平台托管。 </li>
	            <li>请注意您的银行卡充值限制，以免造成不便。 </li>
	            <li>禁止洗钱、信用卡套现、虚假交易等行为，一经发现并确认，将终止该账户的使用。</li>
	            <li>如果充值金额没有及时到账，请联系客服，400-027-8080。</li>
	          </ol>
	        </div>

	      </form>
    <div class="hide">
        <div id="afterSub" class="afterSub">
        <h3>请您在新打开的网上银行页面上完成付款</h3>
        <p>付款完成前请不要关闭此窗口。</p>
        <p>完成付款后请根据您的情况点击下面的按钮：</p>
        <a class="ui-button ui-button-mid ui-button-green" id="finishRecharge">已完成付款</a> <a class="ui-button ui-button-mid ui-button-green" id="troubleRecharge">付款遇到问题</a>
        </div>
    </div>



    </div>