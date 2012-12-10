<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ExceptionTest.php 12/12/2011 08:21:17 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Webservice_ExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Webservice_Exception
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Webservice_Exception;
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
     * Provider dos valores iniciais das constantes da classe.
     * @return array
     */
    public function providerConstantsValues()
    {
    	return array(
			array('WSDL_EMPTY', -2)
    	);
    }
    
	/**
     * Testa os valores iniciais das constantes da classe.
     * @dataProvider providerConstantsValues
     */
    public function testConstantsValues($constantName, $constantValue)
    {
    	$class      = get_class($this->object);
    	$reflection = new ReflectionClass($class);
    	$constants  = $reflection->getConstants();
    	
    	$this->assertType('array', $constants);
    	$this->assertArrayHasKey($constantName, $constants);
    	$this->assertType('int', $constants[$constantName]);
    	$this->assertEquals($constantValue, $constants[$constantName]);
    }
    
	/**
     * Testando se extende as classes certas.
     */
    public function testExtends()
    {
    	$this->assertType('Util_Model_Exception', $this->object);
    	$this->assertType('Zend_Exception'      , $this->object);
    	$this->assertType('Exception'           , $this->object);
    }
    
    /**
     * Testando a presença de métodos na classe.
     */
    public function testMethods()
    {
    	$class      = get_class($this->object);
    	$reflection = new ReflectionClass($class);
    	$methods     = $reflection->getMethods();
    	$this->assertEquals(12, count($methods));
    }
}
