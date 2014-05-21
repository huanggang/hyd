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
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/borrow_estate.js');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <form enctype="multipart/form-data" class="ui-form" method="post" id="borrowForm" action="apply">
          <fieldset>
            <div class="loanboder">
            <legend>房产抵押申请信息填写</legend>
            <div class="ui-form-item">
              <label class="ui-label">借款标题</label>
              <input class="ui-input" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">房产坐落</label>
              <input class="ui-input" type="text" value="" name="address" id="address">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">建筑面积</label>
              <input class="ui-input" type="text" value="" name="area" id="area">
              平米
            </div>
            <div class="ui-form-item">
              <label class="ui-label">楼层</label>
              <input class="ui-input" type="text" value="" name="floor" id="floor">
              层,  共
              <input class="ui-input" type="text" value="" name="height" id="height">
              层
            </div>
            <div class="ui-form-item">
              <label class="ui-label">朝向</label>
              <select name="facing" id="facing">
                <option value="东">
                  东
                </option>
                <option value="南">
                  南
                </option>
                <option value="西">
                  西
                </option>
                <option value="北">
                  北
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">建成年份</label>
              <input class="ui-input" type="text" value="" name="year" id="year">
              年
            </div>
            <div class="ui-form-item">
              <label class="ui-label">实际用途</label>
              <input class="ui-input" type="text" value="" name="usage" id="usage">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">银行贷款</label>
              <select name="has_loan" id="has_loan">
                <option value="1">
                  有
                </option>
                <option value="0">
                  无
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">房产证</label>
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
              <input name="category" id="category" type="hidden" value="ESTATE">
              <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="立即申请">
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>