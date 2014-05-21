<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/details.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/details2.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/tab.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/iconfont.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/tab.js');

global $user;
global $base_url;

?>
<div id="pg-loan-invest" class="pg-details">
<div id="loan-basic">
  <div class="container_12 mt10 color-white-bg" id="loan-basic-panel">
       <div class="ui-box-white-bg fn-clear">
          <div class="ui-box-title fn-clear">
            <h3 class="fn-left fn-text-overflow" title="机构担保标"><em class="icon-loantype JGDB mr10"></em>资金周转</h3>
            <a class="fn-left ui-box-username fn-text-overflow w180 pl20" href="/account/myInfo.action?userId=636370" target="_blank">ZD7550080002413</a>
            <a class="fn-right text ui-box-text" href="javascript:void(0)">借款协议（范本）</a>
          </div>
          <div class="p20 fn-clear">
            <div class="fn-left loaninfo">
              <div class="fn-clear pt10 mb25">
                <dl class="fn-left w270">
                  <dt>标的总额 （元）</dt>
                  <dd class="text-xxxl color-dark-text"><em>￥40,000</em></dd>
                </dl>
                <dl class="fn-left w180">
                  <dt>年利率</dt>
                  <dd class="text-xxl"><em class="text-xxxl color-dark-text">11.00</em>%</dd>
                </dl>
                <dl class="fn-left w120">
                  <dt>还款期限 （月）</dt>
                  <dd class="text-xxxl color-dark-text"><em>12</em></dd>
                </dl>
              </div>
              <ul>
                <li class="fn-clear">
                  <span class="fn-left basic-label w70">保障方式</span>
                  <span class="fn-left basic-value last">本金+利息 <a id="tips_0" class="iconfont" href="/help/intro.action#capital-safe" target="_blank"></a></span>
                  <span class="fn-left basic-label mr30">提前还款费率</span>
                  <span class="fn-left basic-value num"><em>1.00</em>%</span>
                </li>
                <li class="fn-clear">
                  <span class="fn-left basic-label w70">还款方式</span>
                  <span class="fn-left basic-value">按月还款/等额本息 <a id="tips_1" class="iconfont" href="/help/terms.action#avg-capital-plus-interest" target="_blank"></a></span>
                  <span class="fn-left basic-label mr30">月还本息（元）</span>
                  <span class="fn-left basic-value num last"><em>3,536.00</em></span>
                </li>
                
              </ul>
              <div class="stamp"><em class="READY"></em></div>
            </div>

              <div class="ui-poptip fn-hide" id="tipCon_0" data-widget-cid="widget-1">
                  <div class="ui-poptip-shadow">
                      <div class="ui-poptip-container">
                          <div class="ui-poptip-arrow ui-poptip-arrow-10">
                              <em></em>
                              <span></span>
                          </div>
                          <div class="ui-poptip-content" data-role="content">
                              详情参见<a href="/help/intro.action#capital-safe" target="_blank">本金保障计划</a>
                          </div>
                      </div>
                  </div>
              </div>
              
                  
                  <div class="ui-poptip fn-hide" id="tipCon_1" data-widget-cid="widget-2">
                      <div class="ui-poptip-shadow">
                          <div class="ui-poptip-container">
                              <div class="ui-poptip-arrow ui-poptip-arrow-10">
                                  <em></em>
                                  <span></span>
                              </div>
                              <div class="ui-poptip-content" data-role="content">
                                  等额本息还款法是在还款期内，每月偿还同等数额的贷款(包括本金和利息)。<br>借款人每月还款额中的本金比重逐月递增、利息比重逐月递减。
                              </div>
                          </div>
                      </div>
                  </div>
              
                  <div class="fn-right loan-status loan-ready">
                      <div class="box"><em>满标用时</em><span id="fullTime" data-time="0天0时4分41秒">0时4分41秒</span></div>
                      <div class="hr"></div>
                      <div class="box"><em>加入人次</em><span>35</span></div>
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
        <li class="ui-tab-item " data-name="investment">
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
        <h4 class="ui-tab-content-title color-dark-text">用户信息
            <span class="ml10">ID: 636370</span>
        </h4>
        <ul class="ui-tab-list fn-clear">
            <li>
                <span class="tab-list-label mr30">用户名</span>
                <span class="tab-list-value" title="ZD7550080002413（男）">
                    <em class="fn-left fn-text-overflow" title="ZD7550080002413">ZD7550...</em>
                    <em class="fn-left ui-icon ui-icon-mid mt5  ui-icon-gender-male " title="男"></em>
                </span>
            </li>
            <li>
                <span class="tab-list-label mr30">公司行业</span>
                <span class="tab-list-value">餐饮/旅馆业</span>
            </li>
            <li>
                <span class="tab-list-label mr30">收入范围</span>
                <span class="tab-list-value">10000-20000元</span>
            </li>
            <li>
                <span class="tab-list-label mr30">年&nbsp;&nbsp;&nbsp;&nbsp;龄</span>
                <span class="tab-list-value">44</span>
            </li>
            <li>
                <span class="tab-list-label mr30">公司规模</span>
                <span class="tab-list-value">10-100人</span>
            </li>
            <li>
                <span class="tab-list-label mr30">房&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;产</span>
              <span class="tab-list-value">
                <span class="mr20"><i class="icon icon-check-unchecked mr5"></i>有</span>
                <span><i class="icon icon-check-checked mr5"></i>无</span>
              </span>
            </li>
            <li>
                <span class="tab-list-label mr30">学&nbsp;&nbsp;&nbsp;&nbsp;历</span>
                <span class="tab-list-value">大专</span>
            </li>
            <li>
                <span class="tab-list-label mr30">岗位职位</span>
                <span class="tab-list-value fn-text-overflow">副总</span>
            </li>
            <li>
                <span class="tab-list-label mr30">房&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;贷</span>
              <span class="tab-list-value">
                <span class="mr20"><i class="icon icon-check-unchecked mr5"></i>有</span>
                <span><i class="icon icon-check-checked mr5"></i>无</span>
              </span>
            </li>
            <li>
                <span class="tab-list-label mr30">学&nbsp;&nbsp;&nbsp;&nbsp;校</span>
                <span class="tab-list-value fn-text-overflow"><span id="university" title="" data-data="">--</span></span>
            </li>
            <li>
                <span class="tab-list-label mr30">工作城市</span>
                <span class="tab-list-value">广东省 深圳市</span>
            </li>
            <li>
                <span class="tab-list-label mr30">车&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;产</span>
              <span class="tab-list-value">
                      <span class="mr20"><i class="icon icon-check-unchecked mr5"></i>有 </span>
                      <span><i class="icon icon-check-checked mr5"></i>无</span>
                  
              </span>
            </li>
            <li>
                <span class="tab-list-label mr30">婚&nbsp;&nbsp;&nbsp;&nbsp;姻</span>
                <span class="tab-list-value"> 已婚</span>
            </li>
            <li>
                <span class="tab-list-label mr30">工作时间</span>
                <span class="tab-list-value">1-3年（含）</span>
            </li>
            <li>
                <span class="tab-list-label mr30">车&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;贷</span>
              <span class="tab-list-value">
                <span class="mr20"><i class="icon icon-check-unchecked mr5"></i>有</span>
                <span><i class="icon icon-check-checked mr5"></i>无</span>
              </span>
            </li>
        </ul>
    </div>
    <div class="ui-tab-content-expediente border-bottom p35">
        <h4 class="ui-tab-content-title color-dark-text">信用档案   <span title="信用分数：145" class="icon-creditlevel A snow ml10">A</span></h4>
        <ul class="ui-tab-list fn-clear">
            <li>
                <span class="tab-list-label mr20">申请借款（笔）</span>
                <span class="tab-list-value">1</span>
            </li>
            <li>
                <span class="tab-list-label mr20">信用额度（元）</span>
                <span class="tab-list-value to-fix">40,000.00</span>
            </li>
            <li>
                <span class="tab-list-label mr20">逾期金额（元）</span>
                <span class="tab-list-value to-fix">0.00</span>
            </li>
            <li>
                <span class="tab-list-label mr20">成功借款（笔）</span>
                <span class="tab-list-value">0</span>
            </li>
            <li>
                <span class="tab-list-label mr20">借款总额（元）</span>
                <span class="tab-list-value to-fix">0.00</span>
            </li>
            <li>
                <span class="tab-list-label mr20">逾期次数（次）</span>
                <span class="tab-list-value">0</span>
            </li>
            <li> 
                <span class="tab-list-label mr20">还清笔数（笔）</span>
                <span class="tab-list-value">0</span>
            </li>
            <li>
                <span class="tab-list-label mr20">待还本息（元）</span>
                <span class="tab-list-value to-fix">0.00</span>
            </li>
            <li>
                <span class="tab-list-label mr20">严重逾期（笔）</span>
                <span class="tab-list-value">0</span>
            </li>
        </ul>
        <div style="display: none;">
            <span class="pg-helper large-number" data-name="available-level"></span>
        </div>
    </div>
<?php } else { ?>
    <div class="ui-tab-content-basic border-bottom p35">
        <h4 class="ui-tab-content-title color-dark-text">用户信息
        </h4>
            <h4 class="auth-hint narrow">请 <a href="<?php print $base_url;?>/user/login">登录</a> 或 <a href="<?php print $base_url;?>/user/register">注册</a> 后查看</h4>
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
                    <i class=" icon icon-circle-checked "></i>
                </div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr145"> 2014-02-28  </div>
            </td>
        </tr>
        
        <tr class="">
            <td>
                
                <div class="ui-td-bg pl100">身份认证</div>
                
            </td>
            <td class="text-center">
                <div class="ui-td-bg">
                    <i class=" icon icon-circle-checked "></i>
                </div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr145"> 2014-02-28  </div>
            </td>
        </tr>
        
        <tr class="dark">
            <td>
                
                <div class="ui-td-bg pl100"> 工作认证（<a href="/help/borrow.action#prod-work" target="_blank">工薪阶层</a>）</div>
                
            </td>
            <td class="text-center">
                <div class="ui-td-bg">
                    <i class=" icon icon-circle-checked "></i>
                </div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr145"> 2014-02-28  </div>
            </td>
        </tr>
        
        <tr class="">
            <td>
                
                <div class="ui-td-bg pl100">收入认证</div>
                
            </td>
            <td class="text-center">
                <div class="ui-td-bg">
                    <i class=" icon icon-circle-checked "></i>
                </div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr145"> 2014-02-28  </div>
            </td>
        </tr>
        
        <tr class="dark">
            <td>
                
                <div class="ui-td-bg pl100"> 机构担保（<a href="/event/zdsd/index.jsp" target="_blank" title="深圳市证大速贷小额贷款股份有限公司">证大速贷</a>）</div>
                
            </td>
            <td class="text-center">
                <div class="ui-td-bg">
                    <i class=" icon icon-circle-checked "></i>
                </div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr145"> <span class="pr25">--</span> </div>
            </td>
        </tr>
        
        </tbody>
    </table>
</div>
        <ul>
            <li>人人贷及其合作机构将始终秉持客观公正的原则，严控风险，最大程度的尽力确保借入者信息的真实性，但不保证审核信息100%无误。</li>
            <li>借入者若长期逾期，其个人信息将被公布。</li>
        </ul>
    </div>

    <div class="ui-tab-content-description border-bottom p35">
        <h4 class="ui-tab-content-title color-dark-text">借款描述</h4>
        <div class="ui-tab-list color-dark-text">
            深圳市证大速贷小额贷款股份有限公司（“证大速贷”）成立于2010年，公司注册资本1亿元人民币，第一大股东证大集团（0755.HK）是以专业金融综合投资及房地产开发经营为主业的大型企业集团，第二大股东长安国际信托股份有限公司主要从事资金信托、融资租赁、投资银行业务等金融业务。证大速贷主要致力于为小微企业，个体工商户和中低收入个人提供快速便捷、免抵押、免担保的小额信贷服务。公司自成立以来发展迅速，先后在深圳、北京、上海、广州等主要一二线城市开设近48家营业网点。此外，证大速贷与中国银行、国家开发银行、江苏银行方资产管理公司等金融机构建立长期战略合作伙伴关系，累计为四万名小微客户提供了微金融服务，资产质量始终位于同行前列。
        </div>
    </div>

    </div>
      <div class="ui-tab-content p35 fn-clear" data-name="investment">
        <div class="text-right text-big color-red-text mb10">
          <span class="mr50">加入人次 <em id="investor-count">35</em> 人</span>
          <span class="mr10">投标总额 <em>40,000</em>元</span>
        </div>
        <div class="ui-list ui-list-s" id="investment-records">
    <table class="ui-table ui-table-blue ui-table-auditoria">
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
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=625858" target="_blank" title="blackrule668">blackr...</a></div>
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
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=477029" target="_blank" title="aygjhenry">aygjhe...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>50.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">3</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=477919" target="_blank" title="冯海涛">冯海涛</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>250.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">4</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=358856" target="_blank" title="渐渐高">渐渐高</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>150.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">5</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=346296" target="_blank" title="100年">100年</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>50.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">6</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=138870" target="_blank" title="Miranda">Mirand...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>250.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">7</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=611408" target="_blank" title="woatsh">woatsh</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>2000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">8</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=180764" target="_blank" title="鲁西西5048">鲁西西504...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>150.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">9</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=134109" target="_blank" title="sdjjzjm">sdjjzj...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>2000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">10</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=425892" target="_blank" title="Southey">Southe...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>4000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">11</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=78826" target="_blank" title="真诚借贷">真诚借贷</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>100.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">12</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=600688" target="_blank" title="mengxib">mengxi...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>100.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">13</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=502146" target="_blank" title="chrissrong">chriss...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>800.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">14</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=634491" target="_blank" title="培培女王104">培培女王10...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>1000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">15</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=465828" target="_blank" title="whoma">whoma</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>3000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">16</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=630344" target="_blank" title="炸弹超人65">炸弹超人65</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>2000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">17</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=522331" target="_blank" title="HL396482">HL3964...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>10000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">18</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=588475" target="_blank" title="zhjian_1mail">zhjian...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>1500.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:09</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">19</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=632505" target="_blank" title="yiranguyu">yirang...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>500.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">20</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=502404" target="_blank" title="toothpickjacky">toothp...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>250.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">21</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=184545" target="_blank" title="cdruvt">cdruvt</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>1300.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">22</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=247943" target="_blank" title="沙漠在乌">沙漠在乌</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>50.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">23</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=94146" target="_blank" title="hekouzhct">hekouz...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>1350.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">24</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=634498" target="_blank" title="健康是福">健康是福</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>1000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">25</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=357908" target="_blank" title="楚天积木">楚天积木</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>200.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">26</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=492587" target="_blank" title="zzjwhsd">zzjwhs...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>100.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">27</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=8172" target="_blank" title="河马奶奶">河马奶奶</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>3150.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">28</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=109284" target="_blank" title="nili">nili</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>1300.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">29</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=134109" target="_blank" title="sdjjzjm">sdjjzj...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>2000.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">30</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=526666" target="_blank" title="Baker_chu">Baker_...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>500.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">31</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=610417" target="_blank" title="tjyy">tjyy</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>100.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">32</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=407038" target="_blank" title="思晴">思晴</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>100.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark ">
            <td>
                <div class="ui-td-bg pl60">33</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=256400" target="_blank" title="土土土">土土土</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>200.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class=" ">
            <td>
                <div class="ui-td-bg pl60">34</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=134109" target="_blank" title="sdjjzjm">sdjjzj...</a></div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr70"><em>100.00</em>元</div>
            </td>
            <td class="text-right">
                <div class="ui-td-bg pr90">2014-02-28 15:10</div>
            </td>
        </tr>
        
        <tr class="dark last">
            <td>
                <div class="ui-td-bg pl60">35</div>
            </td>
            <td>
                <div class="ui-td-bg pl40"><a href="/account/myInfo.action?userId=476858" target="_blank" title="yanrongxia">yanron...</a></div>
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
      </div>
    </div>
  </div>
</div>
<div class="ui-goTop" style="left: 1175.5px; display: none;"></div>

    <div id="pg-helper" style="display: none;">
      <span id="pg-helper-loan-id">168545</span>
      <span id="pg-helper-is-investor">true</span>
      <span id="pg-helper-be-investor-message"></span>
      <span id="authenticated">true</span>
    </div>
  </div>