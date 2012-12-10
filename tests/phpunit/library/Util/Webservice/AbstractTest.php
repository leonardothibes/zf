<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: AbstractTest.php 12/12/2011 08:25:22 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/** Classe de teste **/
class Util_Webservice_Extends extends Util_Webservice_Abstract {}

/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Webservice_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Webservice_Abstract
     */
    protected $object;
    
    /**
     * @var string
     */
    protected $wsdl = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    	$this->wsdl   = Zend_Registry::get('tests')->webservice->client->wsdl;
        $this->object = new Util_Webservice_Extends($this->wsdl);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }
    
    /**
     * Provider de nomes de classes pai.
     * @return array
     */
    public function providerParents()
    {
    	return array(
    		array('Util_Model_Abstract'),
	    	array('Zend_Cache'),
	    	array('Util_Model_Interface')
    	);
    }
    
	/**
     * Testando se extende as classes certas.
     * @dataProvider providerParents
     */
    public function testExtends($parentName)
    {
    	$this->assertType($parentName , $this->object);
    }
	
    /**
     * Testando se a classe é abstrata.
     */
    public function testIsAbstract()
    {
    	$class      = get_class($this->object);
    	$reflection = new ReflectionClass($class);
    	$parent     = $reflection->getParentClass()->name;
    	
    	$reflection = new ReflectionClass($parent);
    	$this->assertTrue($reflection->isAbstract());
    }
    
    /**
     * Testando a configuração de wsdl.
     */
    public function testSetWsdl()
    {
    	$wsdl = $this->wsdl . '&oi=true';
        $rs   = $this->object->setWsdl($wsdl);
        $this->assertType('Util_Webservice_Interface', $rs);
        
        $rs = $this->object->getWsdl();
        $this->assertType('string', $rs);
        $this->assertEquals($wsdl, $rs);
    }

    /**
     * Testando a recuperação do wsdl.
     */
    public function testGetWsdl()
    {
    	//Testando o wsdl configurado no construtor da classe.
        $rs = $this->object->getWsdl();
        $this->assertType('string', $rs);
        $this->assertEquals($this->wsdl, $rs);
        
        //Alterando e testando.
        $wsdl = $this->wsdl . '&oi=true';
        $rs   = $this->object->setWsdl($wsdl);
        $this->assertType('Util_Webservice_Interface', $rs);
        
        $rs = $this->object->getWsdl();
        $this->assertType('string', $rs);
        $this->assertEquals($wsdl, $rs);
    }
}
