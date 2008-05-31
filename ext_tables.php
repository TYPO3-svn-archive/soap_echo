<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_soapecho_log"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:soap_echo/locallang_db.xml:tx_soapecho_log',		
		'label'     => 'datetime',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY datetime DESC",	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_soapecho_log.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "ip, datetime",
	)
);


if (TYPO3_MODE == 'BE')	{
		
	t3lib_extMgm::addModule('tools','txsoapechoM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}
?>