<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CreditCardAmexTest.php 16/11/2010 10:05:26 leonardo $
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
class Util_Format_CreditCardAmexTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_CreditCardAmex
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_CreditCardAmex;
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
     * Testa se a classe implementa a interface certa.
     */
    public function testInterface()
    {
    	$this->assertType('Util_Format_Interface', $this->object);
    }
    
	/**
     * Provider de cartões válidos.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('34567 800000 0007'),
    		array('11111 222222 0007')
    	);
    }
    
    /**
     * Provider de cartões inválidos.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('xxxx xxxx xxxx xxxx'),
    		array('xxxxxxxxxxxxxxxx'),
    		array('1111111111111111'),
    		//array(new stdClass),
    	);
    }

    /**
     * Testa a verificação de validade.
     * @dataProvider providerValid
     */
    public function testIsValid($card)
    {
        $rs = Util_Format_CreditCardAmex::isValid($card);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a verificação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($card)
    {
        $rs = Util_Format_CreditCardAmex::isValid($card);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }

    /**
     * Testa a rotina de máscara.
     */
    public function testMask()
    {
        $rs = Util_Format_CreditCardAmex::Mask('345678000000007');
        $this->assertType('string', $rs);
        $this->assertEquals('34567 800000 0007', $rs);
    }

    /**
     * Testa a rotina que retira a máscara.
     */
    public function testUnMask()
    {
    	$rs = Util_Format_CreditCardAmex::UnMask('34567 800000 0007');
    	$this->assertType('string', $rs);
        $this->assertEquals('345678000000007', $rs);
    }
}
