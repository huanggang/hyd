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
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/borrow_car.js');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <form enctype="multipart/form-data" class="ui-form" method="post" id="borrowForm" action="apply">
          <fieldset>
            <div class="loanboder">
            <legend>机动车抵押借款申请</legend>
            <div class="ui-form-item">
              <label class="ui-label">借款标题</label>
              <input class="ui-input" type="text" value="" name="title" id="title">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">机动车品牌</label>
              <input class="ui-input" type="text" value="" name="brand" id="brand">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">生产年份</label>
              <input class="ui-input" type="text" value="" name="year" id="year">
              年
            </div>
            <div class="ui-form-item">
              <label class="ui-label">车辆识别代码(车架号/VIN)</label>
              <input class="ui-input" type="text" value="" name="vin" id="vin">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">出厂日期</label>
              <input class="ui-input" type="text" value="" name="made" id="made">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">违章情况</label>
              <input class="ui-input" type="text" value="" name="violations" id="violations">
              次
            </div>
            <div class="ui-form-item">
              <label class="ui-label">登记日期</label>
              <input class="ui-input" type="text" value="" name="register" id="register">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">购车发票价格</label>
              <input class="ui-input" type="text" value="" name="price" id="price">
              元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">颜色</label>
              <input class="ui-input" type="text" value="" name="color" id="color">
            </div>
            <div class="ui-form-item">
              <label class="ui-label">车辆配置</label>
              <input class="ui-input" type="checkbox" value="" name="features" id="feature1">手动
              <input class="ui-input" type="checkbox" value="" name="features" id="feature2">自动
              <input class="ui-input" type="checkbox" value="" name="features" id="feature3">天窗
              <input class="ui-input" type="checkbox" value="" name="features" id="feature4">底盘升降
              <input class="ui-input" type="checkbox" value="" name="features" id="feature5">倒车雷达
              <input class="ui-input" type="checkbox" value="" name="features" id="feature6">导航
              <input class="ui-input" type="checkbox" value="" name="features" id="feature7">夜视系统
              <input class="ui-input" type="checkbox" value="" name="features" id="feature8">涡轮增压
            </div>
            <div class="ui-form-item">
              <label class="ui-label">行车里程</label>
              <input class="ui-input" type="text" value="" name="mileage" id="mileage">
              公里
            </div>
            <div class="ui-form-item">
              <label class="ui-label">过户次数</label>
              <input class="ui-input" type="text" value="" name="tranfers" id="tranfers">
              次
            </div>
            <div class="ui-form-item">
              <label class="ui-label">国产/进口</label>
              <select name="oversea" id="oversea">
                <option value="国产">
                  国产
                </option>
                <option value="进口">
                  进口
                </option>
              </select>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">车况</label>
              <select name="status" id="status">
                <option value="良好">
                  良好
                </option>
                <option value="事故">
                  事故
                </option>
                <option value="轻伤">
                  轻伤
                </option>
              </select>
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
              <input name="category" id="category" type="hidden" value="CAR">
              <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="立即申请">
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>