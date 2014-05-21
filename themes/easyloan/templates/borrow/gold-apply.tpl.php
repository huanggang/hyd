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
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/borrow_gold.js');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <form enctype="multipart/form-data" class="ui-form" method="post" id="borrowForm" action="apply">
          <fieldset>
            <div class="loanboder">
            <legend>黄金抵押借款申请</legend>
            <div class="ui-form-item">
              <label class="ui-label">借款标题</label>
              <input class="ui-input" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">物品名称</label>
              <input class="ui-input" type="text" value="" name="name" id="name">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">重量</label>
              <input class="ui-input" type="text" value="" name="weight" id="weight">
              克
            </div>
            <div class="ui-form-item">
              <label class="ui-label">含量</label>
              <input class="ui-input" type="text" value="" name="purity" id="purity">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">来源凭证</label>
              <select name="has_certificate" id="has_certificate">
                <option value="1">
                  有
                </option>
                <option value="0">
                  无
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">计划用款</label>
              <input class="ui-input" type="text" value="" name="amount" id="amount">元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">计划用款时间</label>
              <input class="ui-input" type="text" value="" name="duration" id="duration">月
            </div>
            <div class="ui-form-item">
              <label class="ui-label">借款描述</label>
              <textarea class="ui-textarea" name="purpose" id="purpose" rows="6"></textarea>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">抵押资产说明</label>
              <textarea class="ui-textarea" name="description" id="description" rows="6"></textarea>
            </div>
            </div>
            <div class="ui-form-item">
              <input name="category" id="category" type="hidden" value="GOLD">
              <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="立即申请">
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>