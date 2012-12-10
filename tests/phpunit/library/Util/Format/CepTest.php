<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CepTest.php 16/11/2010 10:05:26 leonardo $
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
class Util_Format_CepTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Cep
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Cep;
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
     * Provider de CEPs válidos.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('01508-010'),
    		array('01315-010'),
    	);
    }
    
    /**
     * Provider de CEPs inválidos.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('01508-010000'),
    		array('01508010000'),
    		array('01508-010aaa'),
    		array('01508010aaa'),
    		array('aaaaa-aaa'),
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
    public function testIsValid($cep)
    {
        $rs = Util_Format_Cep::isValid($cep);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a veirficação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($cep)
    {
        $rs = Util_Format_Cep::isValid($cep);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }

    /**
     * Testa a rotina de máscara.
     */
    public function testMask()
    {
        $rs = Util_Format_Cep::Mask('00000000');
        $this->assertType('string', $rs);
        $this->assertEquals('00000-000', $rs);
        
        $rs = Util_Format_Cep::Mask('11111111');
        $this->assertType('string', $rs);
        $this->assertEquals('11111-111', $rs);
    }

    /**
     * Testa a rotina que retira a máscara.
     */
    public function testUnMask()
    {
    	$rs = Util_Format_Cep::UnMask('00000-000');
    	$this->assertType('string', $rs);
        $this->assertEquals('00000000', $rs);
        
        $rs = Util_Format_Cep::UnMask('11111-111');
        $this->assertType('string', $rs);
        $this->assertEquals('11111111', $rs);
    }
}
