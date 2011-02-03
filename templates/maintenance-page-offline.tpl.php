<?php
/**
 * @file
 * Theme implementation to display a single Drupal page.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<body id="maintenance">
  
  <?php print $admin; ?>
  
  <div id="wrapper">
    
      <?php if ($logo): ?>
          <img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>">
      <?php endif; ?>
			
			<div>
			This website is not accessible due to a technical problem.<br />
			<br />
			I'm sure it will be fixed soon, so come back in a little while!
			</div>
  </div>
  
  <?php print $closure; ?>
	
</body>

</html>
