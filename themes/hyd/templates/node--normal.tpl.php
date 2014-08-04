<?php

drupal_add_css(drupal_get_path('theme','hyd') . '/css/about.css'); 

global $base_url; 
?> 


<div class="pg-about-main right-container p20bs">
  <h1 class="rrdcolor-blue-text"><?php print $title; ?></h1>
  <div class="pg-about-section">
    <?php print $body[0]['value']; ?> 

  </div>
</div>
