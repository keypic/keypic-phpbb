<?php
/**
 *
 * @author keypic (Keypic) info@keypic.com
 * @version $Id$
 * @copyright (c) 2014 Keypic Inc
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);
$user->session_begin();
$auth->acl($user->data);
$user->setup();


if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'Keypic';

/*
* The name of the config variable which will hold the currently installed version
* UMIL will handle checking, setting, and updating the version itself.
*/
$version_config_name = 'keypic_version';


// The language file which will be included when installing
$language_file = 'mods/info_acp_keypic';


/*
* Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
* $phpbb_root_path will get prepended to the path specified
* Image height should be 50px to prevent cut-off or stretching.
*/
//$logo_img = 'styles/prosilver/imageset/site_logo.gif';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/
$versions = array(
	'1.0.0' => array(

		'table_column_add' => array(
			array(USERS_TABLE, 'KeypicToken', array('VCHAR', '')),
			array(USERS_TABLE, 'KeypicTS', array('VCHAR', '')),
			array(USERS_TABLE, 'KeypicSpam', array('VCHAR', '')),

			array(POSTS_TABLE, 'KeypicToken', array('VCHAR', '')),
			array(POSTS_TABLE, 'KeypicTS', array('VCHAR', '')),
			array(POSTS_TABLE, 'KeypicSpam', array('VCHAR', '')),
		),

		'config_add' => array(
			array('keypic_Formid', '', 0),
			array('keypic_SigninEnabled', 0, 0),
			array('keypic_SignupEnabled', 1, 0),
			array('keypic_PostEnabled', 1, 0),
			array('keypic_CommentEnabled', 1, 0),
			array('keypic_ForgotEnabled', 1, 0),

			array('keypic_SigninWidthHeight', '1x1', 0),
			array('keypic_SignupWidthHeight', '1x1', 0),
			array('keypic_PostWidthHeight', '1x1', 0),
			array('keypic_CommentWidthHeight', '1x1', 0),
			array('keypic_ForgotWidthHeight', '1x1', 0),
	
			array('keypic_SignupRequestType', 'getScript', 0),
			array('keypic_SigninRequestType', 'getScript', 0),
			array('keypic_PostRequestType', 'getScript', 0),
			array('keypic_CommentRequestType', 'getScript', 0),
			array('keypic_ForgotRequestType', 'getScript', 0),
		),

		//ACP Module
        'module_add' => array(
			array('acp', 'ACP_CAT_DOT_MODS', array(
                'module_enabled'   => 1,
                'module_display'   => 1,
                'module_langname'   => 'ACP_KEYPIC',
                'module_auth'      => 'acl_a_board',
                ),
             ),
             array('acp', 'ACP_KEYPIC', array(
                'module_basename' => 'keypic',
                'module_langname' => 'ACP_KEYPIC',
                'module_mode'   => 'settings',
                'module_auth' => 'acl_a_board',
             )),
        ),
	),
);

// Include the UMIL Auto file, it handles the rest
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);