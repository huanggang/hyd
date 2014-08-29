<?php 

/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 * 
 * Complete documentation for this file is available online. 
 * @see https://drupal.org/node/1728096 
 */ 
function hyd_theme() {  
  $path = drupal_get_path('theme', 'hyd') . '/templates'; 

  return array(
    'user_login' => array(
        'path'                 => $path,
        'template'             => 'login', 
        'render element'       => 'form', 
        //'arguments'          => array('form' => NULL), 
        'preprocess functions' => array('hyd_preprocess_user_login'), ),

    'user_pass' => array(
        'path'                   => $path, 
        'template'               => 'findpsw',  
        'render element'         => 'form', 
        ),
    'user_register_form' => array(
        'path'                 => $path, 
        'template'             => 'user-register',
        'render element'       => 'form',
        'preprocess functions' => array('hyd_preprocess_user_register_form'),
        ),
    'node_admin_content' => array(
        'path'                   => $path, 
        'template'               => 'node-admin-content',
        'render element'         => 'form', 
        //'arguments'            => array('form' => NULL), 
        ),

    'node_add_list' => array(
        'path'                   => $path, 
        'template'               => 'node-add-list',
        //'render element'         => 'form', 
        //'arguments'            => array('form' => NULL), 
        //'preprocess functions' => array('easyloan_preprocess_user_pass'), 
        ),
    'about' => array(
        'path'     => $path . '/about', 
        'template' => 'about',),
    'about-news' => array(
        'path'     => $path . '/about', 
        'template' => 'news',),
    /*'about-news-detail' => array(
        'path'     => $path . '/about', 
        'template' => 'news-detail',),*/
    'about-notices' => array(
        'path'     => $path . '/about', 
        'template' => 'notices',),
    /*
    'about-notices-detail' => array(
        'path'     => $path . '/about', 
        'template' => 'notices-detail',),*/

    'about-invite' => array(
        'path'     => $path . '/about', 
        'template' => 'invite',),
    'about-contact' => array(
        'path'     => $path . '/about', 
        'template' => 'contact',),

    'helpcenter' => array(
        'path'     => $path . '/help', 
        'template' => 'help',),
    'help-account' => array(
        'path'     => $path . '/help',
        'template' => 'account',),
    'help-intro' => array(
        'path'     => $path . '/help',
        'template' => 'intro',),
    'help-fee' => array(
        'path'     => $path . '/help',
        'template' => 'fee',),
    'help-borrow' => array(
        'path'     => $path . '/help',
        'template' => 'borrow',),
    'help-invest' => array(
        'path'     => $path . '/help',
        'template' => 'invest',),

    'guide' => array(
        'path'     => $path . '/guide',
        'template' => 'guide',),
    'guide-borrow' => array(
        'path'     => $path . '/guide',
        'template' => 'borrow',),
    'guide-security' => array(
        'path'     => $path . '/guide',
        'template' => 'security',),
    'invest' => array(
        'path'     => $path,
        'template' => 'invest',),
    'invest-detail' => array(
        'path'     => $path,
        'template' => 'invest-detail',),
    'notfound' => array(
        'path'     => $path,
        'template' => 'notfound',),

    'borrow' => array(
        'path'     => $path . '/borrow',
        'template' => 'borrow',),
    'borrow-estate' => array(
        'path'     => $path . '/borrow',
        'template' => 'estate',),
    'borrow-gold' => array(
        'path'     => $path . '/borrow',
        'template' => 'gold',),
    'borrow-car' => array(
        'path'     => $path . '/borrow',
        'template' => 'car',),
    'borrow-credit' => array(
        'path'     => $path . '/borrow',
        'template' => 'credit',),
    'borrow-else' => array(
        'path'     => $path . '/borrow',
        'template' => 'else',),
    'borrow-estate-apply' => array(
        'path'     => $path . '/borrow',
        'template' => 'estate-apply',),
    'borrow-gold-apply' => array(
        'path'     => $path . '/borrow',
        'template' => 'gold-apply',),
    'borrow-car-apply' => array(
        'path'     => $path . '/borrow',
        'template' => 'car-apply',),
    'borrow-credit-apply' => array(
        'path'     => $path . '/borrow',
        'template' => 'credit-apply',),
    'borrow-else-apply' => array(
        'path'     => $path . '/borrow',
        'template' => 'else-apply',),

    'chinabank-send' => array(
        'path'     => $path . '/chinabank',
        'template' => 'send',),

    'account-recharge' => array(
        'path'     => $path . '/account',
        'template' => 'recharge',),
    'account-withdraw' => array(
        'path'     => $path . '/account',
        'template' => 'withdraw',),
    'account-capital' => array(
        'path'     => $path . '/account',
        'template' => 'capital',),

    'account-myinvestment' => array(
        'path'     => $path . '/account',
        'template' => 'myinvestment',), 

    'account-myloan' => array(
        'path'     => $path . '/account',
        'template' => 'myloan',),
    'account-loanview' => array(
        'path'     => $path . '/account',
        'template' => 'loanview',),
    'account-loanappview' => array(
        'path'     => $path . '/account',
        'template' => 'loanappview',),
    'account-basicinfo' => array(
        'path'     => $path . '/account',
        'template' => 'basicinfo',),
    'account-security' => array(
        'path'     => $path . '/account',
        'template' => 'security',),
    'account-bankcard' => array(
        'path'     => $path . '/account',
        'template' => 'bankcard',),
    'account-settings' => array(
        'path'     => $path . '/account',
        'template' => 'settings',),
    'account-management' => array(
        'path'     => $path . '/account',
        'template' => 'management',),
    'account-management-user' => array(
        'path'     => $path . '/account',
        'template' => 'management-user',),

    'management-applications' => array(
        'path'     => $path . '/account',
        'template' => 'management-applications',),

    'management-accountsindebt' => array(
        'path'     => $path . '/account',
        'template' => 'accountsindebt',),
    'management-accountsindebt-detail' => array(
        'path'     => $path . '/account',
        'template' => 'accountsindebt-detail',),
    'management-loans' => array(
        'path'     => $path . '/account',
        'template' => 'management-loans',),
    'management-loan-lend' => array(
        'path'     => $path . '/account',
        'template' => 'management-loan-lend',),
    'management-withdrawappl' => array(
        'path'     => $path . '/account',
        'template' => 'management-withdrawappl',),
    'management-investments' => array(
        'path'     => $path . '/account',
        'template' => 'management-investments',),
    'management-investment-set' => array(
        'path'     => $path . '/account',
        'template' => 'management-investment-set',),
    );
}


/*
 * The following two methods are really heart-bleeding bug for the developer himself T_T
 * 
 */
function hyd_preprocess_user_register_form(&$variables){
        $variables['classes_array']            =array(' ');
        $variables['attributes_array']         =array(' ');
        $variables['title_attributes_array']   =array(' ');
        $variables['content_attributes_array'] =array(' ');
}
function hyd_preprocess_user_login(&$variables){
        $variables['classes_array']            =array(' ');
        $variables['attributes_array']         =array(' ');
        $variables['title_attributes_array']   =array(' ');
        $variables['content_attributes_array'] =array(' ');
}
/*  // to find out the caller method
    if ($elements['#theme'][0] == 'form_easyloan_wizard'){
      $caller = null;
      list(, $caller) = debug_backtrace(false);
      //var_dump($caller);
    }
    */

/*
 * This method provides us with page template override for certain node types.
 */
function hyd_preprocess_page(&$vars, $hook) {
  if (isset($vars['node'])) {
  // If the node type is "notice" the template suggestion will be "page--notice.tpl.php".
   $vars['theme_hook_suggestions'][] = 'page__'. str_replace('_', '--', $vars['node']->type);
  }
}