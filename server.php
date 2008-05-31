<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2008 Daniel Bruessler (bruessler@patchworking.de)
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
/**
 * @author ExtensionCoordinationTeam,Daniel Bruessler <danielb@typo3.org>
 */

define('PATH_typo3conf', realpath('../../') .'/' ); // WITH trailing slash
setIncludePath(); // uncomment this if you have set it in global php.ini
$pearConfig =array();
$pearConfig['depends']['PEAR_SOAP'] = array(
	'SOAP', '0.11.0', 'pear'
);


error_reporting(E_ALL);
if (!includePEAR() )
{
    print getDependencyErrors('PEAR_SOAP');
    exit;
}

$server = new SOAP_Server;
$server->_auto_translation = true;
$echo_server = new tx_soapecho_server();
$server->addObjectMap($echo_server, 'SOAPEcho');

if (isset($_SERVER['REQUEST_METHOD']) &&
    $_SERVER['REQUEST_METHOD']=='POST')
{
    $server->service($HTTP_RAW_POST_DATA);
}
else
{
    $disco = new SOAP_DISCO_Server($server, 'SOAPEcho');
    header("Content-type: text/xml");
    if (isset($_SERVER['QUERY_STRING']) &&
       strcasecmp($_SERVER['QUERY_STRING'],'wsdl')==0) {
        print $disco->getWSDL();
    } else {
        print $disco->getDISCO();
    }
    exit;
}

// create a class for your soap functions
class tx_soapecho_server {
    var $__dispatch_map = array();
    var $__typedef     = array();

    function tx_soapecho_server() {
        /**
        * xml schema with the targetNamespace
        */
        $this->__typedef['{http://soapinterop.org/xsd}SOAPStruct'] = 
            array(
                'varString' => 'string',
                'varInt' => 'int', 
                'varFloat' => 'float',
                'varBoolean' => 'boolean',
                 );

    	$this->__dispatch_map['ping'] =
    		array('in' => array('inputString' => 'string'),
    		      'out' => array('outputString' => 'string'),
    		      );
    		      
        // an aliased function with multiple out parameters
        $this->__dispatch_map['echoStructAsSimpleTypes'] =
    		array('in' => array('inputStruct' => '{http://soapinterop.org/xsd}SOAPStruct'),
    		      'out' => array('outputString' => 'string', 'outputInteger' => 'int', 'outputFloat' => 'float'),
    		      'alias' => 'myEchoStructAsSimpleTypes'
    		      );
    		      
    	$this->__dispatch_map['echoStringSimple'] =
    		array('in' => array('inputStringSimple' => 'string'),
    		      'out' => array('outputStringSimple' => 'string'),
    		      );
    		      
    	$this->__dispatch_map['echoString'] =
    		array('in' => array('inputString' => 'string'),
    		      'out' => array('outputString' => 'string'),
    		      );
    		      
    	$this->__dispatch_map['echoText'] =
    		array('in' => array('inputString' => 'string'),
    		      'out' => array('outputString' => 'string'),
    		      );
    		      
    	$this->__dispatch_map['echoStruct'] =
    		array('in' => array('inputStruct' => '{http://soapinterop.org/xsd}SOAPStruct'),
    		      'out' => array('outputStruct' => '{http://soapinterop.org/xsd}SOAPStruct'),
    		      );
    		      
    	$this->__dispatch_map['getGermanUmlautText'] =
    		array('in' => array(),
    		      'out' => array('outputString' => 'string'),
    		      );
    	
    	$this->__dispatch_map['echoMimeAttachment'] = array();
    }

    /**
     * private function
     * determine any special dispatch information
     * to set up a dispatch map for functions that return multiple OUT parameters
     */
    function __dispatch($methodname) {
        if (isset($this->__dispatch_map[$methodname]))
            return $this->__dispatch_map[$methodname];
        return NULL;
    }
    
    // ping function
    function ping($inputString)
    {
        $res = 'PONG! Received request at '.date('l dS F Y h:i:s A (T O)', time());
	return new SOAP_Value('outputString','string',$res);
    }
    
    // an explicit echostring function
    function echoText($inputString)
    {
	return new SOAP_Value('outputString','string',$inputString);
    }
    
    // an explicit echostring function
    function getGermanUmlautText($inputString)
    {
        $res = 'ae oe ue ss AE OE UE EURO - äöüßÄÖÜ€';
        
	return new SOAP_Value('outputString','string',$res);
    }

    // a simple echoString function
    function echoStringSimple($inputString)
    {
	return $inputString;
    }
    
    // an explicit echostring function
    function echoString($inputString)
    {
	return new SOAP_Value('outputString','string',$inputString);
    }
    
    function echoMimeAttachment($stuff)
    {
        return new SOAP_Attachment('return','application/octet-stream',NULL,$stuff);
    }
} // end class


/****************************************************
 * this doesn't belong to the soap-class
 */
function setIncludePath()
{
    if (true) {
        $cur=ini_get('include_path');
        $result=array();
        $divider=(strpos($cur,':') >0 ) ? ':' : ';' ;
        $parts = explode($divider, $cur);
        $use=1;
        // ext/pear/PEAR must be first in the queue of any pear-repositories
        // no performance-prob because just 2 or three array-values
        foreach ($parts as $i => $v){
            if(strpos($v, 'pear') ){
                $result[] = PATH_typo3conf. 'pear/PEAR';
                $use=0;
            }
            $result[]= $v;
        }
        if($use){
         $result[] = PATH_typo3conf. 'pear/PEAR';
        }
        
        ini_set('include_path', implode($divider, $result) );

        if(ini_get('safe_mode')) {
           ini_set('safe_mode_include_dir', ini_get('safe_mode_include_dir') . $divider . PATH_typo3conf. 'pear/PEAR' );
        }

    }
    
}
    
function includePEAR($pkgArray=array('SOAP/Server.php', 'SOAP/Disco.php') )
{
    foreach($pkgArray as $i => $pkg)
    {
        // include_once, not require_once here
        @include_once($pkg);
    }
    return isPackageInstalled();
}
    
function getDependencyErrors($pkg='PEAR_SOAP')
{
    global $pearConfig;
    return 'An error has occurred - You need to install the PEAR-package "'.$pearConfig['depends'][$pkg][0] .'" '.$pearConfig['depends'][$pkg][1] .' or higher';
}
    
function isPackageInstalled($pkg='SOAP_Server')
{
    if(class_exists($pkg) )
    {
        return true;
    }
    return false;
}

?>