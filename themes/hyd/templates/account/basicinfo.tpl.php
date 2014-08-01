<?php
global $user;
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

$js_path = $base_url . '/' . $theme_path . '/js/';

drupal_add_css($theme_path . '/css/account.css');
drupal_add_css($theme_path . '/css/user.css');

drupal_add_js('var js_path=\'' . $js_path . '\'', 'inline');
drupal_add_js($theme_path . '/js/educations.js');
drupal_add_js($theme_path . '/js/provinces.js');
drupal_add_js($theme_path . '/js/marital_status.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/userbasic.js');

drupal_add_library('system', 'ui.dialog'); 

// the form to change user picture
$form = drupal_get_form('easyloan_changeimg_form');

$picture = theme('user_picture', array('account' =>$user));

?>
<div class="p20bs color-white-bg fn-clear" id="pg-account-user">
  <div class="fn-clear head"><div class="title fn-left">个人基础信息</div><div class="fn-right"><a id="modiForm" class="ui-button ui-button-mid ui-button-green">修改信息</a></div></div>
  <div class="user-picture-wrapper">
  <?php print $picture; ?>  
  <div id="uploadPhoto" class="uploadPhoto" style="display:none;">
    <form class="ui-form" method="post" enctype="multipart/form-data" 
        id="<?php print $form['form_id']["#value"];?>"
        action="<?php print $form["#action"];?>">
    <?php 
        print drupal_render($form['form_build_id']);
        print drupal_render($form['form_token']);
        print drupal_render($form['form_id']);
     ?>
       <div class="inputs">
         <div class="fn-clear selectFile" id="selectFile">
           <div id="filevalue" class="fn-left fileInput"></div>
           <div class="fn-left fileBt">选择文件</div>
           <input type="file" name="files[picture_upload]" id="edit-picture-upload" size="32">
         </div>
         <div class="info">
           <p>您可以上传<?php print variable_get('user_picture_dimensions'); ?>的JPG、GIF或PNG文件</p>
           <p>上传图片最大<?php print variable_get('user_picture_file_size');?>M</p>
         </div>
         <div class="bts">
           <input type="button" id="edit-submit" name="op" class="ui-button ui-button-mid ui-button-blue" value="上 传">
           <input type="reset" id="buttonClose" class="btClose ui-button ui-button-mid ui-button-gray" value="取 消">
         </div>
       </div>
     </form>
  </div>
  </div>
  <form enctype="multipart/form-data" class="ui-form" method="post" id="userInfoForm">
  <div class="inputs">
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>昵称</label>
        <span id='nickname'></span>
    </div>  
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>真实姓名</label>
      <span id='name'></span>
      <span class="pass fn-hide">已认证</span>
      <span class="icon-status noauth fn-hide"><a href="<?php print $base_url;?>/account_management/security">去认证</a></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>身份证号</label>
      <span id='ssn'></span>
      <span class="pass fn-hide">已认证</span>
      <span class="icon-status noauth fn-hide"><a href="<?php print $base_url;?>/account_management/security">去认证</a></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>手机号码</label>
      <span id='mobile'></span>
      <span class="pass fn-hide">已绑定</span>
      <span class="icon-status noauth fn-hide"><a href="<?php print $base_url;?>/account_management/security">去绑定</a></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>邮箱地址</label>
      <span id='email'></span>
      <span class="pass fn-hide">已绑定</span>
      <span class="icon-status noauth fn-hide"><a href="<?php print $base_url;?>/account_management/security">去绑定</a></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>性别</label>
      <span id='gender'></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>出生日期</label>
      <span id='dob'></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>最高学历</label>
        <select name="education" id="education">
          <option value="">请选择</option>
        </select>
      </div>
      <div class="ui-form-item">
        <label class="ui-label"><span class="ui-form-required">*</span>婚姻状况</label>
          <select name="marital" id="marital">
          <option value="">请选择</option>
        </select>
      </div>
      <div class="ui-form-item">
        <label class="ui-label"><span class="ui-form-required">*</span>所在省份</label>
        <select name="province" id="province">
          <option value="">请选择</option>
        </select>
      </div>
      <div class="ui-form-item">
        <label class="ui-label"><span class="ui-form-required">*</span>所在城市</label>
        <select name="city" id="city">
          <option value="">请选择</option>
        </select>
      </div>
      <div class="ui-form-item">
        <label class="ui-label">居住地址</label>
        <input class="ui-input w280" type="text" name="address" id="address" value="<?php print $user->basic['act_info_address'];?>">
      </div>
      <div class="ui-form-item">
        <input id="savebt" type="button" class="ui-button ui-button-green ui-button-mid" value="保 存">
      </div>
    </div>
   </form>
</div>