<?php

$theme_path = drupal_get_path('theme','hyd');
drupal_add_css($theme_path . '/css/guide.css');
?>
<div class="pg-guide-info mt20">
<?php
  print views_embed_view('guide_invest', "block", "");
?>
</div>