<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Banlist
 *
 * @package Banlist
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2010
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$db_banlist = (isset($db_banlist)) ? $db_banlist : $db_x . 'banlist';

$userip = explode('.', $usr['ip']);
$ipmasks = "('".$userip[0].'.'.$userip[1].'.'.$userip[2].'.'.$userip[3]."','".$userip[0].'.'.$userip[1].'.'.$userip[2].".*','".$userip[0].'.'.$userip[1].".*.*','".$userip[0].".*.*.*')";

$sql = $db->query("SELECT banlist_id, banlist_ip, banlist_reason, banlist_expire FROM $db_banlist WHERE banlist_ip IN ".$ipmasks);

if ($sql->rowCount() > 0)
{
	$row = $sql->fetch();
	if ($sys['now'] > $row['banlist_expire'] && $row['banlist_expire'] > 0)
	{
		$sql = $db->query("DELETE FROM $db_banlist WHERE banlist_id='".$row['banlist_id']."' LIMIT 1");
	}
	else
	{
		// TODO internationalize this
		$disp = 'Your IP is banned.<br />Reason: '.$row['banlist_reason'].'<br />Until: ';
		$disp .= ($row['banlist_expire'] > 0) ? @date($cfg['dateformat'], $row['banlist_expire']).' GMT' : 'Never expire.';
		cot_diefatal($disp);
	}
}

?>