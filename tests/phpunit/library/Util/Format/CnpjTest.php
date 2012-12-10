<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CnpjTest.php 14/07/2011 16:30:46 leonardo $
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
class Util_Format_CnpjTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Cnpj
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Cnpj;
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
     * Provider de CNPJs válidos.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('14.747.777/0001-29'),
    		array('54.347.885/0001-29'),
    		array('30.844.318/0001-10'),
    	);
    }
    
    /**
     * Provider de CNPJs inválidos.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('30.844.318/0001-100'),
    		array('30.844.318/0001-1a'),
    		array('30844318000110'),
    	);
    }
    
    /**
     * Provider de CPNJs com e sem máscaras.
     * @return array
     */
    public function providerMasks()
    {
    	return array(
    		array('14.747.777/0001-29', '14747777000129'),
    		array('54.347.885/0001-29', '54347885000129'),
    		array('30.844.318/0001-10', '30844318000110'),
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
    public function testIsValid($cnpj)
    {
        $rs = Util_Format_Cnpj::isValid($cnpj);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a veirficação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($cnpj)
    {
        $rs = Util_Format_Cnpj::isValid($cnpj);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }

    /**
     * Testa a rotina de máscara.
     * @dataProvider providerMasks
     */
    public function testMask($masked, $unmasked)
    {
        $rs = Util_Format_Cnpj::Mask($unmasked);
        $this->assertType('string', $rs);
        $this->assertEquals($masked, $rs);
    }

    /**
     * Testa a rotina que retira a máscara.
     * @dataProvider providerMasks
     */
    public function testUnMask($masked, $unmasked)
    {
        $rs = Util_Format_Cnpj::UnMask($masked);
        $this->assertType('string', $rs);
        $this->assertEquals($unmasked, $rs);
    }
}
