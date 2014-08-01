<?php
/**
 * @file
 * Returns the HTML for the footer region.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728140
 */
global $base_url;
drupal_add_js(drupal_get_path('theme','hyd') . '/js/help.js');
drupal_add_css(drupal_get_path('theme','hyd') . '/css/help.css');
?>
<?php print $rows; ?>
<!--div class="fn-right mt10 ui-pagination simple-pagination .ui-pagination" id="news-list-pagination"><ul><li class="active"><span class="current prev">Prev</span></li><li class="active"><span class="current">1</span></li><li><a href="#page-2" class="page-link">2</a></li><li><a href="#page-3" class="page-link">3</a></li><li><a href="#page-4" class="page-link">4</a></li><li><a href="#page-5" class="page-link">5</a></li><li><a href="#page-6" class="page-link">6</a></li><li><a href="#page-2" class="page-link next">Next</a></li></ul></div-->
