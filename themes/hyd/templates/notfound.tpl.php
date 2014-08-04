<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 * The 404 page, node/65 
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
drupal_add_css(drupal_get_path('theme','hyd') . '/css/error.css');
global $base_url;
?>
  <div class="pg-error-content">
    <div class="container_12">
      <div class="grid_12 fn-clear mt80">
        <img class="fn-left" src="<?php print $base_url;?>/sites/all/themes/hyd/images/404.png" alt="404">
        <div class="fn-left error-info last">
          <h1 class="h3 mb10">您要找的页面不存在</h1>
          <p>可能该服务已经过期，或者您输入的地址有误。</p>
          <p>您可以继续浏览 <a href="<?php print $GLOBALS['base_url'];?>">好易贷首页</a></p>
        </div>
      </div>
    </div>
  </div>