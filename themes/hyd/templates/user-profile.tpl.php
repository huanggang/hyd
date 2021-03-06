<?php

drupal_add_css(drupal_get_path('theme','hyd') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','hyd') . '/css/common.css');
drupal_add_css(drupal_get_path('theme','hyd') . '/css/iconfont.css');

global $base_url;
$theme_path = drupal_get_path('theme','hyd');
$img_path = $base_url . '/' . $theme_path . '/images/';

global $user;

$current_user = $variables["elements"]["#account"];

$is_my_page = ($current_user->uid == $user->uid);

$markup = $variables["elements"]["user_picture"];

// load the account to check
// $account = menu_get_object('user');
$security_url = $is_my_page ? $base_url . '/account_management/security':'#';

if (!$is_my_page){
  drupal_add_js($theme_path . '/js/educations.js');
  drupal_add_js($theme_path . '/js/provinces.js');
  drupal_add_js($theme_path . '/js/marital_status.js');

  $js_path = $base_url . '/' . $theme_path . '/js/';
  drupal_add_js('var js_path=\'' . $js_path . '\'', 'inline');
}

drupal_add_js(drupal_get_path('theme','hyd') . '/js/account.js');
drupal_add_js(drupal_get_path('theme','hyd') . '/js/account_info.js');


$in_url = $is_my_page ? $base_url . '/invest_management' : '#';
$lo_url = $is_my_page ? $base_url . '/loan_management' : '#';

?>
<script>
var uid = <?php print $current_user->uid; ?>;
var is_my_page = <?php print $is_my_page? "true":"false"; ?>;
</script>

<div class="grid_10">
  <div class="top-section">
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
      <div class="icons fn-clear mt15">
        <div class="fn-left icon-box" id="icon-mobile" > 
          <a title="绑定手机，点击绑定" href="<?php print $security_url; ?>" class="fn-left safe-rank cellphone"></a>
        </div>
        <div class="fn-left icon-box" id="icon-ssn" >
          <a title="实名认证，点击设置" href="<?php print $security_url; ?>" class="fn-left safe-rank man"></a>
        </div>
        <?php if ($is_my_page){ ?>
        <div class="fn-left icon-box" id="icon-cash-pass" >
          <a title="提现密码，点击设置" href="<?php print $security_url; ?>" class="fn-left safe-rank lock"></a>
        </div>
        <?php } ?>
        <div class="fn-left icon-box " id="icon-email" >
          <a title="绑定邮箱，点击绑定" href="<?php print $security_url; ?>" class="fn-left safe-rank mail"></a>
        </div>
      </div>
    </div>
    <div class="fn-left last">
      <div class="surplus fn-clear">
        <span class="fn-left text-l mr10">账户余额</span>
        <span class="fn-left num-xl color-orange-text">
          <em id="amount_available_0"></em>
        </span>
        <?php if ($is_my_page){ ?>
        <a class="fn-left ui-button ui-button-green ui-button-mid mr4" href="<?php print $base_url;?>/capital_management/recharge">充值</a>
        <a class="fn-left ui-button ui-button-blue ui-button-mid last" href="<?php print $base_url;?>/capital_management/withdraw">提现</a>
        <?php } else { ?>
        <a class="fn-left ui-button ui-button-green ui-button-mid mr4" href="<?php print $base_url;?>/capital_management/deals/<?php print $current_user->uid;?>">查看交易记录</a>
        <?php } ?>
      </div>
      <div class="surplus-detail fn-clear">
      <?php if ($is_my_page){ ?>
        <div class="fn-left mr30">
          <span class="fn-left text mr10">冻结金额</span>
          <span class="fn-left num last">
            <em id="amount_frozen_0"></em>
          </span>
        </div>
      <?php } ?>
        <div class="fn-left mr30">
          <span class="fn-left text mr10">账户欠款</span>
          <span class="fn-left num">
            <em id="amount_owned_0"></em>
          </span>
        </div>
        <div class="fn-left last">
          <span class="fn-left text mr10">欠款罚金</span>
          <span class="fn-left num last">
            <em id="amount_fine_0"></em>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if (!$is_my_page){ ?>
  <div class="fn-clear pl50">
    <span class="mr10"><em id="name"></em></span><span class="mr10"><em id="gender"></em></span><span class="mr10"><em id="ssn"></em></span><br />
    <span class="mr10"><em id="dob"></em></span><span class="mr10"><em id="education"></em></span><span class="mr10"><em id="marital"></em></span><br />
    <span class="mr10"><em id="province"></em><em id="city"></em></span><span class="mr10"><em id="address"></em></span><br />
  </div>
  <br />
<?php } ?>
</div>
<?php 
  if ($is_my_page){ 
    print views_embed_view('latest_notice', "block", "");
  }
?>
<div class="box mt20 p5">
<div class="fn-clear equation">
  <div class="fn-left text-center">
    <h5>账户净资产</h5>
    <p class="num-l">
      <em id="amount_total"></em>
    </p>
  </div>
  <div class="fn-left symbol">=</div>
  <div class="fn-left text-center">
    <h5>投资金额</h5>
    <p class="num-l">
      <em id="amount_investment"></em>
    </p>
  </div>
  <div class="fn-left symbol">+</div>
  <div class="fn-left text-center">
    <h5>冻结金额</h5>
    <p class="num-l">
      <em id="amount_frozen"></em>
    </p>
  </div>
  <div class="fn-left symbol">+</div>
  <div class="fn-left text-center">
    <h5>账户余额</h5>
    <p class="num-l">
      <em id="amount_available"></em>
    </p>
  </div>
  <div class="fn-left symbol">-</div>
  <div class="fn-left text-center">
    <h5>待还本金</h5>
    <p class="num-l rrdcolor-red-text">
      <em id="amount_loaned"></em>
    </p>
  </div>
  <div class="fn-left symbol">-</div>
  <div class="fn-left text-center">
    <h5>待付利息</h5>
    <p class="num-l rrdcolor-red-text">
      <em id="amount_interest"></em>
    </p>
  </div>
  <div class="fn-left symbol">-</div>
  <div class="fn-left text-center">
    <h5>账户欠款</h5>
    <p class="num-l rrdcolor-red-text">
      <em id="amount_owned"></em>
    </p>
  </div>
  <div class="fn-left symbol">-</div>
  <div class="fn-left text-center">
    <h5>欠款罚金</h5>
    <p class="num-l rrdcolor-red-text">
      <em id="amount_fine"></em>
    </p>
  </div>
</div>
<div>
  <div class="fn-clear summary">
    <a class="fn-left text mr30" href="<?php print $in_url; ?>">投资账户</a>
  </div>
  <ul class="ui-list ui-list-s">
    <li class="ui-list-header fn-clear">
      <span class="ui-list-title fn-left color-gray-text w240">已结束投资总利息</span>
      <span class="ui-list-title fn-left color-gray-text w240">已结束投资总逾期罚金</span>
      <span class="ui-list-title fn-left color-gray-text w220">已结束投资加权平均年收益</span>
    </li>
    <li class="ui-list-item fn-clear">
      <span class="ui-list-field fn-left num-s text-center w220 pr20"><em id="i_interest"></em></span>
      <span class="ui-list-field fn-left num-s text-center w220 pr20"><em id="i_fine"></em></span>
      <span class="ui-list-field fn-left num-s text-center w200 pr20"><em id="i_rate"></em>%</span>
    </li>
  </ul>
</div>
<div class="mt20 mb20">
  <div class="fn-clear summary">
    <a class="fn-left text mr30" href="<?php print $lo_url; ?>">借款账户</a>
  </div>
  <ul class="ui-list ui-list-s" id="borrowing">
<li class="ui-list-header fn-clear">
<?php if ($is_my_page){ ?>
  <span class="ui-list-title fn-left color-gray-text w100">待还本金</span>
  <span class="ui-list-title fn-left color-gray-text w100">待还利息</span>
  <span class="ui-list-title fn-left color-gray-text w100">欠款金额</span>
  <span class="ui-list-title fn-left color-gray-text w100 pr20">欠款罚金</span>
  <span class="ui-list-title fn-left color-gray-text two-line w80 pr20">已结束借款总利息</span>
  <span class="ui-list-title fn-left color-gray-text two-line w80 pr20">已结束借款总逾期罚金</span>
  <span class="ui-list-title fn-left color-gray-text two-line w130">已结束借款加权平均年利率</span>
<?php } else { ?>
  <span class="ui-list-title fn-left color-gray-text w100">待还本金</span>
  <span class="ui-list-title fn-left color-gray-text w100">待还利息</span>
  <span class="ui-list-title fn-left color-gray-text w180 pr20">已结束借款总利息</span>
  <span class="ui-list-title fn-left color-gray-text w180 pr20">已结束借款总逾期罚金</span>
  <span class="ui-list-title fn-left color-gray-text two-line w150">已结束借款加权平均年利率</span>
<?php } ?>
</li>

<li class="ui-list-status fn-hide">
  <p class="color-gray-text">没有借款记录</p>
</li>

<li class="ui-list-item fn-clear">
<?php if ($is_my_page){ ?>
  <span class="ui-list-field fn-left num-s text-center w100 pr10 pl10"><em id="w_amount"></em></span>
  <span class="ui-list-field fn-left num-s text-center w80 pr20"><em id="w_interest"></em></span>
  <span class="ui-list-field fn-left num-s text-center w80 pr20"><em id="w_owned"></em></span>
  <span class="ui-list-field fn-left num-s text-center w100 pr20"><em id="w_fine"></em></span>
  <span class="ui-list-field fn-left num-s text-center w80 pr20"><em id="l_interest"></em></span>
  <span class="ui-list-field fn-left num-s text-center w80 pr20"><em id="l_fine"></em></span>
  <span class="ui-list-field fn-left num-s text-center w80 pr20"><em id="l_rate"></em>%</span>
  <!--span class="ui-list-field fn-left text-center w100 last"><a href="#">查看</a></span-->
<?php } else { ?>
  <span class="ui-list-field fn-left num-s text-center w90 pl10 pr10"><em id="w_amount"></em></span>
  <span class="ui-list-field fn-left num-s text-center w80 pr20"><em id="w_interest"></em></span>
  <span class="ui-list-field fn-left num-s text-center w180 pr20"><em id="l_interest"></em></span>
  <span class="ui-list-field fn-left num-s text-center w180 pr20"><em id="l_fine"></em></span>
  <span class="ui-list-field fn-left num-s text-center w150 pr20"><em id="l_rate"></em>%</span>
<?php } ?>
</li>

</ul>
</div>
</div>