<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
?>
<div class="pg-container  ">
  <?php print render($page['header']); ?>
  <?php //print $messages; ?>
  <div class="pg-container-content">
	<div id="pg-guide-one">
	    <div class="container_12 mt10">
	      <div class="grid_12"> 
	        <div class="pg-guide-content">
	          <div class="pg-guide-title">
	            <h1 class="h3">新手指引</h1>
	            <ul class="mt10 fn-clear content-top">
					<?php print render($page['content_top']); ?>
				</ul>
	          </div>
				<?php print render($page['content']); ?>
			  </div>
		    </div>
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
