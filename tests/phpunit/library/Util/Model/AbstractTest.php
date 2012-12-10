<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: AbstractTest.php 10/12/2011 15:26:03 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/** Classe de teste **/
class Util_Model_Extends extends Util_Model_Abstract {}

/**
 * @category Tests
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Model_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Model_Abstract
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Model_Extends;
        $this->object->clearAll();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    	$this->object->clearAll();
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
     * Provider dos valores iniciais das constantes da classe.
     * @return array
     */
    public function providerConstantsValues()
    {
    	return array(
			array('RETURN_CODE_SUCCESS', 0),
			array('RETURN_CODE_ERROR' , -1),
			array('HOUR_1',  60),
			array('HOUR_2',  120),
			array('HOUR_3',  180),
			array('HOUR_4',  240),
			array('HOUR_5',  300),
			array('HOUR_10', 600),
			array('HOUR_12', 720),
			array('HOUR_24', 1440),
			array('HOUR_48', 2880),
			array('HOUR_72', 4320),
			array('WEEK'   , 10080),
    	);
    }
    
    /**
     * Provider de arrays de retorno.
     * @return array
     */
    public function providerReturnArrays()
    {
    	return array(
    		array(array('codigo' => 0, 'descricao' => 'Mensagem')),
    		array(array('codigo' => '0','descricao' => 'Mensagem')),
    		array(array(array('codigo' => 0, 'descricao' => 'Mensagem'))),
    		array(array(array('codigo' => '0', 'descricao' => 'Mensagem'))),
    		array(array(array('codigo' => 0, 'descricao' => 'Mensagem'), array('Mais algum outro conteúdo'))),
    	);
    }
    
    /**
     * Provider de retornos inválidos.
     * @return array
     */
    public function providerInvalidReturnArrays()
    {
    	return array(
    		array(array('codigo' => '1', 'descricao' => 'Mensagem')),
    		array(array(array('codigo' => '1', 'descricao' => 'Mensagem'))),
    		array(array('codigo' =>  0)),
    		array(array('codigo' => '0')),
    		array(array('codigo' =>  1)),
    		array(array('codigo' => '1')),
    		array(array()),
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
     * Testando a alteração de driver de cache.
     */
    public function testSetCacheDriver()
    {
        $driver = Zend_Registry::get('config')->cache->driver;
        $rs     = $this->object->setCacheDriver($driver);
        $this->assertType(get_class($this->object), $rs);
        $this->assertEquals($driver, $this->object->getCacheDriver());
    }
    
    /**
     * Testa a recuperação do nome do driver de cache padrão.
     */
    public function testGetDefaultCacheDriver()
    {
    	$driver = Zend_Registry::get('config')->cache->driver;
    	$result = $this->object->getCacheDriver();
    	$this->assertEquals('apc', $result);
    }
    
	/**
     * Testa a recuperação do nome do driver de cache.
     */
    public function testGetCacheDriver()
    {
    	//Nome do driver a ser usado.
    	$driver = Zend_Registry::get('config')->cache->driver;
    	
    	//Configurando este driver.
    	$this->object->setCacheDriver($driver);
    	
    	//Verificando se esta configuração se mantém.
    	$result = $this->object->getCacheDriver();
    	$this->assertEquals($driver, $result);
    }
    
    /**
     * Testando a validação de retorno.
     * @dataProvider providerReturnArrays
     */
    public function testIsValid($rs)
    {
    	$rs = $this->object->isValid($rs);
        $this->assertTrue($rs);
    }
    
    /**
     * Testando a validação de retorno inválido.
     * @dataProvider providerInvalidReturnArrays
     * @expectedException Util_Model_Exception
     */
    public function testIsInvalid($rs)
    {
    	$this->object->isValid($rs);
    }

    /**
     * Testando a listagem de IDs.
     */
    public function testGetIds()
    {
        //APC não funciona em modo texto.
    }

    /**
     * @todo Implement testTest().
     */
    public function testTest()
    {
    	//APC não funciona em modo texto.
    }

    /**
     * @todo Implement testLoad().
     */
    public function testLoad()
    {
    	//APC não funciona em modo texto.
    }

    /**
     * @todo Implement testSave().
     */
    public function testSave()
    {
    	//APC não funciona em modo texto.
    }

    /**
     * @todo Implement testClear().
     */
    public function testClear()
    {
    	//APC não funciona em modo texto.
    }

    /**
     * @todo Implement testClearAll().
     */
    public function testClearAll()
    {
    	//APC não funciona em modo texto.
    }
}
