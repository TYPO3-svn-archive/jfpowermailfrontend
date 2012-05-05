<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}



t3lib_extMgm::addStaticFile($_EXTKEY, 'static/default/',         'Powermail Frontend');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/default_css/',     'Powermail Frontend CSS');

$powermailVersion = NULL;
if (method_exists('t3lib_extMgm', 'getExtensionVersion2')) {
	$powermailVersion = t3lib_utility_VersionNumber::convertVersionNumberToInteger(t3lib_extMgm::getExtensionVersion('powermail'));
}
switch ($powermailVersion) {
	case $powermailVersion < 1005000 : {
		t3lib_extMgm::addStaticFile($_EXTKEY, 'static/powermail-1.4.x/', 'Powermail 1.4.x JS');
		break;
	}
	case $powermailVersion < 1006000 : {
		t3lib_extMgm::addStaticFile($_EXTKEY, 'static/powermail-1.5.x/', 'Powermail 1.5.x JS');
		break;
	}
	case $powermailVersion < 1007000 : {
		t3lib_extMgm::addStaticFile($_EXTKEY, 'static/powermail-1.6.x/', 'Powermail 1.6.x JS');
		break;
	}
	default : {
		t3lib_extMgm::addStaticFile($_EXTKEY, 'static/powermail-1.4.x/', 'Powermail 1.4.x JS');
		t3lib_extMgm::addStaticFile($_EXTKEY, 'static/powermail-1.5.x/', 'Powermail 1.5.x JS');
		t3lib_extMgm::addStaticFile($_EXTKEY, 'static/powermail-1.6.x/', 'Powermail 1.6.x JS');
		break;
	}
}



t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi1'] = 'layout,select_key';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';

t3lib_extMgm::addPlugin (
	array (
		'LLL:EXT:jfpowermailfrontend/locallang_db.xml:tt_content.list_type_pi1', 
		$_EXTKEY . '_pi1',
		t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
	),
	'list_type'
);

t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', 'FILE:EXT:jfpowermailfrontend/pi1/flexform_ds.xml');

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_jfpowermailfrontend_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'pi1/class.tx_jfpowermailfrontend_pi1_wizicon.php';
	include_once(t3lib_extMgm::extPath('jfpowermailfrontend') . 'lib/class.tx_jfpowermailfrontend_itemsProcFunc.php');
}
?>