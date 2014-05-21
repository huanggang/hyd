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
      <div class="grid_6 alpha">
        <p class="p20 pl40">
          <span class="guide-first-word">好</span>易贷(renrendai.com)是目前中国互联网金融中P2P信贷行业的领军企业，是一个以个人对个人小额借贷为主要产品，为借贷两端搭建的公平、透明、安全、高效的互联网金融服务平台。借款用户可以在好易贷上获得信用评级、发布借款请求来实现个人快捷的融资需要；理财用户可以把自己的部分闲余资金通过好易贷平台出借给信用良好有资金需求的个人，在获得有保障，高收益的理财回报的同时帮助了优质的借款人。
        </p>
      </div>
      <div class="grid_6 omega text-center">
        <img src="<?php print $image_path; ?>platform.png" alt="好易贷平台原理">
      </div>
    </div>
  </div>
  <div class="pg-guide-item dark">
    <h4 class="h4bg-green"><span>为什么选择好易贷</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha text-center">
        <img src="<?php print $image_path; ?>interest-compare.png" alt="好易贷理财12-14%的高收益">
      </div>
      <div class="grid_6 omega">
        <dl class="p20 pr40">
          <dt>12%-14%的高收益</dt>
          <dd>成为理财人后，加入优选理财计划或投资散标，预期12%-14%的年化收益轻松实现。</dd>
          <dt>理财“零”门槛</dt>
          <dd>只要您是18岁以上中国公民，最低50元就可以在好易贷进行理财。</dd>
        </dl>
      </div>
    </div>
    <div class="fn-clear">
      <div class="grid_6 alpha">
        <dl class="p20 pl40">
          <dt>100%本金保障计划</dt>
          <dd>所有理财用户的每笔出借资金均在好易贷的本金保障计划覆盖之内，一旦出现逾期坏账，好易贷通过风险备用金优先垫付，保证理财人的资金安全。</dd>
          <dt>资金灵活周转</dt>
          <dd>不用担心较长的资金锁定期，您可以进行债权转让，快速收回资金。</dd>
        </dl>
      </div>
      <div class="grid_6 omega text-center">
        <img class="mt30" src="<?php print $image_path; ?>loans.png" alt="100%本金保障计划，资金灵活周转">
      </div>
    </div>
  </div>
  <div class="pg-guide-item">
    <h4 class="h4bg-yellow"><span>好易贷的业绩</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha text-center performance">
        <div class="pl20">
          <img src="<?php print $image_path; ?>performance.png" alt="好易贷业绩">
          <p class="num-xxl performance-item performance-item-trade">总交易金额<em>23</em>亿元</p>
          <p class="num-l performance-item performance-item-interest">为用户赚取<em>11,910</em>万元</p>
          <p class="num-l performance-item performance-item-count">累计交易<em>182</em>万人次</p>
        </div>
      </div>
      <div class="grid_6 omega">
        <dl class="p20 pr40">
          <dt>总交易金额达到23亿元</dt>
          <dd>累计总交易额达到23亿元</dd>
          <dt>理财用户累计收益11,910万元</dt>
          <dd>累计帮助理财用户实现收益11,910万元，平均收益率高达13.6%</dd>
          <dt>累计交易182万人次</dt>
          <dd>网站从开展业务到现在交易次数达到182万人次</dd>
          <dt>服务遍及全国2,000多个城市</dt>
        </dl>
      </div>
    </div>
  </div>
  <div class="pg-guide-item dark">
    <h4 class="h4bg-cyanblue"><span>理财，就是如此简单</span></h4>
    <div class="fn-clear">
      <div class="grid_5 alpha">
        <div class="p20 pl40">
          <dl>
            <dt>简单3步，完成理财投资</dt>
            <dd>
              <p>第一步 完成注册成为理财人</p>
              <p>第二步 账户充值</p>
              <p>第三步 加入优选理财计划或投资散标</p>
              <p>三步走完，轻松赚取收益</p>
            </dd>
          </dl>
          <a class="ui-button ui-button-blue ui-button-mid" href="<?php print $base_url; ?>/lend" target="_blank">我要去理财</a>
        </div>
      </div>
      <div class="grid_7 omega text-center">
        <img class="mt40" src="<?php print $image_path; ?>steps-for-investing.png" alt="简单3步，完成理财投资">
      </div>
    </div>
  </div>
  <div class="pg-guide-item">
    <h4 class="h4bg-orange"><span>产品介绍</span></h4>
    <div class="fn-clear">
      <div class="grid_6 alpha text-center img-container">
        <img class="icon-plan" src="<?php print $image_path; ?>invest-product-plan.png" alt="优选理财计划">
        <img class="icon-loan" src="<?php print $image_path; ?>invest-product-loan.png" alt="散标投资列表">
        <img class="icon-transfer" src="<?php print $image_path; ?>invest-product-transfer.png" alt="债权转让列表">
      </div>
      <div class="grid_6 omega">
        <dl class="p20 pr30">
          <dt><a href="/financeplan/listPlan.action" target="_blank">加入优选</a></dt>
          <dd>加入优选理财计划，资金以用户认可的既定规则自动进行投标，用户每月的回款也会循环复利再投资，更安全，更便捷，更高效。</dd>
          <dt><a href="/lend/loanList.action" target="_blank">投资散标</a></dt>
          <dd>平台提供<a href="/help/invest.action#what-is-credit-loan" target="_blank">信用认证标</a>、<a href="/help/invest.action#what-is-organization-loan" target="_blank">机构担保标</a>、<a href="/help/invest.action#what-is-youxin-loan" target="_blank">实地认证标</a>等多类产品，用户可以根据借款人信用等级、利率、期限等信息，自选合适的借款标的，构建符合个人意愿的投资组合。</dd>
          <dt><a href="/transfer/transferList.action" target="_blank">债权转让</a></dt>
          <dd>通过好易贷债权转让平台，用户可以自行转让资产组合中符合条件的债权，也可以购买其他用户转让的债权，从而获得折让收益及借款标的后续收益。</dd>
        </dl>
      </div>
    </div>
  </div>
</div>