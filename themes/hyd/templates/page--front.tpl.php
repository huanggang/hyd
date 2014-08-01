<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/index.css');
drupal_add_css($theme_path . '/css/bjqs.css');

drupal_add_js($theme_path . '/js/bjqs-1.3.js');
drupal_add_js($theme_path . '/js/slider.js');
?>
<div class="pg-container color-white-bg">
  <?php print render($page['header']); ?>
  <?php //print $messages; ?>
  <div class="pg-container-content">
  <div id="pg-index">
    <!-- Slide -->
    <?php
      print render($page['slide']);
    ?>
    <div class="container_12">
      <?php
        print render($page['content_top']);
      ?>
      <div class="bell"></div>
    </div>
  </div>
</div>

<div class="ui-footer" id="footer">
  <div class="container_12">
    <div class="grid_12">
      <div class="ui-footer-section ui-footer-narrow-hide">
        <ul class="ui-footer-links fn-clear">
          <li class="fn-left">
            <h4 class="color-gray-text text-big">友情链接</h4>
          </li>
          <?php print render($page['footer']); ?>
        </ul>
      </div>
  <?php print render($page['bottom']); ?>
  </div>
</div>
</div>
</div>
