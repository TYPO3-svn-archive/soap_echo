<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_soapecho_log"] = array (
	"ctrl" => $TCA["tx_soapecho_log"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "ip,datetime"
	),
	"feInterface" => $TCA["tx_soapecho_log"]["feInterface"],
	"columns" => array (
		"ip" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:soap_echo/locallang_db.xml:tx_soapecho_log.ip",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"datetime" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:soap_echo/locallang_db.xml:tx_soapecho_log.datetime",		
			"config" => Array (
				"type"     => "input",
				"size"     => "12",
				"max"      => "20",
				"eval"     => "datetime",
				"checkbox" => "0",
				"default"  => "0"
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "ip;;;;1-1-1, datetime")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>