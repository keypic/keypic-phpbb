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

include_once($phpbb_root_path . 'includes/Keypic.'. $phpEx);
Keypic::setFormID($config['keypic_Formid']);
Keypic::setUserAgent("User-Agent: phpBB/".$config['version']." | Keypic/".$config['keypic_version']);

switch($action){
	case 'report': 
		if (($t = request_var('t', '')) != '')
		{
			$topics = 'SELECT topic_first_post_id FROM ' . TOPICS_TABLE . '
				WHERE topic_id = ' . $t ;
				
			$topics_result = $db->sql_query_limit($topics, 1);

			while( $topics_row = $db->sql_fetchrow($topics_result) )
			{
				$posts = 'SELECT KeypicToken FROM ' . POSTS_TABLE . '
				WHERE post_id = ' . $topics_row['topic_first_post_id'] ;
				
				$posts_result = $db->sql_query_limit($posts, 1);

				while( $posts_row = $db->sql_fetchrow($posts_result) )
				{
					Keypic::reportSpam($posts_row['KeypicToken']);
					trigger_error(sprintf($user->lang['KP_SPAM_REPORTED_MSG'], $user->lang['KP_TOPIC']));
				}
			}
		}
		else if (($p = request_var('p', '')) != '')
		{
			$posts = 'SELECT KeypicToken FROM ' . POSTS_TABLE . '
            WHERE post_id = ' . $p ;
			
			$posts_result = $db->sql_query_limit($posts, 1);

			while( $posts_row = $db->sql_fetchrow($posts_result) )
			{
				Keypic::reportSpam($posts_row['KeypicToken']);
				trigger_error(sprintf($user->lang['KP_SPAM_REPORTED_MSG'], $user->lang['KP_POST']));
			}			
		}
		
		trigger_error('Post/Topic not found');
	break;
	
	default: echo 'Invalid Action';
	break;
}