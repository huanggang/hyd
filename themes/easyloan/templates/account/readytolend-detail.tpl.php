<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $base_url;
?>
<div class="loanapp loanapp p20bs color-white-bg">
        <form data-name="loaninfo" enctype="multipart/form-data" class="ui-form" method="post" id="borrowForm" action="/borrow/loan.action" novalidate="novalidate">
          <fieldset>
            <div class="loanboder">
            <h3 class="text-xl">审定放款信息填写</h3>
            <div class="ui-form-item mt10">
              <label class="ui-label">借款标题</label>借钱买车
            </div>
            <div class="ui-form-item">
              <label class="ui-label">借款人</label>王岐山
            </div>
            <div class="ui-form-item">
              <label class="ui-label">抵押类型</label>房屋商铺抵押
            </div>
            <div class="ui-form-item">
              <label class="ui-label">计划用款</label>10,0000元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">计划用款时间</label>2014-08-08
            </div>
            <div class="ui-form-item">
              <label class="ui-label">申请日期</label>360天
            </div>
            <hr />
            <div class="ui-form-item mt20">
              <label class="ui-label">借款金额</label>
              <input class="ui-input" type="text" value="" name="borrowTitle" id="borrowTitle">元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">年利率</label>
              <input class="ui-input" type="text" value="" name="borrowTitle" id="borrowTitle">%
            </div>
            <div class="ui-form-item">
              <label class="ui-label">还款方式</label>
              <select name="borrowType" id="borrowType">
                <option value="东">
                  先息后本月头支付
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">借款日期</label>
              <input class="ui-input" type="text" value="" name="borrowTitle" id="borrowTitle">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">还款日期</label>
              <input class="ui-input" type="text" value="" name="borrowTitle" id="borrowTitle">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">借款期限</label>360天
            </div>
            <div class="ui-form-item">
              <label class="ui-label">逾期日利率</label>
              <input class="ui-input" type="text" value="" name="borrowAmount" id="borrowAmount">%
            </div>
            <div class="ui-form-item">
              <label class="ui-label">逾期日利率计算方式</label>
              <select name="borrowType" id="borrowType">
                <option value="单利">
                  单利
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <input name="loanProductType" id="loanProductType" type="hidden" value="RRGXD">
              <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="审定放款">
            </div>
          </fieldset>
        </form>
      </div>