<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7"  lang="zh-hans" dir="ltr"><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7"  lang="zh-hans" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8"  lang="zh-hans" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="lt-ie9"  lang="zh-hans" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html  lang="zh-hans" dir="ltr"><!--<![endif]-->
<?php
  global $base_url;
  $theme_path = drupal_get_path('theme','hyd');
?>
<head>
  <meta charset="utf-8" />
  <title>站点维护中 | 好易贷</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="content-type" content="text/html" charset="utf-8">
  <meta name="keywords" content="好易贷|网络理财|个人理财|投资理财|P2P理财|互联网金融|投资理财|债权转让|理财计划|优选计划|网络贷款|工薪贷|生意贷|网商贷|网贷|小额贷款" />
  <meta name="description" content="好易贷(www.easyloan.com)是目前中国互联网金融中P2P信贷行业中最大、最安全的平台，为投资理财用户和贷款用户两端提供公平、透明、安全、高效的互联网金融服务。投资理财用户可以通过好易贷平台进行投标、加入优选理财计划、购买债权等方式进行投资获得高收益；贷款用户可以通过平台申请工薪贷、生意贷、网商贷等小额贷款。" />
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="cleartype" content="on">
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <style>
    .pg-error-content img{padding:0 130px 203px 80px}.error-info{width:420px;padding:65px 60px 60px 30px;color:#555}.error-info p{color:#909090;font-size:18px}.error-info .error-link a{margin-right:16px}
  </style>
</head>
<body class="html not-front logged-in no-sidebars page-notfound section-notfound" > 
    <div class="pg-container page">
    <div class="header__region region region-header">
    <div class="ui-header block block-easyloan contextual-links-region first last odd" id="header">
  <div class="ui-header-main">
    <div class="container_12 fn-clear">
      <div class="grid_2 ui-header-grid">
          <a href="<?php print $base_url; ?>" title="好易贷 | 中国最大最安全的B2C（公司对个人）网络金融投资平台" rel="home" class="ui-header-logo fn-left" id="logo"></a>
      </div>
    </div>
  </div>
</div>  </div>
    <div class="pg-container-content">
  <div class="pg-error-content">
    <div class="container_12">
      <div class="grid_12 fn-clear mt80">
        <img class="fn-left" src="<?php print $base_url . '/' . $theme_path; ?>/images/under_construction.jpg" alt="维护中">
        <div class="fn-left error-info last">
          <h1 class="h3 mb10">网站正在维护中</h1>
          <p><?php print $content; ?></p>
        </div>
      </div>
    </div>
  </div>  </div>
  <div class="ui-footer" id="footer">
  <div class="container_12">
    <div class="grid_12">
      <div class="ui-footer-section ui-footer-narrow-hide">
        <ul class="ui-footer-links fn-clear">
            <footer id="footer" class="region region-footer">
    <div id="block-easyloan-footer" class="block block-easyloan contextual-links-region first last odd">
</div>
  </footer>
        </ul>
      </div>
    <div class="region region-bottom">
    <div class="ui-footer-section ui-footer-narrow-hide fn-clear block block-easyloan contextual-links-region first last odd">
    <div class="ui-footer-links grid_9 alpha">
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
      <h4 class="color-gray-text text-right ui-footer-phone-number"><?php print variable_get('easyloan_service_tel_number');?></h4>
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
  </div>
</div>
</div>
</div>  </body>
</html>
