<?php
global $user;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/account.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/notices.js');
?>
<div id="pg-account-settings" class="pg-account p20bs color-white-bg fn-clear">
  <div class="tables">
    <div class="title">借款人</div>
    <table>
      <tbody>
        <tr class="odd">
          <td width="34%">借款操作</td>
          <td width="34%">电子邮件</td>
          <td width="33%">短信</td>
        </tr>
        <tr class="even">
          <td>还款前7天</td>
          <td>
            <input type="checkbox" name="mail_7" id="mail_7">
          </td>
          <td>
            <input type="checkbox" name="sm_7" id="sm_7">
          </td>
        </tr>
        <tr class="odd">
          <td>还款前3天</td>
          <td>
            <input type="checkbox" name="mail_3" id="mail_3">
          </td>
          <td>
            <input type="checkbox" name="sm_3" id="sm_3">
          </td>
        </tr>
        <tr class="even">
          <td>还款逾期（每天）</td>
          <td>
            <input type="checkbox" name="mail_1" id="mail_1">
          </td>
          <td>
            <input type="checkbox" name="sm_1" id="sm_1">
          </td>
        </tr>
      </tbody>
    </table>
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
            <input type="checkbox" name="mail_inv" id="mail_inv">
          </td>
          <td>
            <input type="checkbox" name="sm_inv" id="sm_inv">
          </td>
        </tr>
        <tr class="odd">
          <td>成功提现</td>
          <td>
            <input type="checkbox" name="mail_wd" id="mail_wd">
          </td>
          <td>
            <input type="checkbox" name="sm_wd" id="sm_wd">
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="bts">
    <button id="subbt" class="ui-button ui-button-mid ui-button-green">保存设置</button>
  </div>
</div>