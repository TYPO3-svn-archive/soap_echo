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
 * model - to get WSDL for BE
 * @author ExtensionCoordinationTeam,Daniel Bruessler <danielb@typo3.org>
 */
        
class tx_soapecho_client {
    var $pearConfig = array(
        'depends' => array(
            'PEAR_SOAP' => array('SOAP', '0.11.0', 'pear'),
        ),
    );
    
    var $LANG;
    
    function setLANG(&$LANG)
    {
        $this->LANG = $LANG;
    }
    
    function includePEAR($pkgArray=array('SOAP/Client.php') )
    {
        foreach($pkgArray as $i => $pkg)
        {
            // include_once, not require_once here
            @include_once($pkg);
        }
        return $this->isPackageInstalled();
    }
    
    function isPackageInstalled($pkg='SOAP_WSDL')
    {        
        if(class_exists($pkg) )
        {
            return true;
        }
        return false;
    }
    
    function getDependencyErrors($pkg='PEAR_SOAP')
    {
        return $this->LANG->getLL('error_PEAR_dependency') . ' "'.$this->pearConfig['depends'][$pkg][0] .'" '.$this->pearConfig['depends'][$pkg][1] .' '. $this->LANG->getLL('error_PEAR_dependency2');
    }
    
    function getServerAddress()
    {        
        $host = t3lib_div::getIndpEnv('HTTP_HOST');
        return 'http://'. $host. '/typo3conf/ext/soap_echo/server.php?wsdl';
    }
    
    function getInfoFromEchoServer()
    {
        $content='';
        // to include the PEAR-package the function includePEAR() must be called
        
        $host = t3lib_div::getIndpEnv('HTTP_HOST');

        $wsdl = new SOAP_WSDL($this->getServerAddress() );
        $soapclient = $wsdl->getProxy();
        
        $res = $soapclient->echoText('Hello echo!');
        $content .= '<strong>echoText= "'.$res. '"</strong> ('. $this->LANG->getLL('tests_expected') .': "Hello echo!")';
        #print_r($soapclient);
        
        $res = $soapclient->ping('');
        $content .= '<br /> <br />ping= "'.$res. '"';
        #print_r($soapclient);
        
        $content .= "<br />\n\n";

        unset($soapclient);
        return $content;
    }
    
    function getInfoForIP($ipString, $name='')
    {
        $content='';
        // to include the PEAR-package the function includePEAR() must be called

        $content .= '<strong>IP '. $ipString .$name.'</strong><br />';
        $wsdl = new SOAP_WSDL('http://webservices.tekever.eu/ip2pais/index.php?wsdl');
        $soapclient = $wsdl->getProxy();
        $res = $soapclient->IP2Pais($ipString);
        $content .= $this->LANG->getLL('country'). ' '.$res->pais.', '. $this->LANG->getLL('continent') .' '.$res->regiao.', '. $this->LANG->getLL('currency') .' '.$res->moeda;
        #print_r($soapclient);
        $content .= "<br />\n\n";

        unset($soapclient);
        return $content;
    }
	
}
?>