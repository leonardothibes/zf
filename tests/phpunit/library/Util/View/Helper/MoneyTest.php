<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: MoneyTest.php 02/01/2012 17:33:29 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_MoneyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_View_Helper_Money
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_View_Helper_Money;
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
     * Testando se extende a classe abstract certa.
     */
    public function testExtends()
    {
    	$this->assertType('Zend_Controller_Action_Helper_Abstract', $this->object);
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
