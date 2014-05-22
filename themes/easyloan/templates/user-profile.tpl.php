<?php

drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/common.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/iconfont.css');
//drupal_add_css(drupal_get_path('theme','easyloan') . '/css/jquery.powertip.min.css');

//drupal_add_js(drupal_get_path('theme','easyloan') . '/js/jquery.powertip.min.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');

global $base_url;
$img_path = $base_url . '/' . drupal_get_path('theme','easyloan') . '/images/';

global $user;
$current_user = $variables["elements"]["#account"];
$markup = $variables["elements"]["user_picture"];
?>
<script>


(function ($, Drupal, window, document, undefined) {
// To understand behaviors, see https://drupal.org/node/756722#behaviors 
Drupal.behaviors.tip = {
  attach: function(context, settings) {
  $('#tips_1').powerTip({ placement: 'e' });
  }
};
})(jQuery, Drupal, this, this.document);
</script>
<div class="grid_10">
<div class="ui-poptip fn-hide" id="tipCon_3" style="position: absolute; left: 260px; top: 156px; display: block;">
  <div class="ui-poptip-shadow">
      <div class="ui-poptip-container">
          <div class="ui-poptip-arrow ui-poptip-arrow-11">
          <em></em>
          <span></span>
      </div>
      <div class="ui-poptip-content" data-role="content"><div>为了使您的账户有更多的安全保障，请您绑定邮箱。<p><a href="/account/info!security.action">立即绑定</a></p><span class="closeTip" style="position: absolute;right:-1px;top:-1px;cursor: pointer;color:red;border: 1px solid #FFBB76;padding: 0 2px; height: 16px;line-height: 16px;">X</span></div></div>
  </div>
</div>
</div>
<div class="ad-section">
<img src="<?php print $img_path; ?>default-banner.png">
</div>

<div class="box box-user-info">
<div class="user-avatar-container">
    <?php print render($markup); ?>
</div>
<div class="user-info-container">
  <h3 title="<?php print $current_user->name; ?>"><?php print $current_user->name; ?></h3>
  <div class="fn-clear">
    <div class="fn-left user-security-container mr10" id="info-box">
      <div class="safe fn-clear">
        <span class="fn-left color-gray-text">安全等级</span>
        <div id="safe-progressbar" class="safe-progressbar fn-left" title="75%"><div class="bar" style="width: 75px;"></div></div>
      </div>
      <div class="icons fn-clear mt5">
        <div class="fn-left icon-box light">
          <a data-txt="为了您的账户更安全，请您绑定手机号。||立即绑定" title="绑定手机，已绑定" href="/account/info!security.action" class="fn-left safe-rank cellphone light"></a>
        </div>
        <div class="fn-left icon-box light">
          <a data-txt="进行实名认证后，您才可以进行投资、借款。||立即认证" title="实名认证，已设置" href="/account/info!security.action" class="fn-left safe-rank man light"></a>
        </div>
        <div class="fn-left icon-box light">
          <a data-txt="为了您的资金更加安全，请您设置提现密码。||立即设置" title="提现密码，已设置" href="/account/info!security.action" class="fn-left safe-rank lock light"></a>
        </div>
        <div class="fn-left icon-box ">
          <a data-txt="为了使您的账户有更多的安全保障，请您绑定邮箱。||立即绑定" title="绑定邮箱，未绑定" href="/account/info!security.action" class="fn-left safe-rank mail "></a>
        </div>
      </div>
    </div>
    <div class="fn-left last">
      <div class="surplus fn-clear">
        <span class="fn-left text-l mr10">账户余额</span>
        <span class="fn-left num-xl color-orange-text">
          <em>0.00</em>元
        </span>
        <a class="fn-left ui-button ui-button-green ui-button-mid mr4" href="<?php print $base_url;?>/capital_management/recharge">充值</a>
        <a class="fn-left ui-button ui-button-blue ui-button-mid last" href="<?php print $base_url;?>/capital_management/withdraw">提现</a>
      </div>
      <div class="surplus-detail fn-clear">
        <div class="fn-left mr40">
          <span class="fn-left text mr10">冻结金额</span>
          <span class="fn-left num last">
            <em>0.00</em>元
          </span>
        </div>
        <div class="fn-left last">
          <span class="fn-left text mr10">可用金额</span>
          <span class="fn-left num last">
            <em>0.00</em>元
          </span>
        </div>
      </div>
      
    </div>
  </div>
</div>
</div>
<!-- ad start -->
<div class="ad-dimgray mt20">
<i class="icon icon-hui"></i>活动：2014年1月17日10时至2014年3月31日18时，债权转让费率下调至0.5%。
<a href="/about/detail.action?noticeId=302" target="_blank">查看详情</a>
</div>
<!-- ad end -->
<div class="box mt20 p20">
<div class="fn-clear equation">
  <div class="fn-left text-center">
    <h5>账户净资产</h5>
    <p class="num-l">
      <em>0.00</em>元
    </p>
  </div>
  <div class="fn-left symbol">=</div>
  <div class="fn-left text-center">
    <h5>理财资产<i id="tips_1" class="iconfont tips" title="Thanks">&#xF046;</i></h5>
    <p class="num-l">
      <em>0.00</em>元
    </p>
  </div>
  <div class="fn-left symbol">+</div>
  <div class="fn-left text-center">
    <h5>借款负债</h5>
    <p class="num-l rrdcolor-red-text">
      <em>-0.00</em>元
    </p>
  </div>
  <div class="fn-left symbol">+</div>
  <div class="fn-left text-center">
    <h5>账户余额</h5>
    <p class="num-l">
      <em>0.00</em>元
    </p>
  </div>
</div>
<div>
  <div class="fn-clear summary">
    <a class="fn-left text mr30" href="/account/invest!loan.action">理财账户</a>
    <p class="fn-left text mr10">已赚总金额</p>
    <p class="fn-left num"><em>0.00</em>元</p>
    <a class="fn-right text mr30" href="/account/invest!backAccount.action">回账查询</a>
  </div>
  <ul class="ui-list ui-list-s">
    <li class="ui-list-header fn-clear">
      <span class="ui-list-title fn-left color-gray-text w120">理财方式</span>
      <span class="ui-list-title fn-left color-gray-text w160">账户资产</span>
      <span class="ui-list-title fn-left color-gray-text w160">已赚金额<i id="tips_2" class="iconfont tips"></i></span>
      <span class="ui-list-title fn-left color-gray-text w120">加权平均收益率</span>
      <span class="ui-list-title fn-left color-gray-text w80">持有数量</span>
      <span class="ui-list-title fn-left color-gray-text w80"></span>
    </li>
    <li class="ui-list-item fn-clear">
      <span class="ui-list-field fn-left w100 ph10">债权投资</span>
      <span class="ui-list-field fn-left num-s text-right w140 pr20"><em>0.00</em>元</span>
      <span class="ui-list-field fn-left num-s text-right w140 pr20"><em>0.00</em>元</span>
      <span class="ui-list-field fn-left num-s text-right w90 pr30"><em>0.0</em>%</span>
      <span class="ui-list-field fn-left text-center w80"><em>0</em></span>
      <span class="ui-list-field fn-left text-center w80 last"><a href="/account/invest!loan.action">查看</a></span>
    </li>
    <li class="ui-list-item fn-clear last">
      <span class="ui-list-field fn-left w100 ph10">优选理财计划</span>
      <span class="ui-list-field fn-left num-s text-right w140 pr20"><em>0.00</em>元</span>
      <span class="ui-list-field fn-left num-s text-right w140 pr20"><em>0.00</em>元</span>
      <span class="ui-list-field fn-left num-s text-right w90 pr30"><em>0.0</em>%</span>
      <span class="ui-list-field fn-left text-center w80"><em>0</em></span>
      <span class="ui-list-field fn-left text-center w80 last"><a href="/account/invest!plan.action">查看</a></span>
    </li>
  </ul>
</div>
<div class="mt20 mb20">
  <div class="fn-clear summary">
    <a class="fn-left text mr30" href="/account/borrow!toMyLoans.action">借款账户</a>
    <p class="fn-left text mr10">待还总金额</p>
    <p class="fn-left num"><em>0.00</em>元</p>
    <a class="fn-right text mr30" href="/account/borrow!applications.action">申请查询</a>
  </div>
  <ul class="ui-list ui-list-s" id="borrowing">
<li class="ui-list-header fn-clear">
<span class="ui-list-title fn-left color-gray-text w200">借款标题</span>
<span class="ui-list-title fn-left color-gray-text w160">待还本金</span>
<span class="ui-list-title fn-left color-gray-text w160">待还利息/管理费</span>
<span class="ui-list-title fn-left color-gray-text w100">逾期费用</span>
<span class="ui-list-title fn-left color-gray-text w110 last"></span>
</li>

<li class="ui-list-status">
<p class="color-gray-text">没有借款记录</p>
</li>

</ul>
</div>
</div>