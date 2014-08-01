<?php
drupal_add_js(drupal_get_path('theme','hyd') . '/js/help.js');
drupal_add_css(drupal_get_path('theme','hyd') . '/css/help.css');
?>

<div id="pg-help-terms" class="pg-help-main rrdcolor-dimgray-text pg-help-terms p20bs">
  <?php
    print views_embed_view('accountlist', "block", "");
  ?>
</div>