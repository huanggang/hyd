<?php
/**
 * @file
 * Returns the HTML for the footer region.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728140
 */
global $base_url;
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/easyloan.js');
?>
<div class="ui-header <?php print $classes; ?>" id="header">
  <div class="ui-header-main">
    <div class="container_12 fn-clear">
      <div class="grid_2 ui-header-grid">
          <a href="<?php print $base_url;?>" title="好易贷 | 中国最大最安全的B2C（公司对个人）网络金融投资平台" rel="home" class="ui-header-logo fn-left" id="logo"></a>
      </div>
      <div class="grid_7 ui-header-grid">
        <ul class="ui-nav ">
          <li class="ui-nav-item ui-nav-item-x">
            <a class="ui-nav-item-link rrd-dimgray" href="<?php print $base_url;?>/invest">
              <span>我要投资</span>
            </a>
          </li>
          <li class="ui-nav-item ui-nav-item-x" id="borrow-menu">
            <a class="ui-nav-item-link rrd-dimgray" href="<?php print $base_url;?>/borrow">
              <span>我要借款</span>
              <span class="arrow-down"></span>
            </a>
            <ul class="ui-nav-dropdown ui-nav-dropdown-borrow fn-hide">
              <li class="ui-nav-dropdown-angle"><span></span></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/borrow/estate">房产抵押</a></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/borrow/car">机动车抵押</a></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/borrow/gold">黄金抵押</a></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/borrow/credit">信用贷款</a></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/borrow/else">其他抵押</a></li>
            </ul>
          </li>
          <li class="ui-nav-item">
            <a class="ui-nav-item-link rrd-dimgray" href="<?php print $base_url;?>/guide/guide">新手指引</a>
          </li>
          <li class="ui-nav-item">
            <a class="ui-nav-item-link rrd-dimgray" href="<?php print $base_url;?>/about/company">关于我们</a>
          </li>
        </ul>
      </div>
      <div class="grid_3 ui-header-grid">
        <?php
          if ($logged_in) {
            global $user;
        ?>
        <ul class="ui-nav fn-right" id="user-menu">
          <li class="ui-nav-item ui-nav-item-x">
            <a class="ui-nav-item-link rrd-dimgray ui-nav-username fn-text-overflow" href="<?php print $base_url;?>/user">
              <span>您好，<?php print $user->name;?></span>
              <span class="arrow-down"></span>
            </a>
            <ul class="ui-nav-dropdown ui-nav-dropdown-account fn-hide">
              <li class="ui-nav-dropdown-angle"><span></span></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/capital_management/recharge">充值</a></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/capital_management/withdraw">提现</a></li>
              <li class="ui-nav-dropdown-separator"></li>
              <?php if (management_access()){ ?>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/management">好易贷管理</a></li>
              <?php
                    }
              ?>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/invest_management">理财管理</a></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/loan_management">借款管理</a></li>
              <li class="ui-nav-dropdown-separator"></li>
              <li class="ui-nav-dropdown-item"><a class="rrd-dimgray" href="<?php print $base_url;?>/user/logout">退出</a></li>
            </ul>
          </li>
        </ul>
        <?php
          } else {
        ?>
        <ul class="ui-nav fn-right "> 
          <li class="ui-nav-item"> 
            <a class="ui-nav-item-link login-link" href="<?php print $base_url;?>/user/login">登录</a> 
          </li>
        </ul>
        <ul class="ui-nav fn-right "> 
          <li class="ui-nav-item"> 
            <a class="ui-nav-item-link reg-link" href="<?php print $base_url;?>/user/register">注册</a> 
          </li>
        </ul>
        <?php
          }
        ?>
      </div>
    </div>
  </div>
</div>