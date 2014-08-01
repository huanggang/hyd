<?php
drupal_add_css(drupal_get_path('theme','hyd') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','hyd') . '/css/user.css');
drupal_add_js(drupal_get_path('theme','hyd') . '/js/account.js');
global $user;
$img_path = '../../' . drupal_get_path('theme','hyd') . '/images/default-avatar-96.png';

$userid = 123456;
?>
<div class="p20bs color-white-bg fn-clear" id="pg-account-user">
  <div class="fn-clear head"><div class="title fn-left">用户详细信息</div>
  <div class="fn-right"><a id="viewrecords" href="<?php print $userid; ?>/capital" class="ui-button ui-button-mid ui-button-blue">交易记录</a></div></div>
  <form data-name="userbasic" enctype="multipart/form-data" class="ui-form" method="post" id="userInfoForm">
  <div class="userphoto" id="userphoto">
    <a id="modUserPhoto" class="photo">
      <img src="<?php print $img_path; ?>">
    </a>
      <input name="avatar" id="modUserPhotoInput" type="hidden" value="">
  </div>
  <div class="inputs">
    <div class="ui-form-item">
      <label class="ui-label">昵称</label>
              <?php print $user->name;?>
            </div>  
            <div class="ui-form-item">
              <label class="ui-label">真实姓名</label>
              朱祖志
            </div>
            <div class="ui-form-item">
              <label class="ui-label">身份证号</label>
              44**** **** **** ****
            </div>
            <div class="ui-form-item">
              <label class="ui-label">性别</label>
              男
            </div>
            <div class="ui-form-item">
              <label class="ui-label">出生日期</label>
              1975-12-08
            </div>
            <div class="ui-form-item">
              <label class="ui-label">最高学历</label>
              研究生或以上
            </div>
            <div class="ui-form-item">
              <label class="ui-label">婚姻状况</label>
              已婚
            </div>
            <div class="ui-form-item">
              <label class="ui-label">居住地址</label>
              岳麓区软件大楼410
            </div>
            <div class="ui-form-item">
              <label class="ui-label">手机号码</label>
              158 **** 6173
            </div>
            <div class="ui-form-item">
              <label class="ui-label">邮箱地址</label>
              godfish@gmail.com
            </div>
            <div class="ui-form-item">
              <label class="ui-label">账户欠款</label>
              0元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">欠款罚金</label>
              0元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">账户净资产</label>
              10,000元
            </div>

            <div class="ui-form-item">
              <label class="ui-label">已赚总金额</label>
              10,000元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">平均年收益率</label>
              12%
            </div>
            <div class="ui-form-item">
              <label class="ui-label">已还利息总额</label>
              0元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">平均年利率</label>
              0%
            </div>
        </div>
       </form>
    </div>