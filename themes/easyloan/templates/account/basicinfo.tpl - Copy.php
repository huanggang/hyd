<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/user.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $user;
$img_path = '../' . drupal_get_path('theme','easyloan') . '/images/default-avatar-96.png';
?>
<div class="p20bs color-white-bg fn-clear" id="pg-account-user">
  <div id="userInfoForm" class="fn-clear head"><div class="title fn-left">个人基础信息</div><div class="fn-right pr20"><a id="modiForm" class="ui-button ui-button-mid ui-button-green">修改信息</a></div></div>
  <form data-name="userbasic" enctype="multipart/form-data" class="ui-form" method="post" id="userInfoForm" style="display: none;">
  <div class="userphoto" id="userphoto">
    <a id="modUserPhoto" class="photo">
      <img src="<?php print $img_path; ?>">
    </a>
      <input name="avatar" id="modUserPhotoInput" type="hidden" value="">
  </div>
  <div class="inputs">
    <div class="ui-form-item">
      <label class="ui-label"><span class="ui-form-required">*</span>昵称</label>
              <?php print $user->name;?>
            </div>  
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>真实姓名</label>
              朱祖志
              <span class="icon-status pass">已认证</span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>身份证号</label>
              44**** **** **** ****
              <span class="icon-status pass">已认证</span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>手机号码</label>
              158 **** 6173
              <span class="icon-status pass">已绑定</span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>邮箱地址</label>
              <span class="icon-status noauth"><a href="/account/info!security.action">去绑定</a></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>性别</label>
              男
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>出生日期</label>
              1975-12-08
            </div>
          <div class="ui-form-item">
            <label class="ui-label"><span class="ui-form-required">*</span>最高学历</label>
             <select name="graduation" id="graduation">
              <option value="">请选择</option>
                <option value="高中或以下">
                  高中或以下
                </option>
                <option value="大专">
                  大专
                </option>
                <option value="本科">
                  本科
                </option>
                <option value="研究生或以上" selected="selected">
                  研究生或以上
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>婚姻状况</label>
              <em><input type="radio" value="MARRIED" name="marriage"> 已婚</em>
              <em><input type="radio" value="UNMARRIED" name="marriage" checked="checked"> 未婚</em>
              <em><input type="radio" value="DIVORCED" name="marriage"> 离异</em>
              <em><input type="radio" value="WIDOWED" name="marriage"> 丧偶</em>
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>所在省份</label>
              <input class="ui-input w280" type="text" name="province" id="province" value="湖南">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>所在城市</label>
              <input class="ui-input w280" type="text" name="city" id="city" value="湖南">
            </div>
            <div class="ui-form-item">
              <label class="ui-label"><span class="ui-form-required">*</span>居住地址</label>
              <input class="ui-input w280" type="text" name="address" id="address" value="岳麓区软件大楼410">
            </div>
            <div class="ui-form-item">
              <input id="savebt" type="submit" class="ui-button ui-button-green ui-button-mid" value="保 存">
            </div>  
        </div>
       </form>
       <form data-name="userbasic" enctype="multipart/form-data" class="ui-form" method="post" id="userInfoForm" action="/account/info!saveBasicInfo.action" novalidate="novalidate">
        <div class="userphoto" id="userphoto">
           <a id="modUserPhoto" class="photo" href="#">
            <img src="<?php print $img_path; ?>">
           </a>
        </div>
        <div class="inputs">
            <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>昵称</label>
                    <?php print $user->name;?>
                  </div>  
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>真实姓名</label>
                    朱祖志
                    <span class="icon-status pass">已认证</span>
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>身份证号</label>
                    44**** **** **** ****
                    <span class="icon-status pass">已认证</span>
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>手机号码</label>
                    158 **** 6173
                    <span class="icon-status pass">已绑定</span>
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>邮箱地址</label>
                    <span class="icon-status noauth"><a href="/account/info!security.action">去绑定</a></span>
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>性别</label>
                    男
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>出生日期</label>
                    1975-12-08
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>最高学历</label>
                   研究生或以上
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>婚姻状况</label>
                    <em> 未婚</em>
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>所在省</label>
                    湖南
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>所在市</label>
                    长沙
                  </div>
                  <div class="ui-form-item">
                    <label class="ui-label"><span class="ui-form-required">*</span>居住地址</label>
                    岳麓区软件大楼410
                  </div>
                  <div class="ui-form-item">
                  </div>  
        </div>
       </form>

    </div>