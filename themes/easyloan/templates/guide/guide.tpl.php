<?php

/**
 * @file
 * Forget password
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/guide.css');

global $base_url;
$image_path = $base_url . '/sites/all/themes/easyloan/images/';

?>
<div class="pg-guide-info mt20">
<?php
  print views_embed_view('guide_invest', "block", "");
?>
</div>