<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: AbstractTest.php 12/12/2011 08:45:14 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/** Classe de teste **/
class Util_Webservice_Client_Extends extends Util_Webservice_Client_Abstract {}

/**
 * @category Tests
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Webservice_Client_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Webservice_Client_Abstract
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
        $this->object = new Util_Webservice_Client_Extends($this->wsdl);
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
    		array('Util_Webservice_Abstract'),
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
     * Testando a classe cliente default.
     */
    public function testGetNativeClient()
    {
    	$rs = $this->object->getNativeClient();
    	$this->assertType('bool', $rs);
    	$this->assertFalse($rs);
    }
    
    /**
     * Testando a troca de classe cliente.
     */
    public function testSetNativeClient()
    {
    	//Trocando a troca de classe e verificando se a troca foi efetivada.
    	$flag1 = $this->object->getNativeClient();
    	$this->assertFalse($flag1);
    	
    	$rs = $this->object->setNativeClient();
		$this->assertType('Util_Webservice_Client_Interface', $rs);
    	
		$flag2 = $this->object->getNativeClient();
    	$this->assertTrue($flag2);
    	
    	//Desativando a troca e verificando a alteração.
    	$rs = $this->object->setNativeClient(false);
		$this->assertType('Util_Webservice_Client_Interface', $rs);
		
		$flag2 = $this->object->getNativeClient();
    	$this->assertFalse($flag2);
    }
    
    /**
     * Testando o hash padrão, que é em branco.
     */
    public function testGetHash()
    {
    	$rs = $this->object->getHash();
    	$this->assertType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }
    
    /**
     * Testando a configuração de hash.
     */
    public function testSetHash()
    {
    	$hash1 = Zend_Registry::get('tests')->webservice->client->param1;
    	$hash2 = $hash1 . rand(100,200);
    	
    	//Configurando um hash e testando a recuperação do mesmo.
    	$rs = $this->object->setHash($hash1);
    	$this->assertType('Util_Webservice_Client_Interface', $rs);
    	
    	$rs = $this->object->getHash();
    	$this->assertEquals($hash1, $rs);
    	
    	//Alterando o hash e testando a recuperação do mesmo.
    	$rs = $this->object->setHash($hash2);
    	$this->assertType('Util_Webservice_Client_Interface', $rs);
    	
    	$rs = $this->object->getHash();
    	$this->assertEquals($hash2, $rs);
    }
    
    /**
     * Testando a ativação de auto xml.
     */
    public function testSetAutoXmlDecode()
    {
    	//Testando com valor default da flag.
        $rs = $this->object->setAutoXmlDecode();
        $this->assertType('Util_Webservice_Client_Interface', $rs);
        
        $rs = $this->object->getAutoXmlDecode();
        $this->assertTrue($rs);
        
        //Testando a ativação passando TRUE.
        $rs = $this->object->setAutoXmlDecode(true);
        $this->assertType('Util_Webservice_Client_Interface', $rs);
        
        $rs = $this->object->getAutoXmlDecode();
        $this->assertTrue($rs);
        
        //Testando a inativação.
        $rs = $this->object->setAutoXmlDecode(false);
        $this->assertType('Util_Webservice_Client_Interface', $rs);
        
        $rs = $this->object->getAutoXmlDecode();
        $this->assertFalse($rs);
    }

    /**
     * Testando o tempo de vida do cache.
     */
    public function testSetCache()
    {
        $rs = $this->object->setCache('id', '10');
        $this->assertType('Util_Webservice_Client_Interface', $rs);
    }

    /**
     * Testando uma chamada de webservice como XML.
     */
    public function test__callXml()
    {
        $method = Zend_Registry::get('tests')->webservice->client->method;
        $param1 = Zend_Registry::get('tests')->webservice->client->param1;
        $param2 = Zend_Registry::get('tests')->webservice->client->param2;
        
        $this->object->setAutoXmlDecode(false);
        $xml = $this->object->{$method}($param1, $param2);
        $this->assertTrue(Util_Format_Xml::isValid($xml));
    }
    
	/**
     * Testando uma chamada de webservice como array.
     */
    public function test__callArray()
    {
        $method = Zend_Registry::get('tests')->webservice->client->method;
        $param1 = Zend_Registry::get('tests')->webservice->client->param1;
        $param2 = Zend_Registry::get('tests')->webservice->client->param2;
        $field  = Zend_Registry::get('tests')->webservice->client->field;
        $value  = Zend_Registry::get('tests')->webservice->client->value;
        
        $this->object->setAutoXmlDecode(true);
        $rs = $this->object->{$method}($param1, $param2);
        
        $this->assertType('array', $rs);
        $this->assertArrayHasKey($field, $rs);
        $this->assertEquals($value, $rs[$field]);
    }
    
    /**
     * Testando a chamada de webservice com hash.
     */
    public function test__callHash()
    {
    	$method = Zend_Registry::get('tests')->webservice->client->method;
        $hash   = Zend_Registry::get('tests')->webservice->client->param1;
        $param  = Zend_Registry::get('tests')->webservice->client->param2;
        $field  = Zend_Registry::get('tests')->webservice->client->field;
        $value  = Zend_Registry::get('tests')->webservice->client->value;
        
        $this->object->setAutoXmlDecode(true);
        $this->object->setHash($hash);
        $rs = $this->object->{$method}($param);
        
        $this->assertType('array', $rs);
        $this->assertArrayHasKey($field, $rs);
        $this->assertEquals($value, $rs[$field]);
    }
    
    /**
     * Testa a chamada com o cliente default.
     */
    public function test__callNative()
    {
    	$method = Zend_Registry::get('tests')->webservice->client->method;
        $hash   = Zend_Registry::get('tests')->webservice->client->param1;
        $param  = Zend_Registry::get('tests')->webservice->client->param2;
        $field  = Zend_Registry::get('tests')->webservice->client->field;
        $value  = Zend_Registry::get('tests')->webservice->client->value;
        
        $this->object->setAutoXmlDecode()
                     ->setHash($hash)
                     ->setNativeClient();
        $rs = $this->object->{$method}($param);
        
        $this->assertType('array', $rs);
        $this->assertArrayHasKey($field, $rs);
        $this->assertEquals($value, $rs[$field]);
    }
    
    /**
     * Testando uma chamada de webservice de um método que não existe.
     * @expectedException Util_Webservice_Client_Exception
     */
    public function test__callError()
    {
        $method = Zend_Registry::get('tests')->webservice->client->method . 'a';
        $this->object->{$method}();
    }
}
