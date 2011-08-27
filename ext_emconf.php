<?php

########################################################################
# Extension Manager/Repository config file for ext "jfpowermailfrontend".
#
# Auto generated 27-08-2011 20:29
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Powermail Frontend',
	'description' => 'Display powermail entries on the frontend',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.0.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'powermail' => '1.4.9-',
			'wt_doorman' => '1.3.0-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:37:{s:12:"ext_icon.gif";s:4:"34d9";s:17:"ext_localconf.php";s:4:"262c";s:14:"ext_tables.php";s:4:"9ac6";s:28:"ext_typoscript_constants.txt";s:4:"5a36";s:24:"ext_typoscript_setup.txt";s:4:"dc98";s:13:"locallang.xml";s:4:"4a7c";s:16:"locallang_db.xml";s:4:"bba8";s:39:"be/class.user_powermailfe_be_feuser.php";s:4:"4055";s:39:"be/class.user_powermailfe_be_fields.php";s:4:"4372";s:22:"be/flexform_ds_pi1.xml";s:4:"bf38";s:17:"css/sampleCSS.css";s:4:"1eab";s:14:"doc/manual.sxw";s:4:"2208";s:38:"lib/class.tx_jfpowermailfrontend_div.php";s:4:"f26b";s:49:"lib/class.tx_jfpowermailfrontend_dynamicmarkers.php";s:4:"aa58";s:45:"lib/class.tx_jfpowermailfrontend_filter_abc.php";s:4:"4a13";s:48:"lib/class.tx_jfpowermailfrontend_filter_search.php";s:4:"4bbb";s:42:"lib/class.tx_jfpowermailfrontend_markers.php";s:4:"8c0b";s:46:"lib/class.tx_jfpowermailfrontend_pagebrowser.php";s:4:"0c2a";s:36:"lib/user_powermailOnCurrentPage2.php";s:4:"e92c";s:42:"lib/user_powermailfrontend_pagebrowser.php";s:4:"a700";s:14:"pi1/ce_wiz.gif";s:4:"85a0";s:39:"pi1/class.tx_jfpowermailfrontend_edit.php";s:4:"7c7a";s:39:"pi1/class.tx_jfpowermailfrontend_list.php";s:4:"5060";s:38:"pi1/class.tx_jfpowermailfrontend_pi1.php";s:4:"61bc";s:46:"pi1/class.tx_jfpowermailfrontend_pi1_wizicon.php";s:4:"3e3a";s:41:"pi1/class.tx_jfpowermailfrontend_search.php";s:4:"ff67";s:41:"pi1/class.tx_jfpowermailfrontend_single.php";s:4:"b907";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"468d";s:28:"static/default_css/setup.txt";s:4:"6f36";s:23:"templates/tmpl_all.html";s:4:"66b7";s:24:"templates/tmpl_edit.html";s:4:"dda6";s:26:"templates/tmpl_latest.html";s:4:"b38f";s:24:"templates/tmpl_list.html";s:4:"85ec";s:31:"templates/tmpl_pagebrowser.html";s:4:"1919";s:26:"templates/tmpl_search.html";s:4:"dff5";s:26:"templates/tmpl_single.html";s:4:"3f37";}',
);

?>