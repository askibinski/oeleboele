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
 * Override variables before any other preprocess function, taken from zen
 */
function phptemplate_preprocess(&$vars, $hook) {
  // deze redirect functie wordt vooral gebruikt om bepaalde i18n redirects in te stellen
  // zie ook deze wiki pagina: http://atrium.merge.nl/merge/node/883
  if (arg(0)=='node' && is_numeric(arg(1))) {
    merge_redirect(arg(1));
  }
}

function merge_redirect($nid) {
  global $base_url;
  $parts = parse_url($base_url);
  switch ($nid) {
   case 99999: // example
   drupal_goto('http://'.$parts['host'].'/nl', $query = NULL, $fragment = NULL, $http_response_code = 301);
   break;
  }
}

/**
 * Override or insert variables into the page template.
 */
function phptemplate_preprocess_page(&$vars) {
	// you can do a lot of things here, on a page.tpl.php level
	// see examples: http://thedrupalblog.com/category/tags/preprocess-page
	
	// **voorbeeld**
	// onderstaande code voegt de naam van de view toe welke via de 
	// module 'viewfield' (http://drupal.org/project/viewfield)
	// in een node is ge-embed, aangenomen dat het CCK veld 'view' heet (field_view)
	
	// de 'vname' bestaat uit 2 delen gescheiden door een pipe (|),
	// het eerste deel is de view name,
	// het tweede deel de display name van de gebruikte view.
	if (is_array($vars[node]->field_view)) {
		$arr = explode("|",$vars[node]->field_view[0][vname]);
		if (is_array($arr)) {
			$vars['body_classes'] .= " ".$arr[0];
		}
	}
	if (stripos($vars['head_title'],'icon_users.png')) {
    $vars['head_title'] = 'User account | ' . variable_get('site_name', '');
  }
  if (stripos($vars['title'],'icon_users.png')) {
    $vars['title'] = 'User account';
  }
  
	if (arg(1)=='add' || arg(2)=='edit') {
		$vars['body_classes'] .= " node-add-edit";
	} 
	if (arg(0)=='user' || arg(2)=='profile') {
		$vars['body_classes'] .= " account-edit";
	} 
	if (arg(0)=='user' || arg(2)=='edit') {
		$vars['body_classes'] .= " profile-edit";
	}
  
  if (arg(0) == 'node' && is_numeric(arg(1))) {
	  $vars['is_node'] = TRUE;
    $vars['classes_array'][] = 'nid-'.arg(1);
    if (arg(2)=='done') {
      $vars['classes_array'][] = 'webform-submitted';
    }
  } else {
    $vars['is_node'] = FALSE;
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
