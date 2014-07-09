<?php

drupal_add_css(drupal_get_path('theme','easyloan') . '/css/guide.css');

?>
<div class="pg-guide-info mt20">
<?php
  print views_embed_view('guide_security', "block", "");
?>
</div>