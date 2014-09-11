<?php
/**
*
* @author keypic (Keypic) info@keypic.com
* @package acp
* @version $Id$
* @copyright (c) 2014 Keypic Inc
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package module_install
*/
class acp_cleantalk_info
{
    function module()
    {
        return array(
            'filename'  => 'acp_keypic',
            'title'     => 'ACP_KEYPIC',
            'version'   => '0.0.1',
            'modes'     => array(
                'settings'      => array('title' => 'ACP_KEYPIC', 'auth' => 'acl_a_board', 'cat' => array('ACP_KEYPIC')),
            ),
        );
    }

    function install()
    {
    }

    function uninstall()
    {
    }
}