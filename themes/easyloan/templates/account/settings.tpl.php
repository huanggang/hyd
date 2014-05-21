<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $user;
?>
<div id="pg-account-settings" class="pg-account p20bs color-white-bg fn-clear">
<form id="settingForm" name="settingForm" action="/account/comm!saveNotificationSetting.action" method="post">
  <font face="Arial, sans-serif">
      <input type="hidden" value="" name="security_session">
      <input type="hidden" value="1396410232441" name="timestamp">
  </font>
  <div class="tables">
      <div class="title">借款人</div>
      <table>
        <tbody><tr class="odd">
            <td width="34%">借款操作
            </td>
            <td width="34%">
                电子邮件
            </td>
            <td width="33%">
                短信
            </td>
        </tr>
        <tr class="even">
            <td>
                还款前7天
            </td>
            <td>
                <input type="checkbox" name="mail_asked" value="true" checked="checked" id="settingForm_mail_asked"><input type="hidden" id="__checkbox_settingForm_mail_asked" name="__checkbox_mail_asked" value="true">
            </td>
            <td>
                <input type="checkbox" name="innerMail_asked" value="true" id="settingForm_innerMail_asked"><input type="hidden" id="__checkbox_settingForm_innerMail_asked" name="__checkbox_innerMail_asked" value="true">
            </td>
        </tr>
        <tr class="odd">
            <td>
                还款前3天
            </td>
            <td>
                <input type="checkbox" name="mail_bid" value="true" id="settingForm_mail_bid"><input type="hidden" id="__checkbox_settingForm_mail_bid" name="__checkbox_mail_bid" value="true">
            </td>
            <td>
                <input type="checkbox" name="innerMail_bid" value="true" id="settingForm_innerMail_bid"><input type="hidden" id="__checkbox_settingForm_innerMail_bid" name="__checkbox_innerMail_bid" value="true">
            </td>
        </tr>
        <tr class="even">
            <td>
                还款逾期（每天）
            </td>
            <td>
                <input type="checkbox" name="mail_myFail" value="true" checked="checked" id="settingForm_mail_myFail"><input type="hidden" id="__checkbox_settingForm_mail_myFail" name="__checkbox_mail_myFail" value="true">
            </td>
            <td>
                <input type="checkbox" name="innerMail_myFail" value="true" id="settingForm_innerMail_myFail"><input type="hidden" id="__checkbox_settingForm_innerMail_myFail" name="__checkbox_innerMail_myFail" value="true">
            </td>
        </tr>
      </tbody></table>
     </div>
     <div class="tables">
        <div class="title">投资人</div>
        <table>
          <tbody>
            <tr class="odd">
                <td width="34%">投标操作</td>
                <td width="34%">电子邮件</td>
                <td width="33%">短信</td>
            </tr>
            <tr class="even">
                <td>投资到期</td> 
                <td>
                    <input type="checkbox" name="mail_bidSuccess" value="true" checked="checked" id="settingForm_mail_bidSuccess"><input type="hidden" id="__checkbox_settingForm_mail_bidSuccess" name="__checkbox_mail_bidSuccess" value="true">
                </td>
                <td>
                    <input type="checkbox" name="innerMail_bidSuccess" value="true" id="settingForm_innerMail_bidSuccess"><input type="hidden" id="__checkbox_settingForm_innerMail_bidSuccess" name="__checkbox_innerMail_bidSuccess" value="true">
                </td>
            </tr>
            <tr class="odd">
                <td>成功提现</td>
                <td>
                    <input type="checkbox" name="mail_fail" value="true" id="settingForm_mail_fail"><input type="hidden" id="__checkbox_settingForm_mail_fail" name="__checkbox_mail_fail" value="true">
                </td>
                <td>
                    <input type="checkbox" name="innerMail_fail" value="true" checked="checked" id="settingForm_innerMail_fail"><input type="hidden" id="__checkbox_settingForm_innerMail_fail" name="__checkbox_innerMail_fail" value="true">
                </td>
            </tr>
          </tbody>
        </table>
       </div>
      <div class="bts">
        <button id="subbt" class="ui-button ui-button-mid ui-button-green" type="submit">保存设置</button>
      </div>
    </form>
  </div>