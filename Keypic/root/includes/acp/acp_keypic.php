<?php
/**
*
* @package acp
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
    exit;
}

function getwidthheight()
{
	$widthHeight = array(
		"1x1" => 'Lead square transparent 1x1 pixel',
		"336x280" => 'Large rectangle (336 x 280) (Most Common)',
		"300x250" => 'Medium Rectangle (300 x 250)',
		"728x90" => 'Leaderboard (728 x 90)',
		"160x600" => 'Wide Skyscraper (160 x 600)',
		"250x250" => 'Square Pop-Up (250 x 250)',
		"720x300" => 'Pop-under (720 x 300)',
		"468x60" => 'Full Banner (468 x 60)',
		"234x60" => 'Half Banner (234 x 60)',
		"120x600" => 'Skyscraper (120 x 600)',
		"300x600" => 'Half Page Ad (300 x 600)'
	);
	
	$style_options = '';
	foreach($widthHeight as $k => $v)
	{
		 $style_options .= '<option value="' . $k . '">' . $v . '</option>';
	}
	
	return $style_options;
}

function getrequesttype()
{
	$requestType = array(
		'getScript' => 'getScript',
	);
	
	$style_options = '';
	foreach($requestType as $k => $v)
	{
		 $style_options .= '<option value="' . $k . '">' . $v . '</option>';
	}
	
	return $style_options;
}

/**
* @package acp
*/
class acp_keypic
{
    public $u_action;
    public $new_config = array();

    function main($id, $mode)
    {
        global $db, $user, $auth, $template;
        global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
        global $cache;

        $user->add_lang('acp/board');

        $action = request_var('action', '');
        $submit = (isset($_POST['submit'])) ? true : false;

        $form_key = 'acp_keypic';
        add_form_key($form_key);

        /**
        *   Validation types are:
        *       string, int, bool,
        *       script_path (absolute path in url - beginning with / and no trailing slash),
        *       rpath (relative), rwpath (realtive, writable), path (relative path, but able to escape the root), wpath (writable)
        */
        switch ($mode)
        {
            case 'settings':
                $display_vars = array(
						'title' => 'ACP_KEYPIC',
						'vars'  => array(
							'legend1'               => 'KP_SETTINGS',
							'keypic_Formid'           => array('lang' => 'KP_FORMID',  'validate' => 'string', 'type' => 'text:40:255', 'explain' => true),

							'keypic_SigninEnabled' => array('lang' => 'KP_SIGNIN_ENABLED',  'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
							'keypic_SignupEnabled' => array('lang' => 'KP_SIGNUP_ENABLED',  'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
							'keypic_PostEnabled' => array('lang' => 'KP_POST_ENABLED',  'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
							'keypic_CommentEnabled' => array('lang' => 'KP_COMMENT_ENABLED',  'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
							'keypic_ForgotEnabled' => array('lang' => 'KP_FORGOT_ENABLED',  'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
							
							'keypic_SigninWidthHeight' =>  array('lang' => 'KP_SIGNIN_WIDTHHEIGHT',  'validate' => 'string', 'type' => 'select', 'function' => 'getwidthheight', 'explain' => true),
							'keypic_SignupWidthHeight' =>  array('lang' => 'KP_SIGNUP_WIDTHHEIGHT',  'validate' => 'string', 'type' => 'select', 'function' => 'getwidthheight', 'explain' => true),
							'keypic_PostWidthHeight' =>  array('lang' => 'KP_POST_WIDTHHEIGHT',  'validate' => 'string', 'type' => 'select', 'function' => 'getwidthheight', 'explain' => true),
							'keypic_CommentWidthHeight' =>  array('lang' => 'KP_COMMENT_WIDTHHEIGHT',  'validate' => 'string', 'type' => 'select', 'function' => 'getwidthheight', 'explain' => true),
							'keypic_ForgotWidthHeight' =>  array('lang' => 'KP_FORGOT_WIDTHHEIGHT',  'validate' => 'string', 'type' => 'select', 'function' => 'getwidthheight', 'explain' => true),
						
							'keypic_SigninRequestType' =>  array('lang' => 'KP_SIGNIN_REQUESTTYPE',  'validate' => 'string', 'type' => 'select', 'function' => 'getrequesttype', 'explain' => true),
							'keypic_SignupRequestType' =>  array('lang' => 'KP_SIGNUP_REQUESTTYPE',  'validate' => 'string', 'type' => 'select', 'function' => 'getrequesttype', 'explain' => true),
							'keypic_PostRequestType' =>  array('lang' => 'KP_POST_REQUESTTYPE',  'validate' => 'string', 'type' => 'select', 'function' => 'getrequesttype', 'explain' => true),
							'keypic_CommentRequestType' =>  array('lang' => 'KP_COMMENT_REQUESTTYPE',  'validate' => 'string', 'type' => 'select', 'function' => 'getrequesttype', 'explain' => true),
							'keypic_ForgotRequestType' =>  array('lang' => 'KP_FORGOT_REQUESTTYPE',  'validate' => 'string', 'type' => 'select', 'function' => 'getrequesttype', 'explain' => true),
						
							'legend2'               => 'ACP_SUBMIT_CHANGES',
						),	
						'title' => 'ACP_KEYPIC',
                );
            break;

            default:
                trigger_error('NO_MODE', E_USER_ERROR);
            break;
        }

        if (isset($display_vars['lang']))
        {
            $user->add_lang($display_vars['lang']);
        }

        $this->new_config = $config;
        $cfg_array = (isset($_REQUEST['config'])) ? utf8_normalize_nfc(request_var('config', array('' => ''), true)) : $this->new_config;
        $error = array();

        // We validate the complete config if whished
        validate_config_vars($display_vars['vars'], $cfg_array, $error);

        if ($submit && !check_form_key($form_key))
        {
            $error[] = $user->lang['FORM_INVALID'];
        }
		
		include_once($phpbb_root_path . 'includes/Keypic.'. $phpEx);
		$checkFormID = Keypic::checkFormID($_POST['config']['keypic_Formid']);
		if ($submit && (strlen($_POST['config']['keypic_Formid'])  > 0) && ($checkFormID["status"] == "error"))
        {
            $error[] = $user->lang['KEYPIC_FORMID_INVALID'];
        }
		
        // Do not write values if there is an error
        if (sizeof($error))
        {
             $submit = false;
        }
		
		if ($submit && isset($_POST['susername']))
		{
			$sql = 'SELECT * FROM ' . USERS_TABLE . '
					WHERE ' . ('username_clean = \'' . $db->sql_escape(utf8_clean_string(request_var('susername', ''))) . '\'');
			$result = $db->sql_query($sql);
			$user_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$user_row)
			{
				trigger_error($user->lang['KP_NO_USER']. adm_back_link($this->u_action));
			}
			
			Keypic::setFormID($config['keypic_Formid']);
			Keypic::setUserAgent("User-Agent: phpBB/".$config['version']." | Keypic/".$config['keypic_version']);
			Keypic::reportSpam($user_row['KeypicToken']);
			
			trigger_error($user->lang['KP_USER_SPAM_REPORTED'] . adm_back_link($this->u_action));
		}
		
		if ($submit && isset($_POST['username']))
		{
			$sql = 'SELECT * FROM ' . USERS_TABLE . '
					WHERE ' . ('username_clean = \'' . $db->sql_escape(utf8_clean_string(request_var('username', ''))) . '\'');
			$result = $db->sql_query($sql);
			$user_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$user_row)
			{
				trigger_error($user->lang['KP_NO_USER']. adm_back_link($this->u_action));
			}
	
			trigger_error(sprintf($user->lang['KP_USER_SPAM_STATUS'], (($user_row['KeypicSpam'] != '') ? $user_row['KeypicSpam'] : 0).'%') . adm_back_link($this->u_action));
		}

        // We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
        foreach ($display_vars['vars'] as $config_name => $null)
        {
            if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
            {
                continue;
            }

            $this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

            if ($submit)
            {
                set_config($config_name, $config_value);
            }
        }

        if ($submit)
        {
            add_log('admin', 'LOG_CONFIG_' . strtoupper($mode));

            trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
        }

        $this->tpl_name = 'acp_keypic';
        $this->page_title = $display_vars['title'];

        $template->assign_vars(array(
            'L_TITLE'           => $user->lang[$display_vars['title']],
            'L_TITLE_EXPLAIN'   => $user->lang[$display_vars['title'] . '_EXPLAIN'],

            'S_ERROR'           => (sizeof($error)) ? true : false,
            'ERROR_MSG'         => implode('<br />', $error),

            'U_ACTION'          => $this->u_action,
            'KP_MOD_VERSION'       => isset($config['keypic_version']) ? $config['keypic_version'] : '-',
            )
        );

        // Output relevant page
        foreach ($display_vars['vars'] as $config_key => $vars)
        {
            if (!is_array($vars) && strpos($config_key, 'legend') === false)
            {
                continue;
            }

            if (strpos($config_key, 'legend') !== false)
            {
                $template->assign_block_vars('options', array(
                    'S_LEGEND'      => true,
                    'LEGEND'        => (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
                );

                continue;
            }

            $type = explode(':', $vars['type']);

            $l_explain = '';
            if ($vars['explain'] && isset($vars['lang_explain']))
            {
                $l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
            }
            else if ($vars['explain'])
            {
                $l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
            }

            $content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

            if (empty($content))
            {
                continue;
            }

            $template->assign_block_vars('options', array(
                'KEY'           => $config_key,
                'TITLE'         => (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
                'S_EXPLAIN'     => $vars['explain'],
                'TITLE_EXPLAIN' => $l_explain,
                'CONTENT'       => $content,
                )
            );

            unset($display_vars['vars'][$config_key]);
        }
    }

}