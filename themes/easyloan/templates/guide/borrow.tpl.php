<?php
/**
 * @file
 * Forget password
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/guide.css');
global $base_url;
$image_path = $base_url . '/sites/all/themes/easyloan/images/';

?>
<div class="pg-guide-info mt20">
  <div class="pg-guide-item">
    <h4 class="h4bg-bule"><span>什么是好易贷</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha text-center">
        <img src="<?php print $image_path; ?>platform.png" alt="好易贷平台原理">
      </div>
      <div class="grid_6 omega">
        <p class="p20 pr40">
          <span class="guide-first-word">好</span>易贷(easyloan.com)是目前中国互联网金融中P2P信贷行业的领军企业，是一个以个人对个人小额借贷为主要产品，为借贷两端搭建的公平、透明、安全、高效的互联网金融服务平台。借款用户可以在好易贷上获得信用评级、发布借款请求来实现个人快捷的融资需要；理财用户可以把自己的部分闲余资金通过好易贷平台出借给信用良好有资金需求的个人，在获得有保障，高收益的理财回报的同时帮助了优质的借款人。
        </p>
      </div>
    </div>
  </div>
  <div class="pg-guide-item dark">
    <h4 class="h4bg-green"><span>为什么选择好易贷</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha">
        <dl class="p20 pl40">
          <dt>无须任何抵押、担保，低门槛，纯信用借款</dt>
          <dd>好易贷为借款人提供纯信用借款，无须任何抵押或担保，只需要提供必要申请材料并通过审核，即可获得最高50万的借款额度。</dd>
          <dt>用户自主选择产品</dt>
          <dd>好易贷面向各类借款用户，设计了工薪贷、生意贷、网商贷三种产品，用户可以根据自身情况选择适合的借款产品。</dd>
        </dl>
      </div>
      <div class="grid_6 omega text-center">
        <img class="mt40" src="<?php print $image_path; ?>fast.png" alt="信用借款，无需抵押，快速获得借款">
      </div>
    </div>
    <div class="fn-clear">
      <div class="grid_6 alpha text-center">
        <img class="mt40" src="<?php print $image_path; ?>safe.png" alt="最便捷的借款方式，最安全的平台保障" style="margin-top: -15px;">
      </div>
      <div class="grid_6 omega">
        <dl class="p20 pr40">
          <dt>全程在线操作，最便捷的借款方式</dt>
          <dd>无需出门，提交材料、审核、放款全程互联网操作，键盘加鼠标轻松搞定，7*24的互联网金融服务。</dd>
          <dt>最安全的平台保障</dt>
          <dd>我们采用业界最先进的加密技术，对您的注册信息、账户信息进行加密处理，好易贷绝不会以任何形式将这些信息透露给第三方。</dd>
        </dl>
      </div>
    </div>
  </div>
  <div class="pg-guide-item">
    <h4 class="h4bg-yellow"><span>好易贷的业绩</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha">
        <dl class="p20 pl40">
          <dt>总交易金额达到23亿元</dt>
          <dd>累计总交易额达到23亿元</dd>
          <dt>累计交易184万人次</dt>
          <dd>网站从开展业务到现在交易次数达到184万人次</dd>
          <dt>借款用户平均借款用时2.89天</dt>
          <!-- <dd>TODO</dd> -->
          <dt>服务遍及全国2,000多个城市</dt>
        </dl>
      </div>
      <div class="grid_6 omega text-center performance">
        <div class="pr20">
          <img src="<?php print $image_path; ?>performance.png" alt="好易贷业绩">
          <p class="num-xxl performance-item borrow performance-item-trade">总交易金额<em>23</em>亿元</p>
          <p class="num-l performance-item borrow performance-item-interest">借款用户平均借款用时<em>2.89</em>天</p>
          <p class="num-l performance-item borrow performance-item-count">累计交易<em>184</em>万人次</p>
        </div>
      </div>
    </div>
  </div>
  <div class="pg-guide-item dark">
    <h4 class="h4bg-cyanblue"><span>借款，从未如此轻松</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha text-center">
        <img src="<?php print $image_path; ?>steps-for-borrowing.png" alt="轻松借款，只需4步" class="text-xl">
      </div>
      <div class="grid_6 omega">
        <div class="p20 pr40">
          <dl>
            <dt>轻松借款，只需4步</dt>
            <dd>
              <p>第一步 注册成为好易贷用户，完成身份认证</p>
              <p>第二步 选择借款产品发起申请</p>
              <p>第三步 上传必要申请材料</p>
              <p>第四步 通过审核后开始筹标</p>
              <p>满标后，借款完成立刻放款，之后您只需每月还款即可</p>
            </dd>
          </dl>
          <a class="ui-button ui-button-blue ui-button-mid" href="<?php print $base_url; ?>borrow" target="_blank">我要去借款</a>
        </div>
      </div>
    </div>
  </div>
  <div class="pg-guide-item">
    <h4 class="h4bg-orange"><span>产品介绍</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha">
        <dl class="p20 pl40">
          <dt>工薪贷</dt>
          <dd>工薪贷是好易贷为工薪阶层量身定制的一款借款产品。帮助您满足装修，买车以及个人消费等需求，提高生活品质。</dd>
          <dt>生意贷</dt>
          <dd>生意贷是好易贷为私营业主打造的一款借款产品。相比银行贷款产品，它有申请方便，门槛低，借款审核和筹款周期短等特点。帮助您的公司解决燃眉之急。</dd>
          <dt>网商贷</dt>
          <dd>网商贷是好易贷为淘宝，天猫，京东等网商专门定制的一款借款产品。网商贷无需上传过多的申请材料，使您足不出户就能得到周转资金。</dd>
        </dl>
      </div>
      <div class="grid_6 omega text-center img-container">
        <img class="icon-work" src="<?php print $image_path; ?>borrow-product-work.png" alt="工薪贷">
        <img class="icon-biz" src="<?php print $image_path; ?>borrow-product-biz.png" alt="生意贷">
        <img class="icon-ecomm" src="<?php print $image_path; ?>borrow-product-ecomm.png" alt="网商贷">
      </div>
    </div>
  </div>
</div>