<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/loan.css');

drupal_add_js($theme_path . '/js/facing.js');
drupal_add_js($theme_path . '/js/vehicle_features.js');
drupal_add_js($theme_path . '/js/vehicle_status.js');
drupal_add_js($theme_path . '/js/application_status.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/loanapp_view.js');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <div class="loanboder">
          <legend><span id="category"></span>借款申请</legend>
          <div class="ui-form-item">
            <label class="ui-label">借款标题</label>
            <span id="title"></span>
          </div>
          <div id="category-1" style="display:none">
            <div class="ui-form-item">
              <label class="ui-label">房产坐落</label>
              <span id="address-1"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">建筑面积</label>
              <span id="area-1"></span> 平米
            </div>
            <div class="ui-form-item">
              <label class="ui-label">楼层</label>
              <span id="floor-1"></span>/<span id="height-1"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">朝向</label>
              <span id="facing-1"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">建成年份</label>
              <span id="year-1"></span> 年
            </div>
            <div class="ui-form-item">
              <label class="ui-label">实际用途</label>
              <span id="usage-1"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">银行贷款</label>
              <span id="has_loan-1"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">房产证</label>
              <span id="certificate-1"></span>
            </div>
          </div>
          <div id="category-2" style="display:none">
            <div class="ui-form-item">
              <label class="ui-label">机动车品牌</label>
              <span id="brand-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">生产年份</label>
              <span id="year-2"></span> 年
            </div>
            <div class="ui-form-item">
              <label class="ui-label">车辆识别代码</label>
              <span id="vin-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">出厂日期</label>
              <span id="made-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">违章情况</label>
              <span id="violations-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">登记日期</label>
              <span id="register-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">购车发票价格</label>
              <span id="price-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">颜色</label>
              <span id="color-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">车辆配置</label>
              <span id="features-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">行车里程</label>
              <span id="mileage-2"></span> 公里
            </div>
            <div class="ui-form-item">
              <label class="ui-label">过户次数</label>
              <span id="transfers-2"></span> 次
            </div>
            <div class="ui-form-item">
              <label class="ui-label">国产/进口</label>
              <span id="oversea-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">车况</label>
              <span id="status-2"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">来源凭证</label>
              <span id="certificate-2"></span>
            </div>
          </div>
          <div id="category-3" style="display:none">
            <div class="ui-form-item">
              <label class="ui-label">物品名称</label>
              <span id="name-3"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">重量</label>
              <span id="weight-3"></span> 克
            </div>
            <div class="ui-form-item">
              <label class="ui-label">含量</label>
              <span id="purity-3"></span> %
            </div>
            <div class="ui-form-item">
              <label class="ui-label">来源凭证</label>
              <span id="certificate-3"></span>
            </div>
          </div>
          <div id="category-4" style="display:none">
            <div class="ui-form-item">
              <label class="ui-label">工作单位</label>
              <span id="organization-4"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">职务</label>
              <span id="position-4"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">现单位工龄</label>
              <span id="years-4"></span> 年，<span id="months-4"></span> 月
            </div>
            <div class="ui-form-item">
              <label class="ui-label">平均月收入</label>
              <span id="income-4"></span>
            </div>
          </div>
          <div id="category-5" style="display:none">
            <div class="ui-form-item">
              <label class="ui-label">物品名称</label>
              <span id="name-5"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">购买日期</label>
              <span id="bought-5"></span>
            </div>
            <div class="ui-form-item">
              <label class="ui-label">购买价格</label>
              <span id="price-5"></span> 元
            </div>
            <div class="ui-form-item">
              <label class="ui-label">来源凭证</label>
              <span id="certificate-5"></span>
            </div>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">计划用款</label>
            <span id="amount"></span> 元
          </div>
          <div class="ui-form-item">
            <label class="ui-label">计划用款时间</label>
            <span id="duration"></span> 个月
          </div>
          <div class="ui-form-item">
            <label class="ui-label">借款描述</label>
            <span id="purpose"></span>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">抵押资产说明</label>
            <span id="asset_description"></span>
          </div>
          <div class="ui-form-item">
            <label class="ui-label">申请状态</label>
            <span id="status"></span>
          </div>
          <div class="ui-form-item" id="is_loaned-div">
            <label class="ui-label">是否放款</label>
            <span id="is_loaned"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>