<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/loan.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/jquery.validate.min.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/borrow_credit.js');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <form enctype="multipart/form-data" class="ui-form" method="post" id="borrowForm" action="apply">
          <fieldset>
            <div class="loanboder">
            <legend>信用贷借款申请</legend>
            <div class="ui-form-item">
              <label class="ui-label">借款标题</label>
              <input class="ui-input" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label required">工作单位</label>
              <input class="ui-input" type="text" value="" name="company" id="company">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">现单位工龄</label>
              <input class="ui-input" type="text" value="" name="year" id="year">年
              <input class="ui-input" type="text" value="" name="month" id="month">月
            </div>
            <div class="ui-form-item">
              <label class="ui-label">平均月收入</label>
              <input class="ui-input" type="text" value="" name="income" id="income">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">工作凭证</label>
              <select name="certificate" id="certificate">
                <option value="无">
                  无
                </option>
                <option value="有">
                  有
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">计划用款</label>
              <input class="ui-input" type="text" value="" name="amount" id="amount"> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">计划用款时间</label>
              <input class="ui-input" type="text" value="" name="duration" id="duration"> 个月
            </div>
            <div class="ui-form-item">
              <label class="ui-label">借款详情</label>
              <textarea class="ui-textarea" name="purpose" id="purpose" rows="6"></textarea>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">信用说明</label>
              <textarea class="ui-textarea" name="description" id="description" rows="6"></textarea>
            </div>
            </div>
            <div class="ui-form-item">
              <input name="category" id="category" type="hidden" value="CAR">
              <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="立即申请">
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>