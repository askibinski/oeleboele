<?php
// $Id: page.tpl.php,v 1.11.2.1 2009/04/30 00:13:31 goba Exp $

/**
 * @file page.tpl.php
 *
 * Theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $css: An array of CSS files for the current page.
 * - $directory: The directory the theme is located in, e.g. themes/garland or
 *   themes/garland/minelli.
 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Page metadata:
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $body_classes: A set of CSS classes for the BODY tag. This contains flags
 *   indicating the current layout (multiple columns, single column), the current
 *   path, whether the user is logged in, and so on.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $mission: The text of the site mission, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $search_box: HTML to display the search box, empty if search has been disabled.
 * - $primary_links (array): An array containing primary navigation links for the
 *   site, if they have been configured.
 * - $secondary_links (array): An array containing secondary navigation links for
 *   the site, if they have been configured.
 *
 * Page content (in order of occurrance in the default page.tpl.php):
 * - $left: The HTML for the left sidebar.
 *
 * - $breadcrumb: The breadcrumb trail for the current page.
 * - $title: The page title, for use in the actual HTML content.
 * - $help: Dynamic help text, mostly for admin pages.
 * - $messages: HTML for status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the view
 *   and edit tabs when displaying a node).
 *
 * - $content: The main content of the current Drupal page.
 *
 * - $right: The HTML for the right sidebar.
 *
 * Footer/closing data:
 * - $feed_icons: A string of all feed icons for the current page.
 * - $footer_message: The footer message as defined in the admin settings.
 * - $footer : The footer region.
 * - $closure: Final closing markup from any modules that have altered the page.
 *   This variable should always be output last, after all other dynamic content.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 */
?>
<!DOCTYPE html>
<html class="html animate" lang="nl">

<head>
	<?php print $styles; ?>
	<?php print $head; ?>
	<title><?php print strip_tags(htmlspecialchars_decode($head_title)); ?></title>
	<?php print $scripts; ?>
</head>

<body class="<?php print implode(' ', $classes_array); ?>">
<!--[if lt IE 7 ]> <div class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>    <div class="ie ie7"> <![endif]-->
<!--[if IE 8 ]>    <div class="ie ie8"> <![endif]-->
<!--[if gte IE 9 ]><div class="ie ie9"> <![endif]-->

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

<!--[if IE]></div><![endif]-->
</body>

</html>
