<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CpfTest.php 16/11/2010 10:05:26 leonardo $
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
class Util_Format_CpfTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Cpf
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Cpf;
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
     * Provider de CPFs válidos.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('833.279.320-34'),
    		array('83327932034'),
    		array('153.860.958-46'),
    		array('15386095846'),
    		array('117.773.668-36'),
    		array('11777366836')
    	);
    }
    
    /**
     * Provider de CPFs inválidos.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('833.279.320-35'),
    		array('83327932035'),
    		array('153.860.958-47'),
    		array('15386095847'),
    		array('117.773.668-37'),
    		array('11777366837')
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
     * Testa a verificação de validade.
     * @dataProvider providerValid
     */
    public function testIsValid($cpf)
    {
        $rs = Util_Format_Cpf::isValid($cpf);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a verificação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($cpf)
    {
        $rs = Util_Format_Cpf::isValid($cpf);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }

    /**
     * Testa a rotina de máscara.
     */
    public function testMask()
    {
        $rs = Util_Format_Cpf::Mask('83327932034');
        $this->assertType('string', $rs);
        $this->assertEquals('833.279.320-34', $rs);
        
        $rs = Util_Format_Cpf::Mask('15386095846');
        $this->assertType('string', $rs);
        $this->assertEquals('153.860.958-46', $rs);
    }

    /**
     * Testa a rotina que retira a máscara.
     */
    public function testUnMask()
    {
    	$rs = Util_Format_Cpf::UnMask('833.279.320-34');
    	$this->assertType('string', $rs);
        $this->assertEquals('83327932034', $rs);
        
        $rs = Util_Format_Cpf::UnMask('153.860.958-46');
        $this->assertType('string', $rs);
        $this->assertEquals('15386095846', $rs);
    }
}
