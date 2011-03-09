<?php
/**
 * @file
 * Implements various theme-related customisations and preprocessors.
 * all Drupal functions which are themeable this way, start with theme_
 * See for a full list: http://api.drupal.org/api/group/themeable
 * 
 */

drupal_rebuild_theme_registry(); // remember to turn this off on production websites!

/**
 * Allow theming for:
 *  - user login form (page)
 */
function oeleboele_theme() {
  return array(
    'user_login' => array(
      'arguments' => array('form' => null),
    ),
  );
}

/**
 * Theme user login form (page)
 */
function oeleboele_user_login( $form ) {
  $form['name']['#attributes']['autofocus'] = '';
  return drupal_render($form);
}

/**
 * Override variables before any other preprocess function, taken from zen
 */
function phptemplate_preprocess(&$vars, $hook) {

	// Create classes ARRAY instead of string
	$key = ($hook == 'page' || $hook == 'maintenance_page') ? 'body_classes' : 'classes';
	if ( array_key_exists($key, $vars) ) {
		if ( is_string($vars[$key]) ) {
			$classes = $vars[$key];
			$classes = strtr($classes, array('logged-in' => '', 'no-sidebars' => ''));
			$vars['classes_array'] = array_filter(explode(' ', $classes));
			unset($vars[$key]);
		}
	}
	else {
		$vars['classes_array'] = array($hook);
	}

	// deze redirect functie wordt vooral gebruikt om bepaalde i18n redirects in te stellen
	// zie ook deze wiki pagina: http://atrium.merge.nl/merge/node/883
	/*if ( arg(0) == 'node' && is_numeric(arg(1)) ) {
		merge_redirect((int)arg(1));
	}*/
}

function merge_redirect($nid) {
	switch ($nid) {
		case 99999: // example
			drupal_goto('/nl');
	}
}

/**
 * Override or insert variables into the page template.
 */
function phptemplate_preprocess_page(&$vars) {

	// A handy boolean
	$vars['is_node'] = arg(0) == 'node' && is_numeric(arg(1));

	// Context classes (more for debugging than anything else)
	if ( function_exists('context_active_contexts') ) {
		$contexts = context_active_contexts();
		foreach ( $contexts AS $c_id => $c ) {
			$vars['classes_array'][] = 'context-' . $c_id;
		}
	}

	// 'Side bar' styles
	// Change the regions to whatever you need to know the difference in
	// Don't add ALL regions; that's just a waste of classes
	foreach ( array('left', 'right') AS $region ) {
		$vars['classes_array'][] = 'with' . ( empty($vars[$region]) ? 'out' : '' ) . '-' . $region;
	}

	// Always do this
	if ( stripos($vars['head_title'], 'icon_users.png') ) {
		$vars['head_title'] = 'User account | ' . variable_get('site_name', '');
	}
	// and this
	if ( stripos($vars['title'], 'icon_users.png') ) {
		$vars['title'] = 'User account';
	}

	// Add more handy classes
	if ( arg(1) == 'add' || arg(2) == 'edit' ) {
		$vars['classes_array'][] = 'node-add-edit';
	}
	if ( arg(0) == 'user' || arg(2) == 'profile' ) {
		$vars['classes_array'][] = 'account-edit';
	}
	if ( arg(0) == 'user' || arg(2) == 'edit' ) {
		$vars['classes_array'][] = 'profile-edit';
	}
	if ( $vars['is_node'] && arg(2) == 'done' ) {
		$vars['classes_array'][] = 'webform-submitted';
	}

}

/**
 * Override or insert variables into the node template.
 */
function phptemplate_preprocess_node(&$vars) {
	// you can do various stuff here to alter variables which are avaialable in node.tpl.php
	// see for an example: http://11heavens.com/putting-some-order-in-your-terms
}

/**
 * Format a username.
 */
function phptemplate_username($object) {

  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }

    if (user_access('access user profiles')) {
      $output = l($name, 'user/'. $object->uid, array('attributes' => array('title' => t('View user profile.'))));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage, array('attributes' => array('rel' => 'nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }
  }
  else {
    $output = check_plain(variable_get('anonymous', t('Anonymous')));
  }

  return $output;
}

  phptemplate_removetab('Weergeven', $vars);
  phptemplate_removetab('View', $vars);
  phptemplate_removetab('Track', $vars);
  phptemplate_removetab('Opvolgen', $vars);

// Remove undesired local task tabs.
// Related to yourthemename_removetab() in yourthemename_preprocess_page().
function phptemplate_removetab($label, &$vars) {
  $tabs = explode("\n", $vars['tabs']);
  $vars['tabs'] = '';
  foreach ($tabs as $tab) {
    if (strpos($tab, '>' . $label . '<') === FALSE) {
      $vars['tabs'] .= $tab . "\n";
    }
  }
}

/* other usefull overrides:

see also http://drupalcontrib.org/api

theme_views_mini_pager  (views mini pager)
theme_pager (normal pager)
theme_date_display_range (date module range van t/m)
theme_breadcrumb

calendar:
theme_preprocess_date_navigation

theming the comment form:
http://www.digett.com/2010/06/29/how-theme-comment-form-drupal-6


function YOURTHEMENAME_theme() {
  return array(
    'comment_form' => array(
      'arguments' => array('form' => NULL),
    ),
  );
}

function YOURTHEMENAME_comment_form($form) {
$form['cancel'] = array(
'#id' => 'cancel',
'#type' => 'button',
'#value' => t('Cancel'),
'#weight' => 20,
'#executes_submit_callback' => TRUE,
'#submit' => array('mymodule_form_cancel'),
);
  $cf = $form['comment_filter']['comment'];
  unset($form['comment_filter']);
  $form = array_merge(array('comment' => $cf), $form);
  return drupal_render($form);
}

*/
