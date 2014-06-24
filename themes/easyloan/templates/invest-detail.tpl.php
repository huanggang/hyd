<?php
global $user;
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/details.css');
drupal_add_css($theme_path . '/css/details2.css');
drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/iconfont.css');

drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/repayment_methods.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/investment_view.js');
?>
<div id="pg-loan-invest" class="pg-details">
  <div id="loan-basic">
    <div class="container_12 mt10 color-white-bg" id="loan-basic-panel">
      <div class="ui-box-white-bg fn-clear">
        <div class="ui-box-title fn-clear">
          <h3 class="fn-left fn-text-overflow" id="title">(房产) 资金周转</h3>
        </div>
        <div class="p20 fn-clear">
          <div class="fn-left loaninfo">
            <div class="fn-clear pt10 mb25">
              <dl class="fn-left w270">
                <dt>借款总额 （元）</dt>
                <dd class="text-xxxl color-dark-text">￥<em id="amount">40,000</em></dd>
              </dl>
              <dl class="fn-left w180">
                <dt>年利率</dt>
                <dd class="text-xxl"><em class="text-xxxl color-dark-text" id="rate">11.00</em>%</dd>
              </dl>
              <dl class="fn-left w120">
                <dt>还款期限 （个月）</dt>
                <dd class="text-xxxl color-dark-text"><em id="duration">12</em></dd>
              </dl>
            </div>
            <ul>
              <li class="fn-clear">
                <span class="fn-left basic-label w70">还款方式</span>
                <span class="fn-left basic-value" id="repayment_method">一次性还本付息</span>
                <span class="fn-left basic-label mr30">发布日期</span>
                <span class="fn-left basic-value num last"><em id="created">2014-03-01</em></span>
              </li>
              <li class="fn-clear">
                <span class="fn-left basic-label w70">成立日期</span>
                <span class="fn-left basic-value num"><em id="start">2014-03-11</em></span>
                <span class="fn-left basic-label mr30">到期日期</span>
                <span class="fn-left basic-value num last"><em id="end">2014-08-11</em></span>
              </li>
              <li class="fn-clear">
                <span class="fn-left basic-label w70">投资起点金额</span>
                <span class="fn-left basic-value num"><em id="minimum">10,000</em> 元</span>
                <span class="fn-left basic-label mr30">追加投资起点金</span>
                <span class="fn-left basic-value num last"><em id="step">10,000</em> 元</span>
              </li>
              <li class="fn-clear" style="display:none" id="has_fine">
                <span class="fn-left basic-label w70">逾期日利率</span>
                <span class="fn-left basic-value num"><em id="fine_rate">1.00</em>%</span>
                <span class="fn-left basic-label mr30">逾期计算方式</span>
                <span class="fn-left basic-value last" id="fine_is_single">复利</span>
              </li>
              <li class="fn-clear" style="display:none" id="no_fine">
                <span class="fn-left basic-label w70">好易贷担保</span>
                <span class="fn-left basic-value">不逾期</span>
              </li>
              <li class="fn-clear basic-progress pt25" id="is_apply" style="display:none">
                <span class="fn-left basic-label w70">投标进度</span>
                <span>
                  <span class="fn-left basic-progress-bg">
                    <b style="width: 39%" class="basic-percent" id="apply_progress_1"></b>
                  </span>
                  <span class="fn-left basic-progress-value"><em id="apply_progress_2">39%</em></span>
                </span>
              </li>
              <li class="fn-clear" style="display:none" id="is_overdue">
                <span class="fn-left basic-label w70">支付罚金</span>
                <span class="fn-left basic-value num"><em id="fine">100.30</em> 元</span>
              </li>
            </ul>
            <div class="stamp">
              <em class="READY" style="display:none"></em>
              <em class="REPAYING" style="display:none"></em>
              <em class="OVERDUE" style="display:none"></em>
              <em class="CLOSED" style="display:none"></em>
            </div>
          </div>
          <div id="panel_invest" class="fn-right ui-box-gray-bg ui-term-box" style="display:none">
            <dl class="pd15">
              <dt>剩余金额（元）</dt>
              <dd class="num-xl mt6"><em data-amount="56650.0" id="invest_left" class="color-dark-text">￥56,650</em></dd>
            </dl>
            <div class="ui-term-content">
              <p class="ui-term-overage mb4">
                 <span class="clearfix"><span class="fn-left">账户余额</span> <em class="fn-right" id="invest_available"> <a href="/user/login">登录</a>后可见</em></span>
              </p>
              <form autocomplete="off" class="ui-term-form ui-form">
                <div class="ui-term-field invest">
                  <input type="text" class="ui-term-input ui-input ui-input-text" id="invest_amount">
                  <p class="ui-term-placeholder">输入投资金额</p>
                  <p class="ui-term-inputunit">元 <span class="ui-term-eq share"></span></p>
                  <p class="ui-term-hint">&nbsp;</p>
                  <p style="display: none;" class="ui-term-error" id="invest_error"></p>
                </div>
                <input type="button" id="invest_submit" class="ui-term-button ui-button ui-button-rect-mid ui-button-blue OPEN mb10" value="投资">
              </form>
            </div>
          </div>
          <div id="panel_ready" class="fn-right loan-status loan-ready" style="display:none">
            <div class="box"><em>满标用时</em><span id="ready_full_time" data-time="0天0时4分41秒">0时4分41秒</span></div>
            <div class="hr"></div>
            <div class="box"><em>加入人次</em><span class="investors" id="ready_investors">35</span></div>
          </div>
          <div id="panel_repaying" class="fn-right loan-status loan-repaying" style="display:none">
            <div class="box"><em>待还本息（元）</em><span id="repaying_amount_left">￥20,336</span></div>
            <div class="hr"></div>
            <div class="box"><em>剩余期数（个月）</em><span id="repaying_months_left">3</span></div>
            <div class="hr"></div>
            <div class="box"><em>下一合约还款日</em><span id="repaying_next_date">2014-07-17</span></div>
          </div>
          <div id="panel_overdue" class="fn-right loan-status loan-overdue" style="display:none">
            <div class="box"><em>待还欠款（元）</em><span id="overdue_amount">￥100,006</span></div>
            <div class="hr"></div>
            <div class="box"><em>待还罚金（元）</em><span id="overdue_fine">￥2,330</span></div>
            <div class="hr"></div>
            <div class="box"><em>待还本息（元）</em><span id="overdue_amount_left">￥20,336</span></div>
            <div class="hr"></div>
            <div class="box"><em>剩余期数（个月）</em><span id="overdue_months_left">3</span></div>
            <div class="hr"></div>
            <div class="box"><em>下一合约还款日</em><span id="overdue_next_date">2014-07-17</span></div>
          </div>
          <div id="panel_closed" class="fn-right loan-status loan-close" style="display:none">
            <p class="title">还清时间</p>
            <p class="date" id="closed_finished">2011-01-11</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="loan-details" class="mt20">
    <div class="container_12">
      <div class="ui-tab ui-tab-transparent" id="loan-tab">
        <ul class="fn-clear">
          <li class="ui-tab-item ui-tab-item-current" data-name="info">
            <a class="ui-tab-item-link">标的详情</a>
          </li>
          <li class="ui-tab-item " data-name="investments">
            <a class="ui-tab-item-link">投标记录</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="container_12 color-white-bg" id="loan-tab-content">
      <div class="ui-box-white-bg fn-clear">
        <div class="ui-tab-content ui-tab-content-current ui-tab-content-info" data-name="info">
          <?php if ($user->uid > 0){ ?>
            <div class="ui-tab-content-basic border-bottom p35">
              <h4 class="ui-tab-content-title color-dark-text">用户信息</h4>
              <ul class="ui-tab-list fn-clear">
                <li>
                  <span class="tab-list-label mr30">用户名</span>
                  <span class="tab-list-value" title="ZD7550080002413（男）">
                    <em id="borrower" class="fn-left fn-text-overflow" title="ZD7550080002413" style="width:120px">ZD7550080002413</em>
                    <em id="gender" class="fn-left ui-icon ui-icon-mid mt5 ui-icon-gender-male" title="男"></em>
                  </span>
                </li>
                <li>
                  <span class="tab-list-label mr30">年&nbsp;&nbsp;&nbsp;&nbsp;龄</span>
                  <span id="age" class="tab-list-value">44</span>
                </li>
                <li>
                  <span class="tab-list-label mr30">婚&nbsp;&nbsp;&nbsp;&nbsp;姻</span>
                  <span id="marital" class="tab-list-value">已婚</span>
                </li>
                <li>
                  <span class="tab-list-label mr30">学&nbsp;&nbsp;&nbsp;&nbsp;历</span>
                  <span id="education" class="tab-list-value">大专</span>
                </li>
                <li>
                  <span class="tab-list-label mr30">居住地</span>
                  <span id="living_place" class="tab-list-value">山东 德州</span>
                </li>
              </ul>
            </div>
          <?php } else { ?>
            <div class="ui-tab-content-basic border-bottom p35">
              <h4 class="ui-tab-content-title color-dark-text">用户信息</h4>
              <h4 class="auth-hint narrow">请 <a href="/user/login">登录</a> 或 <a href="/user/register">注册</a> 后查看</h4>
            </div>
          <?php } ?>

          <div class="ui-tab-content-auditoria border-bottom p35">
            <h4 class="ui-tab-content-title color-dark-text">审核状态</h4>
            <div class="details-verfication-list mt10 rrdcolor-dimgray-text" id="verification-container">
              <table class="ui-table ui-table-blue ui-table-auditoria">
                <thead>
                  <tr>
                    <th width="30%"><span class="pl100">审核项目</span></th>
                    <th width="27%"><span class="text-center">状态</span></th>
                    <th><span class="text-right pr145">通过日期</span></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="dark">
                    <td>
                      <div class="ui-td-bg pl100">信用报告</div>
                    </td>
                    <td class="text-center">
                      <div id="check_credit" class="ui-td-bg">
                        <i class="icon icon-circle-checked"></i>
                      </div>
                    </td>
                    <td class="text-right">
                      <div id="check_credit_date" class="ui-td-bg pr145">2014-02-28</div>
                    </td>
                  </tr>
                  <tr class="">
                    <td>
                      <div class="ui-td-bg pl100">身份认证</div>
                    </td>
                    <td class="text-center">
                      <div id="check_id" class="ui-td-bg">
                        <i class="icon icon-circle-checked"></i>
                      </div>
                    </td>
                    <td class="text-right">
                      <div id="check_id_date" class="ui-td-bg pr145">2014-02-28</div>
                    </td>
                  </tr>
                  <tr class="dark">
                    <td>
                      <div class="ui-td-bg pl100">抵押认证</div>
                    </td>
                    <td class="text-center">
                      <div id="check_mortgage" class="ui-td-bg">
                        <i class="icon icon-circle-checked"></i>
                      </div>
                    </td>
                    <td class="text-right">
                      <div id="check_mortgage_date" class="ui-td-bg pr145">2014-02-28</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <ul>
              <li>好易贷及其合作机构将始终秉持客观公正的原则，严控风险，最大程度的尽力确保借入者信息的真实性，但不保证审核信息100%无误。</li>
              <li>借入者若长期逾期，其个人信息将被公布。</li>
            </ul>
          </div>
          <div class="ui-tab-content-description border-bottom p35">
            <h4 class="ui-tab-content-title color-dark-text">借款描述</h4>
            <div id="purpose" class="ui-tab-list color-dark-text">
              深圳市证大速贷小额贷款股份有限公司（“证大速贷”）成立于2010年，公司注册资本1亿元人民币，第一大股东证大集团（0755.HK）是以专业金融综合投资及房地产开发经营为主业的大型企业集团，第二大股东长安国际信托股份有限公司主要从事资金信托、融资租赁、投资银行业务等金融业务。证大速贷主要致力于为小微企业，个体工商户和中低收入个人提供快速便捷、免抵押、免担保的小额信贷服务。公司自成立以来发展迅速，先后在深圳、北京、上海、广州等主要一二线城市开设近48家营业网点。此外，证大速贷与中国银行、国家开发银行、江苏银行方资产管理公司等金融机构建立长期战略合作伙伴关系，累计为四万名小微客户提供了微金融服务，资产质量始终位于同行前列。
            </div>
          </div>
          <div class="ui-tab-content-description border-bottom p35">
            <h4 class="ui-tab-content-title color-dark-text">抵押资产说明</h4>
            <div id="asset_description" class="ui-tab-list color-dark-text">
              深圳市证大速贷小额贷款股份有限公司（“证大速贷”）成立于2010年，公司注册资本1亿元人民币，第一大股东证大集团（0755.HK）是以专业金融综合投资及房地产开发经营为主业的大型企业集团，第二大股东长安国际信托股份有限公司主要从事资金信托、融资租赁、投资银行业务等金融业务。
            </div>
          </div>
        </div>

        <div class="ui-tab-content p35 fn-clear" data-name="investments">
          <?php if ($user->uid > 0){ ?>
            <div class="text-right text-big color-red-text mb10">
              <span class="mr50">加入人次 <em id="investor-count">35</em> 人</span>
              <span class="mr10">投标总额 <em>40,000</em>元</span>
            </div>
            <div class="ui-list ui-list-s">
              <table id="investors" class="ui-table ui-table-blue ui-table-auditoria">
                <thead>
                  <tr>
                    <th width="17%"><span class="pl60">序号</span></th>
                    <th width="25%"><span class="pl40">投标人</span></th>
                    <th width="23%"><span class="text-right pr70">投标金额</span></th>
                    <th><span class="text-right pr90">投标时间</span></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="dark ">
                    <td>
                      <div class="ui-td-bg pl60">1</div>
                    </td>
                    <td>
                      <div class="ui-td-bg pl40"><a href="/user/625858" target="blank" title="blackrule668">blackrule668</a></div>
                    </td>
                    <td class="text-right">
                      <div class="ui-td-bg pr70"><em>300.00</em>元</div>
                    </td>
                    <td class="text-right">
                      <div class="ui-td-bg pr90">2014-02-28 15:09</div>
                    </td>
                  </tr>
                  <tr class=" ">
                    <td>
                      <div class="ui-td-bg pl60">2</div>
                    </td>
                    <td>
                      <div class="ui-td-bg pl40"><a href="/user/477029" target="blank" title="aygjhenry">aygjhenry</a></div>
                    </td>
                    <td class="text-right">
                      <div class="ui-td-bg pr70"><em>50.00</em>元</div>
                    </td>
                    <td class="text-right">
                      <div class="ui-td-bg pr90">2014-02-28 15:09</div>
                    </td>
                  </tr>
                  <tr class="dark last">
                    <td>
                      <div class="ui-td-bg pl60">3</div>
                    </td>
                    <td>
                      <div class="ui-td-bg pl40"><a href="/user/476858" target="blank" title="yanronfs0fjks">yanronfs0fjks</a></div>
                    </td>
                    <td class="text-right">
                      <div class="ui-td-bg pr70"><em>100.00</em>元</div>
                    </td>
                    <td class="text-right">
                      <div class="ui-td-bg pr90">2014-02-28 15:10</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          <?php } else { ?>
            <h4 class="auth-hint">请 <a href="/user/login">登录</a> 或 <a href="/user/register">注册</a> 后查看</h4>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="ui-goTop" style="left: 1175.5px; display: none;"></div>
</div>