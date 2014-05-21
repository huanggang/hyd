<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $base_url;
?>
    <div class="p20bs color-white-bg">
      <div class="fn-clear" id="query-form">
        <div class="fn-left">
          <div class="fn-left pr10 w80">排序条件</div>
          <select class="fn-left" name="type" autocomplete="off">
            <option value="JOINTIME" selected="selected">加入时间</option>
            <option value="TOTAL">总金额</option>
            <option value="LASTLOGIN">登陆时间</option>
          </select>
          <div class="fn-left mr20" id="query-normal">
            <select name="time" autocomplete="off">
              <option value="DESC" selected="selected">降序</option>
              <option value="ASC">升序</option>
            </select>
          </div>
          <a class="fn-left ui-button ui-button-small ui-button-blue" id="query-submit">查询</a>
          <br />
            <hr class="mt20">
          <br />
          <div class="fn-left pr10 w80">手机</div>
          <div class="fn-left mr20 pr10" id="query-normal">
            <input name="account" class="w120 mr10" autocomplete="off" />或者
          </div>
          <br />
          <br />
          <div class="fn-left pr10 w80">姓名+身份证</div>
          <div class="fn-left pr10" id="query-normal">
            <input name="account" class="w60" />
          </div>
          <div class="fn-left mr20 pr10" id="query-normal">
            <input name="account" />
          </div>
          <a class="fn-left ui-button ui-button-small ui-button-blue" id="query-submit">查看用户</a>
        </div>
      </div>
      <hr class="mt20">
      <div class="mt10 fn-clear">
        <ul class="ui-list ui-list-s mt10" id="transactions">
          <li class="ui-list-header text fn-clear">
            <span class="ui-list-title w90 fn-left time">昵称</span>
            <span class="ui-list-title w50 fn-left type">姓名</span>
            <span class="ui-list-title w80 fn-left credit">净资产</span>
            <span class="ui-list-title w80 fn-left debit">账户余额</span>
            <span class="ui-list-title w80 fn-left balance">账户欠款</span>
            <span class="ui-list-title w80 fn-left note last">冻结资金</span>
            <span class="ui-list-title w140 fn-left note last">注册时间</span>
            <span class="ui-list-title w140 fn-left note last">登陆时间</span>
          </li>
          <!--
          <li class="ui-list-status">
            <p class="color-gray-text">没有记录</p>
          </li>
          -->
          <li class="ui-list-item text fn-clear">
            <span class="ui-list-title w90 fn-left time">神鱼</span>
            <span class="ui-list-title w50 fn-left type"><a href="management/123456" target="_blank">习近平</a></span>
            <span class="ui-list-title w80 fn-left credit">10，000元</span>
            <span class="ui-list-title w80 fn-left debit">10，000元</span>
            <span class="ui-list-title w80 fn-left balance">0元</span>
            <span class="ui-list-title w80 fn-left note last">0元</span>
            <span class="ui-list-title w140 fn-left note last">2014-01-02 15:33</span>
            <span class="ui-list-title w140 fn-left note last">2014-04-02 14:08</span>
          </li>
          <li class="ui-list-item text fn-clear">
            <span class="ui-list-title w90 fn-left time">神鱼</span>
            <span class="ui-list-title w50 fn-left type"><a href="management/123457" target="_blank">李克强</a></span>
            <span class="ui-list-title w80 fn-left credit">10，000元</span>
            <span class="ui-list-title w80 fn-left debit">10，000元</span>
            <span class="ui-list-title w80 fn-left balance">0元</span>
            <span class="ui-list-title w80 fn-left note last">0元</span>
            <span class="ui-list-title w140 fn-left note last">2014-01-02 15:33</span>
            <span class="ui-list-title w140 fn-left note last">2014-04-02 14:08</span>
          </li>
        </ul>
        <div class="fn-right mt10 ui-pagination simple-pagination" id="notices-list-pagination">
          <ul>
            <li class="active"><span class="current prev">Prev</span></li>
            <li class="active"><span class="current">1</span></li>
            <li><a href="#page-2" class="page-link">2</a></li>
            <li><a href="#page-3" class="page-link">3</a></li>
            <li><a href="#page-4" class="page-link">4</a></li>
            <li><a href="#page-5" class="page-link">5</a></li>
            <li class="disabled"><span class="ellipse">…</span></li>
            <li><a href="#page-22" class="page-link">22</a></li>
            <li><a href="#page-23" class="page-link">23</a></li>
            <li><a href="#page-2" class="page-link next">Next</a></li>
          </ul>
        </div>
      </div>
    </div>