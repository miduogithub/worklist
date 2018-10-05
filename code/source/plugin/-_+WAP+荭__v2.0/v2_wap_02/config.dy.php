<?php
/*
Author:²Ý.¸ù.°É
Website:www.Caogen8.Co
Qq:2575-163-778
*/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once libfile('function/plugin');
require_once libfile('function/admincp');
$orderadd="";
if($_GET['pmod']=='n1') $orderadd="and displayorder>=1 and displayorder<=18";
if($_GET['pmod']=='n2') $orderadd="and displayorder>=19 and displayorder<=21";
if($_GET['pmod']=='n3') $orderadd="and displayorder>=22 and displayorder<=30";
if($_GET['pmod']=='n4') $orderadd="and displayorder>=31 and displayorder<=37";
if($_GET['pmod']=='n5') $orderadd="and displayorder>=38 and displayorder<=65";
if($_GET['pmod']=='n6') $orderadd="and displayorder>=66 and displayorder<=86";
if($_GET['pmod']=='n7') $orderadd="and displayorder>=87 and displayorder<=99";

	if(empty($pluginid) && !empty($do)) {
		$pluginid = $do;
	}
	if($_GET['identifier']) {
		$plugin = C::t('common_plugin')->fetch_by_identifier($_GET['identifier']);
	} else {
		$plugin = C::t('common_plugin')->fetch($pluginid);
	}
	if(!$plugin) {
		cpmsg('plugin_not_found', '', 'error');
	} else {
		$pluginid = $plugin['pluginid'];
	}

	$plugin['modules'] = dunserialize($plugin['modules']);

	$pluginvars = array();

	$rs=DB::fetch_all("SELECT * 
FROM  ".DB::table("common_pluginvar")." 
WHERE  `pluginid` ='$pluginid' $orderadd
order by displayorder asc
");
	foreach($rs as $var) {
		if(strexists($var['type'], '_')) {
			continue;
		}
		$pluginvars[$var['variable']] = $var;
	}

	if($pluginvars) {
		$submenuitem[] = array('config', "plugins&operation=config&do=$pluginid", !$_GET['pmod']);
	}
	if(is_array($plugin['modules'])) {
		foreach($plugin['modules'] as $module) {
			if($module['type'] == 3) {
				parse_str($module['param'], $param);
				if(!$pluginvars && empty($_GET['pmod'])) {
					$_GET['pmod'] = $module['name'];
					if($param) {
						foreach($param as $_k => $_v) {
							$_GET[$_k] = $_v;
						}
					}
				}
				if($param) {
					$m = true;
					foreach($param as $_k => $_v) {
						if(!isset($_GET[$_k]) || $_GET[$_k] != $_v) {
							$m = false;
							break;
						}
					}
				} else {
					$m = true;
				}
				$submenuitem[] = array($module['menu'], "plugins&operation=config&do=$pluginid&identifier=$plugin[identifier]&pmod=$module[name]".($module['param'] ? '&'.$module['param'] : ''), $_GET['pmod'] == $module['name'] && $m, !$_GET['pmod'] ? 1 : 0);
			}
		}
	}

		if(!submitcheck('editsubmit')) {
			$operation = '';
			shownav('plugin', $plugin['name']);

			if($pluginvars) {
				showformheader('plugins&operation=config&do='.$pluginid.'&identifier='.$_GET['identifier'].'&pmod='.$_GET['pmod']);
				showtableheader();

				$extra = array();
				foreach($pluginvars as $var) {
					if(strexists($var['type'], '_')) {
						continue;
					}
					$var['variable'] = 'varsnew['.$var['variable'].']';
					if($var['type'] == 'number') {
						$var['type'] = 'text';
					} elseif($var['type'] == 'select') {
						$var['type'] = "<select name=\"$var[variable]\">\n";
						foreach(explode("\n", $var['extra']) as $key => $option) {
							$option = trim($option);
							if(strpos($option, '=') === FALSE) {
								$key = $option;
							} else {
								$item = explode('=', $option);
								$key = trim($item[0]);
								$option = trim($item[1]);
							}
							$var['type'] .= "<option value=\"".dhtmlspecialchars($key)."\" ".($var['value'] == $key ? 'selected' : '').">$option</option>\n";
						}
						$var['type'] .= "</select>\n";
						$var['variable'] = $var['value'] = '';
					} elseif($var['type'] == 'selects') {
						$var['value'] = dunserialize($var['value']);
						$var['value'] = is_array($var['value']) ? $var['value'] : array($var['value']);
						$var['type'] = "<select name=\"$var[variable][]\" multiple=\"multiple\" size=\"10\">\n";
						foreach(explode("\n", $var['extra']) as $key => $option) {
							$option = trim($option);
							if(strpos($option, '=') === FALSE) {
								$key = $option;
							} else {
								$item = explode('=', $option);
								$key = trim($item[0]);
								$option = trim($item[1]);
							}
							$var['type'] .= "<option value=\"".dhtmlspecialchars($key)."\" ".(in_array($key, $var['value']) ? 'selected' : '').">$option</option>\n";
						}
						$var['type'] .= "</select>\n";
						$var['variable'] = $var['value'] = '';
					} elseif($var['type'] == 'date') {
						$var['type'] = 'calendar';
						$extra['date'] = '<script type="text/javascript" src="static/js/calendar.js"></script>';
					} elseif($var['type'] == 'datetime') {
						$var['type'] = 'calendar';
						$var['extra'] = 1;
						$extra['date'] = '<script type="text/javascript" src="static/js/calendar.js"></script>';
					} elseif($var['type'] == 'forum') {
						require_once libfile('function/forumlist');
						$var['type'] = '<select name="'.$var['variable'].'"><option value="">'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $var['value'], TRUE).'</select>';
						$var['variable'] = $var['value'] = '';
					} elseif($var['type'] == 'forums') {
						$var['description'] = ($var['description'] ? (isset($lang[$var['description']]) ? $lang[$var['description']] : $var['description'])."\n" : '').$lang['plugins_edit_vars_multiselect_comment']."\n".$var['comment'];
						$var['value'] = dunserialize($var['value']);
						$var['value'] = is_array($var['value']) ? $var['value'] : array();
						require_once libfile('function/forumlist');
						$var['type'] = '<select name="'.$var['variable'].'[]" size="10" multiple="multiple"><option value="">'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, 0, TRUE).'</select>';
						foreach($var['value'] as $v) {
							$var['type'] = str_replace('<option value="'.$v.'">', '<option value="'.$v.'" selected>', $var['type']);
						}
						$var['variable'] = $var['value'] = '';
					} elseif(substr($var['type'], 0, 7) == 'group') {
						if($var['type'] == 'groups') {
							$var['description'] = ($var['description'] ? (isset($lang[$var['description']]) ? $lang[$var['description']] : $var['description'])."\n" : '').$lang['plugins_edit_vars_multiselect_comment']."\n".$var['comment'];
							$var['value'] = dunserialize($var['value']);
							$var['type'] = '<select name="'.$var['variable'].'[]" size="10" multiple="multiple"><option value=""'.(@in_array('', $var['value']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>';
						} else {
							$var['type'] = '<select name="'.$var['variable'].'"><option value="">'.cplang('plugins_empty').'</option>';
						}
						$var['value'] = is_array($var['value']) ? $var['value'] : array($var['value']);

						$query = C::t('common_usergroup')->range_orderby_credit();
						$groupselect = array();
						foreach($query as $group) {
							$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
							$groupselect[$group['type']] .= '<option value="'.$group['groupid'].'"'.(@in_array($group['groupid'], $var['value']) ? ' selected' : '').'>'.$group['grouptitle'].'</option>';
						}
						$var['type'] .= '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
							($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
							($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
							'<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup></select>';
						$var['variable'] = $var['value'] = '';
					} elseif($var['type'] == 'extcredit') {
						$var['type'] = '<select name="'.$var['variable'].'"><option value="">'.cplang('plugins_empty').'</option>';
						foreach($_G['setting']['extcredits'] as $id => $credit) {
							$var['type'] .= '<option value="'.$id.'"'.($var['value'] == $id ? ' selected' : '').'>'.$credit['title'].'</option>';
						}
						$var['type'] .= '</select>';
						$var['variable'] = $var['value'] = '';
					}

					showsetting(isset($lang[$var['title']]) ? $lang[$var['title']] : dhtmlspecialchars($var['title']), $var['variable'], $var['value'], $var['type'], '', 0, isset($lang[$var['description']]) ? $lang[$var['description']] : nl2br(dhtmlspecialchars($var['description'])), dhtmlspecialchars($var['extra']), '', true);
				}
				showsubmit('editsubmit');
				showtablefooter();
				showformfooter();
				echo implode('', $extra);
			}

		} else {

			if(is_array($_GET['varsnew'])) {
				foreach($_GET['varsnew'] as $variable => $value) {
					if(isset($pluginvars[$variable])) {
						if($pluginvars[$variable]['type'] == 'number') {
							$value = (float)$value;
						} elseif(in_array($pluginvars[$variable]['type'], array('forums', 'groups', 'selects'))) {
							$value = serialize($value);
						}
						$value = (string)$value;
						C::t('common_pluginvar')->update_by_variable($pluginid, $variable, array('value' => $value));
					}
				}
			}

			updatecache(array('plugin', 'setting', 'styles'));
			cleartemplatecache();
			cpmsg('plugins_setting_succeed', 'action=plugins&operation=config&do='.$pluginid.'&anchor='.$anchor.'&identifier='.$_GET['identifier'].'&pmod='.$_GET['pmod'], 'succeed');			
			
		}
?>