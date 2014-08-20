<?php
global $base_url;
$items = $variables['block']->params;
?>
<!-- News List -->
<div class="news mb fn-clear" id="news-section">
  <div class="grid_12">
    <div class="list-title news">
      <span class="on">最新动态</span>
    </div>
    <ul class="ui-list ui-list-m ui-list-news" id="news-list">
      <?php
      foreach ($items as $item){
      ?>
      <li class="ui-list-item fn-clear ">
        <p class="fn-left field decoration"></p>
        <p class="fn-left field text color-silver-text fn-text-overflow">
          <a class="title text-big rrd-dimgray" href="./node/<?php print $item['nid']; ?>" target="_blank"><?php print $item['title']; ?></a>
          <span class="content text-small"></span>
        </p>
        <p class="fn-left field date color-darkgray-text"><?php print $item['date']; ?></p>
      </li>
      <?php 
      } 
      ?>
      <li class="ui-list-more">
        <a class="darkgray" href="about/news">查看更多网站动态</a>
      </li>
      </ul>
  </div>
</div>