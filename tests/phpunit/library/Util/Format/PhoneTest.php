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
class Util_Format_PhoneTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Phone
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Phone;
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
     * Provider de telefones válidos.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('(11) 8636-9268'),
    		array('(11)8636-9268'),
    		array('(11) 3288-9811'),
    		array('(11)3288-9811'),
    	);
    }
    
    /**
     * Provider de telefones inválidos.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('(z1) 8636-9268'),
    		array('(11) 8636 9268'),
    		array('(11)-8636-9268'),
    		array('(11)  3288-9811'),
    		array('(11)_32889811'),
    		array(true),
    		array(false),
    		array(null),
    	);
    }
    
	/**
     * Provider de telefones com máscara.
     * @return array
     */
    public function providerMaskedPhones()
    {
    	return array(
    		array('(11) 8636-9268', '11', '8636-9268'),
    		array('(11) 3288-9811', '11', '3288-9811'),
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
     * Testa a veirficação de validade.
     * @dataProvider providerValid
     */
    public function testIsValid($phone)
    {
        $rs = Util_Format_Phone::isValid($phone);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a veirficação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($phone)
    {
        $rs = Util_Format_Phone::isValid($phone);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }
	
    /**
     * Testa a rotina de máscara.
     */
    public function testMask()
    {
        $rs = Util_Format_Phone::Mask('1186369268');
        $this->assertType('string', $rs);
        $this->assertEquals('(11) 8636-9268', $rs);
        
        $rs = Util_Format_Phone::Mask('1132889811');
        $this->assertType('string', $rs);
        $this->assertEquals('(11) 3288-9811', $rs);
    }
	
    /**
     * Testa a rotina que retira a máscara.
     * @dataProvider providerMaskedPhones
     */
    public function testUnMask($masked, $ddd, $phone)
    {
    	$rs = Util_Format_Phone::UnMask($masked);
    	$this->assertType('string', $rs);
        $this->assertEquals($ddd . str_replace('-', '', $phone), $rs);
    }
    
	/**
     * Testa a falha da rotina que retira a máscara.
     * @dataProvider providerInvalid
     */
    public function testUnMaskFail($phone)
    {
    	$rs = Util_Format_Phone::UnMask($phone);
    	$this->assertNull($rs);
    }
    
	/**
     * Testa a rotina que retira a máscara.
     * @dataProvider providerMaskedPhones
     */
    public function testUnMaskArray($masked, $ddd, $phone)
    {
    	$rs = Util_Format_Phone::UnMaskArray($masked);
    	$this->assertType('array', $rs);
    	
    	$this->assertArrayHasKey('ddd'  , $rs);
    	$this->assertArrayHasKey('phone', $rs);
    	
    	$this->assertEquals($ddd, $rs['ddd']);
    	$this->assertEquals(str_replace('-', '', $phone), $rs['phone']);
    }
    
	/**
     * Testa a falha da rotina que retira a máscara.
     * @dataProvider providerInvalid
     */
    public function testUnMaskArrayFail($phone)
    {
    	$rs = Util_Format_Phone::UnMaskArray($phone);
    	$this->assertNull($rs);
    }
}
