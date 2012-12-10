<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: FilterTest.php 10/12/2011 14:38:49 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Model_FilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Model_Filter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Model_Filter;
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
     * Provider de filtros e valores.
     * @return array
     */
    public function providerFilters()
    {
    	return array(
    		array('StringTrim', '   aaa   ', 'aaa', 'string'),
    		array('StripTags', '<b>a</a>', 'a', 'string'),
    		array('Int', '123', '123', 'int'),
    		array('Alnum', '111.111.111-11', '11111111111', 'string'),
    	);
    }
    
	/**
     * Testando a presença de métodos na classe.
     */
    public function testMethods()
    {
    	$class      = get_class($this->object);
    	$reflection = new ReflectionClass($class);
    	$methods     = $reflection->getMethods();
    	$this->assertEquals(1, count($methods));
    }
    
    /**
     * Testando a chamada de filtro.
     * @dataProvider providerFilters
     */
    public function test__call($filtro, $antes, $esperado, $tipoEsperado)
    {
        $rs = $this->object->{$filtro}($antes);
        
        $this->assertType($tipoEsperado, $rs);
        $this->assertEquals($esperado, $rs);
    }
    
    /**
     * Teste de filtro não encontrado.
     */
    public function test__callNaoEncontrado()
    {
    	try {
    		$this->object->NaoEncontrado('qualquer coisa');
    	} catch (Exception $e) {
    		$this->assertEquals('O filtro "Zend_Filter_NaoEncontrado" não foi encontrado.', $e->getMessage());
    		$this->assertEquals(Util_Model_Exception::FILTER_NOT_FOUND, $e->getCode());
    	}
    }
    
    /**
     * Teste da excessão do filtro não encontrado.
     * @expectedException Util_Model_Exception
     */
    public function test__callNaoEncontradoException()
    {
    	$this->object->NaoEncontrado('qualquer coisa');
    }
}
