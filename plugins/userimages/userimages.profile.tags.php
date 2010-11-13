<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=profile.tags
[END_COT_EXT]
==================== */

/**
 * Avatar and photo for users
 *
 * @package userimages
 * @version 0.9.0
 * @author Koradhil, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2010
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

cot_require('userimages', true);
$userimages = cot_userimages_config_get();

// cot_require('userimages', true, 'resources'); whats wrong with this ???
require_once cot_incfile('userimages', 'resources', $is_plugin = true);

foreach($userimages as $code => $settings)
{
	$userimg_existing = !empty($urr['user_'.$code]) ? cot_rc('userimg_existing', array(
		'url_file' => $urr['user_'.$code],
		'url_delete' => cot_url('plug', 'e=userimages&a=delete&code='.$code.'&'.cot_xg())
	)) : '';
	$userimg_selectfile = cot_rc('userimg_selectfile', array(
		'form_input' => cot_inputbox('file', $code, '', array('size' => 24))
	));
	$userimg_html = cot_rc('userimg_html', array(
		'code' => $code,
		'existing' => $userimg_existing,
		'selectfile' => $userimg_selectfile
	));
	$t->assign(array(
		"USERS_PROFILE_".strtoupper($code) => $userimg_html,
		"USERS_PROFILE_".strtoupper($code)."_SELECT" => $userimg_selectfile
	));
}

?>