<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Juergen Furrer <juergen.furrer@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once (PATH_t3lib . 'class.t3lib_page.php');

/**
 * 'itemsProcFunc' for the 'jfpowermailfrontend' extension.
 *
 * @author     Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage tx_jfpowermailfrontend
 */
class tx_jfpowermailfrontend_itemsProcFunc
{
	private $limit = 10000; // limit for select query

	public function getFeUser(&$params, &$pObj)
	{
		// config
		$mode = $params['config']['itemsProcFunc_config']['mode']; // mode from xml

		if ($mode == 'feuser') { // show only feusers
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery ( // DB query
				'fe_users.uid, fe_users.username, fe_groups.title',
				'fe_users, fe_groups, sys_refindex',
				$where_clause = 'sys_refindex.tablename = "fe_users" AND sys_refindex.ref_table = "fe_groups" AND fe_users.uid=sys_refindex.recuid AND fe_groups.uid=sys_refindex.ref_uid' . t3lib_BEfunc::BEenableFields('fe_users'),
				$groupBy = 'fe_users.uid',
				$orderBy = 'fe_users.uid',
				$limit = $this->limit
			);
			if ($res) { // If there is a result
				$i=0;
				$params['items'][$i]['0'] = $pObj->sL('LLL:EXT:jfpowermailfrontend/locallang_db.xml:pi_flexform.feuser_owner'); // Option label
				$params['items'][$i]['1'] = 'owner'; // Option value
				while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) { // one loop for every db entry
					$i++; // increase counter
					$params['items'][$i]['0'] = $row['username']; // Option label
					$params['items'][$i]['1'] = $row['uid']; // Option value
				}
			}
		} elseif ($mode == 'fegroup') { // show groups
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery ( // DB query
				'fe_groups.title, fe_groups.uid',
				'fe_users, fe_groups, sys_refindex',
				$where_clause = 'sys_refindex.tablename = "fe_users" AND sys_refindex.ref_table = "fe_groups" AND fe_users.uid=sys_refindex.recuid AND fe_groups.uid=sys_refindex.ref_uid' . t3lib_BEfunc::BEenableFields('fe_users'),
				$groupBy = 'fe_groups.uid',
				$orderBy = 'fe_groups.uid',
				$limit = $this->limit
			);
			if ($res) { // If there is a result
				$i=0;
				$params['items'][$i]['0'] = $pObj->sL('LLL:EXT:jfpowermailfrontend/locallang_db.xml:pi_flexform.fegroup_owner'); // Option label
				$params['items'][$i]['1'] = 'ownergroup'; // Option value
				
				while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) { // one loop for every db entry
					$i++; // increase counter
					$params['items'][$i]['0'] = $row['title']; // Option label
					$params['items'][$i]['1'] = $row['uid']; // Option value
				}
			}
		}
	}

	function getFields(&$params, &$pObj)
	{
		// config
		$newarray = array(); //init
		$tree = t3lib_div::makeInstance('t3lib_queryGenerator'); // make instance for query generator class
		// Get pid where to search for powermails
		$pid_array = explode('|', $params['row']['pages']); // preflight for startingpoint
		if ($pid_array[0] == '') {
			return array();
		}
		$pid = $tree->getTreeList(str_replace(array('pages_'), '', $pid_array[0]), $params['row']['recursive'], 0, 1); // get list of pages from starting point recursive
		// SQL query
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery ( // DB query
			'tx_powermail_mails.piVars',
			'tx_powermail_mails',
			$where_clause = (intval($pid) > 0 ? 'pid IN ('.$pid.')' : '1') . t3lib_BEfunc::BEenableFields('tx_powermail_mails'),
			$groupBy = '',
			$orderBy = 'tx_powermail_mails.uid DESC',
			$limit = $this->limit
		);
		if ($res) { // If there is a result
			// 1. Collecting different field uids to an array
			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) { // one loop for every db entry
				$row['piVars'] = t3lib_div::convUmlauts($row['piVars']); // converting umlauts
				$array = t3lib_div::xml2array($row['piVars'], 'piVars'); // current xml to array
				if (!is_array($array)) $array = utf8_encode(t3lib_div::xml2array($row['piVars'],'piVars')); // current xml to array
				
				if (is_array($array) && isset($array)) { // if array esists
					foreach ($array as $key => $value) { // one loop for every value
						if (is_numeric(str_replace('uid', '', $key))) { // if field is like uid34
							if (!in_array($key, $newarray)) {
								$newarray[] = $key; // add key to list if key don't exist in list
							}
						}
					}
				}
			}
			// 2. Sorting array
			sort($newarray);
			// 3. Return to backend
			if (is_array($newarray) && isset($newarray)) { // if array esists
				for ($i=0; $i < count($newarray); $i++) { // one loop for every value
					
					// Manipulate options
					$params['items'][$i]['0'] = $this->getTitle($newarray[$i]).' ('.$newarray[$i].')'; // Option name
					$params['items'][$i]['1'] = $newarray[$i]; // Option value
					
				}
			}
		}
		// 4. Add the first option if needed
		if ($params['config']['itemsProcFunc_config']['mode'] == 'fieldsAndOff') { // First param should be '[deactivated]'
			array_unshift($params['items'], array($pObj->sL('LLL:EXT:jfpowermailfrontend/locallang_db.xml:pi_flexform.empty'), '')); // add first param with text and no value
		} elseif ($params['config']['itemsProcFunc_config']['mode'] == 'fieldsAndOverall') { // First param should be '[search in all fields]'
			array_unshift($params['items'], array($pObj->sL('LLL:EXT:jfpowermailfrontend/locallang_db.xml:pi_flexform.searchAll'), '_all')); // add first param with text and * as value
		}
	}

	// Function getTitle() gets title for any uid
	function getTitle($uid)
	{
		$uid = str_replace('uid', '', $uid); // uid23 to 23
		// SQL query
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery ( // DB query
			'title',
			'tx_powermail_fields',
			$where_clause = 'uid = '.$uid,
			$groupBy = '',
			$orderBy = '',
			$limit = 1
		);
		if ($res) {
			$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		}
		if ($row['title']) {
			return $row['title'];
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfpowermailfrontend/lib/class.tx_jfpowermailfrontend_itemsProcFunc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfpowermailfrontend/lib/class.tx_jfpowermailfrontend_itemsProcFunc.php']);
}
?>