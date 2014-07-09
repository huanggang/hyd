<?php

drupal_add_css(drupal_get_path('theme','easyloan') . '/css/guide.css');

global $base_url;
$image_path = $base_url . '/sites/all/themes/easyloan/images/';

?>
<div class="pg-guide-info mt20">
<?php
  print views_embed_view('guide_invest', "block", "");
?>
</div>