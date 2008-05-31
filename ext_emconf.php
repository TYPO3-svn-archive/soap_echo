<?php

########################################################################
# Extension Manager/Repository config file for ext: "soap_echo"
#
# Auto generated 27-04-2008 23:11
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'SOAP echo webservice',
	'description' => 'PEAR::SOAP based server with WSDL and methods ping, echoText, echoGermanUmlautText, getXML. You need the pear-Extension to install "SOAP" (switch to "beta"). This echo helps to test SOAP-clients and ESB.',
	'category' => 'module',
	'author' => 'ExtensionCoordinationTeam, Daniel Bruessler',
	'author_email' => 'danielb@typo3.org',
	'shy' => '',
	'dependencies' => 'pear',
	'conflicts' => '',
	'priority' => '',
	'module' => 'mod1',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.4',
	'constraints' => array(
		'depends' => array(
			'pear' => '',
			'php' => '5.0.0-5.99.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:18:{s:9:"ChangeLog";s:4:"ff65";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"20b7";s:14:"ext_tables.php";s:4:"8181";s:14:"ext_tables.sql";s:4:"9e49";s:24:"icon_tx_soapecho_log.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"63bd";s:10:"server.php";s:4:"8d0c";s:7:"tca.php";s:4:"4f9c";s:19:"doc/wizard_form.dat";s:4:"db7a";s:20:"doc/wizard_form.html";s:4:"afe2";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"d06b";s:14:"mod1/index.php";s:4:"5e5d";s:18:"mod1/locallang.xml";s:4:"504e";s:22:"mod1/locallang_mod.xml";s:4:"ef0c";s:19:"mod1/moduleicon.gif";s:4:"3f6b";s:35:"models/class.tx_soapecho_client.php";s:4:"6471";}',
	'suggests' => array(
	),
);

?>