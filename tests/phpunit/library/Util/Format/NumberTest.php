<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: PhoneTest.php 16/11/2010 10:05:26 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_NumberTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Number
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Number;
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
    		array('DOLAR', 'U$'),
			array('EURO' , '€$'),
			array('REAL' , 'R$'),
    	);
    }
    
    /**
     * Provider de números para teste.
     * @return array
     */
    public function providerNumbers()
    {
    	return array(
    		
    		//Números válidos.
    		array(0, true),
    		array('0', true),
    		array((int)0, true),
    		array((float)0, true),
    		
    		array(1, true),
    		array('1', true),
    		array((int)1, true),
    		array((float)1, true),
    		
    		array(-1, true),
    		array('-1', true),
    		array((int)-1, true),
    		array((float)-1, true),
    		
    		array(2, true),
    		array('2', true),
    		array((int)2, true),
    		array((float)2, true),
    		
    		array(-2, true),
    		array('-2', true),
    		array((int)-2, true),
    		array((float)-2, true),
    		
    		array(0.1, true),
    		array('0.1', true),
    		array((float)0.1, true),
    		
    		array(-0.1, true),
    		array('-0.1', true),
    		array((float)-0.1, true),
    		
    		array(-0.2, true),
    		array('-0.2', true),
    		array((float)-0.2, true),
    		
    		//Números inválidos.
    		array(true,false),
    		array(false,false),
    		array('a',false),
    		array(new stdClass,false),
    	);
    }
    
    /**
     * Provider de números com separador.
     * @return array
     */
    public function providerToScreen()
    {
    	return array(
    		array('160907', '160.907'),
    		array(160907, '160.907'),
    		array(1152427, '1.152.427'),
    	);
    }
    
    /**
     * Provider para conversão monetária.
     * @return array
     */
    public function providerToMoney()
    {
    	return array(
    		
    		//REAL.
    		array(1, Util_Format_Number::REAL),
    		array(10, Util_Format_Number::REAL),
    		array(100, Util_Format_Number::REAL),
    		array(1000, Util_Format_Number::REAL),
    		array(10000, Util_Format_Number::REAL),
    		array(100000, Util_Format_Number::REAL),
    		array(1000000, Util_Format_Number::REAL),
    		
    		//DÓLAR.
    		array(1, Util_Format_Number::DOLAR),
    		array(10, Util_Format_Number::DOLAR),
    		array(100, Util_Format_Number::DOLAR),
    		array(1000, Util_Format_Number::DOLAR),
    		array(10000, Util_Format_Number::DOLAR),
    		array(100000, Util_Format_Number::DOLAR),
    		array(1000000, Util_Format_Number::DOLAR),
    		
    		//Valores inválidos.
    		array(1000000, 'invalid'),
    		
    		array(true, Util_Format_Number::REAL),
    		array(true, Util_Format_Number::DOLAR),
    		array(true, 'invalid'),
    		
    		array(false, Util_Format_Number::REAL),
    		array(false, Util_Format_Number::DOLAR),
    		array(false, 'invalid'),
    		
    		array('a', Util_Format_Number::REAL),
    		array('a', Util_Format_Number::DOLAR),
    		array('a', 'invalid'),
    		
    		array(new stdClass, Util_Format_Number::REAL),
    		array(new stdClass, Util_Format_Number::DOLAR),
    		array(new stdClass, 'invalid'),
    	);
    }
    
	/**
     * Testa se a classe implementa a interface certa.
     */
    public function testInterface()
    {
    	$this->assertType('Util_Format_Interface', $this->object);
    }
    
	/**
     * Testa os valores iniciais dos da classe.
     * @dataProvider providerConstantsValues
     */
    public function testConstantsValues($constantName, $constantValue)
    {
    	$class      = get_class($this->object);
    	$reflection = new ReflectionClass($class);
    	$constants  = $reflection->getConstants();
    	
    	$this->assertType('array', $constants);
    	$this->assertArrayHasKey($constantName, $constants);
    	$this->assertType('string', $constants[$constantName]);
    	$this->assertEquals($constantValue, $constants[$constantName]);
    }

    /**
     * Testa a veirficação de validade.
     * @dataProvider providerNumbers
     */
    public function testIsValid($numero, $esperado)
    {
        $rs = Util_Format_Number::isValid($numero);
        $this->assertType('bool', $rs);
        
        if($esperado) {
        	$this->assertTrue($rs);
        } else {
        	$this->assertFalse($rs);
        }
    }
	
    /**
     * Testa a formatação para a tela.
     * @dataProvider providerToScreen
     */
    public function testToScreen($numero, $esperado)
    {
    	$rs = Util_Format_Number::toScreen($numero);
    	$this->assertType('string', $rs);
    	$this->assertEquals($esperado, $rs);
    }
    
    /**
     * Testa a conversão monetária.
     * @dataProvider providerToMoney
     */
    public function testToMoney($numero, $formato)
    {
        $rs = Util_Format_Number::toMoney($numero, $formato);
        
        if($formato == 'invalid' or !is_numeric($numero)) {
        	$this->assertFalse($rs);
        } else {
        	$this->assertType('string', $rs);
        }
        
        if($rs != false) {
	        if($formato == Util_Format_Number::REAL) {
	        	$expected = number_format($numero, 2, ',', '.');
	        } else if($formato == Util_Format_Number::DOLAR) {
	        	$expected = number_format($numero, 2, '.', ',');
	        }
	        $this->assertEquals($expected, $rs);
        }
    }
}
