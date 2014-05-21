<?php

drupal_add_css(drupal_get_path('theme','easyloan') . '/css/about.css'); 

$date_array = date_parse($node->news_date['und'][0]['value']);
$time = mktime(0, 0, 0, $date_array['month'], $date_array['day'], $date_array['year']);
$date = date("Y-m-d", $time); 
$date1 = date("Y年m月d日", $time); 

global $base_url; 
?> 
<div class="pg-about-main right-container p20bs"> 
  <h3 class="title"><?php print $title; ?></h3> 
  <div class="top"><?php print $date; ?></div> 
  <div class="article fn-clear"> 
    <p>&nbsp;</p> 
    <?php print $body[0]['value']; ?> 
    <p>&nbsp;</p> 
    <p>&nbsp;</p> 
    <p style="text-align: right;"><?php print $date1; ?></p> 
  </div>  
  <div class="bottom mt20 text-center">  
    <?php print drupal_render($content['flippy_pager']); ?>
    <br />
    <li class="viewall">
      <a href="<?php print $base_url;?>/about/news" title="全部文章">全部文章</a>
    </li>
  </div> 
</div> 