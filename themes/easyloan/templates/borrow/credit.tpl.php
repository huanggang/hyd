<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
global $user;

drupal_add_css(drupal_get_path('theme','easyloan') . '/css/prod.css');
?>
<div id="pg-borrow-prod">
    <div class="container_12">
      <div class="grid_12">
        <div class="info-list">
          <h1 class="h3 bg-green">信用贷款</h1> 

          <div class="info-list-condition border-bt">
            <h2 class="h4 mb15">申请条件</h2>
            <ul class="ui-list-disc">
              <li><i></i>22-55周岁的中国公民</li>
              <li><i></i>在现单位工作满3个月</li>
              <li><i></i>月收入2000以上</li>
            </ul>
            <div class="review-button">
              <a href="<?php if($user->uid > 0) print "credit/apply"; else print "/user/login"; ?>" class="ui-button ui-button-green ui-button-mid">立即申请</a>
            </div>
          </div>
          <div class="info-list-way border-bt">
            <h2 class="h4 mb15">借款方式</h2>
            <ul>
              <li>借款额度： 3,000-500,000</li>
              <li>借款期限： 3、6、9、12、18、24个月</li>
              <li>借款年利率： 10%-24%</li>
              <li>还款方式： 等额本息，每月还款</li>
              <li>逾期日利率（30日及内、31日及以上）</li>
              <li>逾期日利率计算方式（单利、复利）</li>
              <li>审核方式： 方式1，方式2</li>
              <li>审核时间： 1-3个工作日</li>
            </ul>
          </div>
          <div class="info-list-fee border-bt">
            <h2 class="h4 mb15">费用说明</h2>
            <ul class="ui-list-disc">
              <li>
                <dl>
                  <dt><i></i>成交服务费</dt>
                  <dd>用户成功借款后按照评定的信用等级会一次性的从所得借款中扣除一定的比例（0%-5%）作为成交服务费，该服务费将进入人人贷平台的风险备用金账户，专项用于人人贷的本金保障计划。</dd>
                </dl>
              </li>
              <li>
                <dl>
                  <dt><i></i>账户管理费</dt>
                  <dd>人人贷将按照借款人的借款期限，每月向借款人收取其借款本金的0.3%作为借款管理费。</dd>
                </dl>
              </li>
            </ul>
          </div>
          <div class="info-list-material">
            <h2 class="h4 mb15">必要申请材料</h2>
            <ul class="ui-list-disc">
              <li><i></i>身份证<a class="ui-button ui-button-mid ui-list-invest-button" target="_blank" href="#">查看示例</a></li>
              <li><i></i>个人征信报告（可去当地人民银行打印）<a class="ui-button ui-button-mid ui-list-invest-button" target="_blank" href="#">查看示例</a></li>
              <li><i></i>带公司公章的劳动合同或工作证明<a class="ui-button ui-button-mid ui-list-invest-button" target="_blank" href="#">查看示例</a></li>
              <li><i></i>近3个月工资卡银行流水<a class="ui-button ui-button-mid ui-list-invest-button" target="_blank" href="#">查看示例</a></li>
            </ul>
          </div>
          <div class="review-button">
            <a href="<?php if($user->uid > 0) print "credit/apply"; else print "/user/login"; ?>" class="ui-button ui-button-green ui-button-mid">立即申请</a>
          </div>
        </div>
      </div>
    </div>  
  </div>