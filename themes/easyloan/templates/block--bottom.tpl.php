<?php
/**
 * @file
 * Returns the HTML for the footer region.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728140
 */
global $base_url;
?>
<div class="ui-footer-section ui-footer-narrow-hide fn-clear <?php print $classes; ?>">
    <div class="ui-footer-links grid_9 alpha">
      <ul class="fn-clear">
        <li class="fn-left">
          <a class="gray" target="_blank" href="<?php print $base_url;?>/about/company">公司介绍</a>
        </li>
        <li class="fn-left">
          <a class="gray" target="_blank" href="<?php print $base_url;?>/guide/security">安全保障</a>
        </li>
        <li class="fn-left">
          <a class="gray" target="_blank" href="<?php print $base_url;?>/help/help">帮助中心</a>
        </li>
        <li class="fn-left">
          <a class="gray" target="_blank" href="<?php print $base_url;?>/about/contact">联系我们</a>
        </li>
      </ul>
      <ul class="fn-clear icons">
        <li class="fn-left">
          <h4 class="color-gray-text text-big">客户服务</h4>
        </li>
        <li class="fn-left"><a class="ui-footer-img-link weibo" target="_blank" href="http://e.weibo.com/renrendai?ref=http%3A%2F%2Fwww.renrendai.com%2F">好易贷新浪微博</a></li>
        <li class="fn-left"><a class="ui-footer-img-link qq-weibo" target="_blank" href="http://t.qq.com/renrendai">好易贷腾讯微博</a></li>
        <li class="fn-left"><a class="ui-footer-img-link we-chat" target="_blank" href="/about/about.action?flag=contact#qr-code-weixin">好易贷微信</a></li>
        <li class="fn-left"><a class="ui-footer-img-link online-customer-service cursor-pointer" target="_blank" onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&amp;sid=4000278080&amp;eid=218808P8z8p8R8y8q8y8Q&amp;o=www.renrendai.com&amp;q=7&amp;ref='+document.location, '_blank', 'height=544, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');">好易贷在线客服</a></li>
      </ul>
    </div>
    <div class="grid_3 omega">
      <p class="color-gray-text text-right">客服电话</p>
      <h4 class="color-gray-text text-right ui-footer-phone-number">400-***-****</h4>
      <p class="color-gray-text text-right">9:00 - 21:00</p>
    </div>
  </div>
  <div class="ui-footer-section last">
    <div class="ui-footer-copyright">
      <span class="ui-footer-contact-link color-gray-text">© 2014 好易贷 All rights reserved</span>
      <span class="ui-footer-contact-link color-gray-text has-separator">好易贷商务顾问(北京)有限公司</span>
      <span class="ui-footer-contact-link color-gray-text has-separator last"><a class="gray" target="_blank" href="/icp/icp.html">粤ICP证 xxxxx号</a></span>
    </div>
    <div class="ui-footer-verification ui-footer-narrow-hide fn-clear">
      <a class="ui-footer-verification-item fn-left trust" title="好易贷已通过中网权威数据库对比，获得“可信网站”身份验证，您可放心使用。" href="https://ss.knet.cn/verifyseal.dll?sn=e13042311010040288j4wq000000&amp;ct=df&amp;a=1&amp;pa=931969" target="_blank"></a>
      <a class="ui-footer-verification-item fn-left norton" title="好易贷已引入VeriSign SSL加密技术，您的隐私及个人资料安全已受最高级别的保护。" href="https://trustsealinfo.verisign.com/splash?form_file=fdf/splash.fdf&amp;dn=www.renrendai.com&amp;lang=zh_cn" target="_blank"></a>
      <a class="ui-footer-verification-item fn-left police" title="好易贷已经完成在公安机关的信息备案，您可了解网站相关备案信息。" href="http://gawa.bjchy.gov.cn/websearch/" target="_blank"></a>
      <a class="ui-footer-verification-item fn-left gongshang" title="好易贷已经完成在北京市工商局网站备案，您可了解网站相关备案信息。" href="http://www.hd315.gov.cn/beian/view.asp?bianhao=010202013052900002" target="_blank"></a>
    </div>
  </div>
</div>
