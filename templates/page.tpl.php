<!doctype html>
<!--[if lt IE 8 ]>  <html class="html animate ie7" lang="<?=$language->language?>"> <![endif]-->
<!--[if IE 8 ]>     <html class="html animate ie8" lang="<?=$language->language?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="html animate no-js" lang="<?=$language->language?>"> <!--<![endif]-->

<head>
  <?php print $styles; ?>
  <title><?php print strip_tags(htmlspecialchars_decode($head_title)); ?></title>
  <?php print $head; ?>
  <?php print $scripts; ?>
</head>

<body class="<?php print implode(' ', $classes_array); ?>">

  <div id="wrapper">

    <div class="region-header">
      <?php print $header; ?>
    </div>

    <div class="region-navigation">
      <div id="logo"><a title="<?=t('Go to frontpage')?>" href="<?=url('<front>')?>"><?=t('Go to frontpage')?></a></div>
      <?php print $navigation; ?>
    </div>

    <?php if (!empty($messages)): ?>
      <div id="messages"><?php print $messages; ?></div>
    <?php endif; ?>

    <?php if (!empty($tabs)): ?>
      <div id="tabs"><?php print $tabs; ?></div>
    <?php endif; ?>

    <div id="page">

      <?php if (!empty($left)): ?>
        <div class="region-left"><div>
          <?php print $left; ?>
        </div></div>
      <?php endif; ?>

      <div class="semi-region-content">

        <?php if (!empty($content_top)): $content = ''; ?>
          <div class="region-content_top"><div>
            <?php print $content_top; ?>
            <div class="clear"></div>
          </div></div>
        <?php endif; ?>

        <?php if (!empty($content)): ?>
          <div class="region-content"><div>
            <?php print $content; ?>
            <div class="clear"></div>
          </div></div>
        <?php endif; ?>

        <?php if (!empty($content_bottom)): ?>
          <div class="region-content_bottom"><div>
            <?php print $content_bottom; ?>
            <div class="clear"></div>
          </div></div>
        <?php endif; ?>

      </div><!-- .semi-region-content -->

      <?php if (!empty($right)): ?>
        <div class="region-right"><div>
          <?php print $right; ?>
        </div></div>
      <?php endif; ?>

    </div><!-- #page -->

    <?php if (!empty($footer)): ?>
      <div class="region-footer">
        <?php print $footer; ?>
      </div>
    <?php endif; ?>

  </div><!-- #wrapper -->

  <?php print $closure; ?>

</body>

</html>
