<?php
/**
*
* info_acp_keypic [English]
*
* @package language
* @version $Id$
* @copyright (c) 2014 Keypic Inc
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}
// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
    'ACP_KEYPIC'                         	=> 'Keypic',
	'KP_INFO'			    				=> 'Information',
    'KP_MOD_VERSION'            			=> 'Version',
	'KP_SETTINGS'							=> 'Settings',
	'KP_INFO'								=> 'For many people, <a href="http://www.keypic.com/" target="_blank">Keypic</a> is quite possibly the best way in the world to protect your blog from comment and trackback spam. It keeps your site protected from spam even while you sleep. To get started:<ol>
													<li>Click the "Activate" link to the left of this description</li>
													<li><a href="http://www.keypic.com/?action=register" target="_blank">Sign up for a FormID</a>, and </li>
													<li>Go to your Keypic configuration page, and save FormID key.</li>
												</ol>',
	'KP_NO_FORMID_INFO'						=> 'Your FormID is empty, This plugin does not work without FormID, please <a href="http://keypic.com/?action=register" target="_blank">Get your FormID</a>.',
	
	'KP_FORMID'								=> 'FormID',
	'KEYPIC_FORMID_INVALID'					=> 'The FormID entered is invalid',
	
	'KP_SIGNIN_ENABLED'						=> 'Enabled on login form or not',
	'KP_FORGOT_ENABLED'						=> 'Enabled on forgot pasword form or not',
	'KP_SIGNUP_ENABLED'						=> 'Enabled on register form or not',
	'KP_POST_ENABLED'						=> 'Enabled on new topic form or not',
	'KP_COMMENT_ENABLED'					=> 'Enabled on new reply form or not',
	
	'KP_SIGNIN_WIDTHHEIGHT'					=> 'Width Height of login form',
	'KP_FORGOT_WIDTHHEIGHT'					=> 'Width Height of forgot password form',
	'KP_SIGNUP_WIDTHHEIGHT'					=> 'Width Height of register form',
	'KP_POST_WIDTHHEIGHT'					=> 'Width Height of new topic form',
	'KP_COMMENT_WIDTHHEIGHT'				=> 'Width Height of reply form',
	
	'KP_SIGNIN_REQUESTTYPE'					=> 'Request type of login form',
	'KP_FORGOT_REQUESTTYPE'					=> 'Request type of forgot password form',
	'KP_SIGNUP_REQUESTTYPE'					=> 'Request type of register form',
	'KP_POST_REQUESTTYPE'					=> 'Request type of new topic form',
	'KP_COMMENT_REQUESTTYPE'				=> 'Request type of reply form',
	
	'KEYPIC_ADMIN_CHECK_USER_HEAD'			=> 'Check user Spam Status',
	'KP_CU_TITLE_EXPLAIN'					=> 'Check user Spam Status by entering username in textbox',
	'KP_CU_TITLE'							=> 'Username',
	'KP_USER_SPAM_STATUS'					=> 'Spam Status is %s',
	'KP_NO_USER'							=> 'User with that username does not exists!',
	
	'KP_USER_SPAM_REPORTED' 				=> 'The user has been reported as spam sucessfully.',
	'KEYPIC_ADMIN_REPORT_USER_HEAD'			=> 'Report User as Spam',
	'KP_REPORT_TITLE_EXPLAIN'				=> 'Report User as Spam by entering username in textbox',
));