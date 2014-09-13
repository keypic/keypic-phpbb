<?php

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

$action = request_var('action', '');
include_once($phpbb_root_path . 'includes/keypic.'. $phpEx);
Keypic::setFormID($config['keypic_Formid']);
Keypic::setUserAgent("User-Agent: phpBB/".$config['version']." | Keypic/".$config['keypic_version']);


switch($action)
{
	case 'report':
		if (($t = request_var('t', '')) != '')
		{
			$sql     = 'SELECT topic_first_post_id FROM ' . TOPICS_TABLE . ' WHERE ' .  $db->sql_in_set('topic_id', $t);
			$result     = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			
			$sql     = 'SELECT * FROM ' . POSTS_TABLE . ' WHERE ' .  $db->sql_in_set('post_id', $row['topic_first_post_id']);
			$result     = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
	
			if (Keypic::reportSpam($row["KeypicToken"]) != 'error')
				trigger_error(sprintf($user->lang['KP_SPAM_REPORTED_MSG'], $user->lang['KP_TOPIC']));
			else
				redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
		}
		else if (($p = request_var('p', '')) != '')
		{
			$sql     = 'SELECT * FROM ' . POSTS_TABLE . ' WHERE ' .  $db->sql_in_set('post_id', $p);
			$result     = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			
			if (Keypic::reportSpam($row["KeypicToken"]) != 'error')
				trigger_error(sprintf($user->lang['KP_SPAM_REPORTED_MSG'], $user->lang['KP_POST']));
			else
				redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
		}
	break;
	
	case 'reportu':
		if (($u = request_var('u', '')) != '')
		{
			$users = 'SELECT KeypicToken FROM ' . USERS_TABLE . '
            WHERE user_id = ' . $u ;
			
			$users_result = $db->sql_query_limit($users, 1);
			$users_row = $db->sql_fetchrow($users_result);
			
			if (Keypic::reportSpam($users_row['KeypicToken']) != 'error')
				trigger_error(sprintf($user->lang['KP_SPAM_REPORTED_MSG'], $user->lang['KP_USER']));
			else
				redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
		}
		
		redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
	break;
	
	default:
		exit;
	break;
}