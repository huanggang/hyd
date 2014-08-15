<?php
global $user;
global $base_url;

$authenticated = $user->uid > 0 ? 1 : 0;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/details.css');
drupal_add_css($theme_path . '/css/details2.css');
drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/iconfont.css');

$js_path = $base_url . '/' . $theme_path . '/js/';
drupal_add_js('var js_path=\'' . $js_path . '\';var authenticated=' . $authenticated, 'inline');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/repayment_methods.js');
drupal_add_js($theme_path . '/js/marital_status.js');
drupal_add_js($theme_path . '/js/educations.js');
drupal_add_js($theme_path . '/js/provinces.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/investment_view.js');
?>
<div id="pg-loan-invest" class="pg-details">
  <div id="loan-basic">
    <div class="container_12 mt10 color-white-bg" id="loan-basic-panel">
      <div class="ui-box-white-bg fn-clear">
        <div class="ui-box-title fn-clear">
          <h3 class="fn-left fn-text-overflow" id="title"></h3>
        </div>
        <div class="p20 fn-clear">
          <div class="fn-left loaninfo">
            <div class="fn-clear pt10 mb25">
              <dl class="fn-left w270">
                <dt>借款总额 （元）</dt>
                <dd class="text-xxxl color-dark-text">￥<em id="amount"></em></dd>
              </dl>
              <dl class="fn-left w180">
                <dt>年利率</dt>
                <dd class="text-xxl"><em class="text-xxxl color-dark-text" id="rate"></em>%</dd>
              </dl>
              <dl class="fn-left w120">
                <dt>还款期限 （个月）</dt>
                <dd class="text-xxxl color-dark-text"><em id="duration"></em></dd>
              </dl>
            </div>
            <ul>
              <li class="fn-clear">
                <span class="fn-left basic-label w70">还款方式</span>
                <span class="fn-left basic-value" id="repayment_method"></span>
                <span class="fn-left basic-label mr30">发布日期</span>
                <span class="fn-left basic-value num last"><em id="created"></em></span>
              </li>
              <li class="fn-clear">
                <span class="fn-left basic-label w70">成立日期</span>
                <span class="fn-left basic-value num"><em id="start"></em></span>
                <span class="fn-left basic-label mr30">到期日期</span>
                <span class="fn-left basic-value num last"><em id="end"></em></span>
              </li>
              <li class="fn-clear">
                <span class="fn-left basic-label w70">投资起点金额</span>
                <span class="fn-left basic-value num"><em id="minimum"></em> 元</span>
                <span class="fn-left basic-label mr30">追加投资起点金</span>
                <span class="fn-left basic-value num last"><em id="step"></em> 元</span>
              </li>
              <li class="fn-clear" style="display:none" id="has_fine">
                <span class="fn-left basic-label w70">逾期日利率</span>
                <span class="fn-left basic-value num"><em id="fine_rate"></em>%</span>
                <span class="fn-left basic-label mr30">逾期计算方式</span>
                <span class="fn-left basic-value last" id="fine_is_single"></span>
              </li>
              <li class="fn-clear" style="display:none" id="no_fine">
                <span class="fn-left basic-label w70">好易贷担保</span>
                <span class="fn-left basic-value">不逾期</span>
              </li>
              <li class="fn-clear basic-progress pt25" id="is_apply" style="display:none">
                <span class="fn-left basic-label w70">投标进度</span>
                <span>
                  <span class="fn-left basic-progress-bg">
                    <b style="" class="basic-percent" id="apply_progress_1"></b>
                  </span>
                  <span class="fn-left basic-progress-value"><em id="apply_progress_2"></em></span>
                </span>
              </li>
              <li class="fn-clear" style="display:none" id="has_overdue">
                <span class="fn-left basic-label w70">支付罚金</span>
                <span class="fn-left basic-value num"><em id="fine"></em> 元</span>
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
              <dd class="num-xl mt6"><em data-amount="" id="invest_left" class="color-dark-text"></em></dd>
            </dl>
            <div class="ui-term-content">
              <p class="ui-term-overage mb4">
                 <span class="clearfix"><span class="fn-left">账户余额（元）</span>
                  <?php if ($user->uid > 0){ ?>
                    <em class="fn-right" id="invest_available"></em>
                  <?php } else { ?>
                    <em class="fn-right"> <a href="/user/login">登录</a>后可见</em>
                  <?php } ?>
                  </span>
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
            <div class="box"><em>待还本息（元）</em><span id="ready_amount_total"></span></div>
            <div class="hr"></div>
            <div class="box"><em>还款次数（次）</em><span id="ready_months_total"></span></div>
            <div class="hr"></div>
            <div class="box"><em>加入人次</em>
              <?php if ($user->uid > 0){ ?>
                <span class="investors" id="ready_investors"></span>
              <?php } else { ?>
                <em class="investors"> <a href="/user/login">登录</a>后可见</em>
              <?php } ?>
            </div>
          </div>
          <div id="panel_repaying" class="fn-right loan-status loan-repaying" style="display:none">
            <div class="box"><em>待还本息（元）</em><span id="repaying_amount_left"></span></div>
            <div class="hr"></div>
            <div class="box"><em>剩余期数（次）</em><span id="repaying_months_left"></span></div>
            <div class="hr"></div>
            <div class="box"><em>下一合约还款日</em><span id="repaying_next_date"></span></div>
          </div>
          <div id="panel_overdue" class="fn-right loan-status loan-overdue" style="display:none">
            <div class="box"><em>待还欠款（元）</em><span id="overdue_amount"></span></div>
            <div class="hr"></div>
            <div class="box"><em>待还罚金（元）</em><span id="overdue_fine"></span></div>
            <div class="hr"></div>
            <div class="box"><em>待还本息（元）</em><span id="overdue_amount_left"></span></div>
            <div class="hr"></div>
            <div class="box"><em>剩余期数（次）</em><span id="overdue_months_left"></span></div>
            <div class="hr"></div>
            <div class="box"><em>下一合约还款日</em><span id="overdue_next_date"></span></div>
          </div>
          <div id="panel_closed" class="fn-right loan-status loan-close" style="display:none">
            <p class="title">还清时间</p>
            <p class="date" id="closed_finished"></p>
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
                  <span class="tab-list-value">
                    <em id="borrower" class="fn-left fn-text-overflow" title="" style="max-width:120px"></em>
                    <em id="gender" class="fn-left ui-icon ui-icon-mid mt5" title=""></em>
                  </span>
                </li>
                <li>
                  <span class="tab-list-label mr30">年&nbsp;&nbsp;&nbsp;&nbsp;龄</span>
                  <span id="age" class="tab-list-value"></span>
                </li>
                <li>
                  <span class="tab-list-label mr30">婚&nbsp;&nbsp;&nbsp;&nbsp;姻</span>
                  <span id="marital" class="tab-list-value"></span>
                </li>
                <li>
                  <span class="tab-list-label mr30">学&nbsp;&nbsp;&nbsp;&nbsp;历</span>
                  <span id="education" class="tab-list-value"></span>
                </li>
                <li>
                  <span class="tab-list-label mr30">居住地</span>
                  <span id="living_place" class="tab-list-value"></span>
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
                      <div class="ui-td-bg">
                        <i class="icon icon-circle-checked"></i>
                      </div>
                    </td>
                    <td class="text-right">
                      <div id="check_credit_date" class="ui-td-bg pr145"></div>
                    </td>
                  </tr>
                  <tr class="">
                    <td>
                      <div class="ui-td-bg pl100">身份认证</div>
                    </td>
                    <td class="text-center">
                      <div class="ui-td-bg">
                        <i class="icon icon-circle-checked"></i>
                      </div>
                    </td>
                    <td class="text-right">
                      <div id="check_id_date" class="ui-td-bg pr145"></div>
                    </td>
                  </tr>
                  <tr class="dark">
                    <td>
                      <div class="ui-td-bg pl100">抵押认证</div>
                    </td>
                    <td class="text-center">
                      <div class="ui-td-bg">
                        <i id="check_mortgage" class="icon"></i>
                      </div>
                    </td>
                    <td class="text-right">
                      <div id="check_mortgage_date" class="ui-td-bg pr145"></div>
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
            </div>
          </div>
          <div class="ui-tab-content-description border-bottom p35">
            <h4 class="ui-tab-content-title color-dark-text">抵押资产说明</h4>
            <div id="asset_description" class="ui-tab-list color-dark-text">
            </div>
          </div>
        </div>

        <div class="ui-tab-content p35 fn-clear" data-name="investments">
          <?php if ($user->uid > 0){ ?>
            <div class="text-right text-big color-red-text mb10">
              <span class="mr50">加入人次 <em id="investors_total"></em> 人</span>
              <span class="mr10">投标总额 <em id="investors_amount_total"></em>元</span>
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