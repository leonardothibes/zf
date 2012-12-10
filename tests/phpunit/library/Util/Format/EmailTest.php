<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: EmailTest.php 16/11/2010 14:45:10 leonardo $
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
class Util_Format_EmailTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Email
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Email;
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
     * Provider de emails válidos.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('user@domain.com'),
    		array('lthibes@lidercap.com.br'),
    		array('leonardothibes@yahoo.com.br'),
    	);
    }
    
    /**
     * Provider de emails inválidos.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('user@domain,com'),
    		array('lthibes @lidercap.com.br'),
    		array('aaa'),
    		array('111')
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
    public function testIsValid($email)
    {
        $rs = Util_Format_Email::isValid($email);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a veirficação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($email)
    {
        $rs = Util_Format_Email::isValid($email);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }
	
    /**
     * Provider do sanitize.
     * @return array
     */
    public function providerSanitize()
    {
    	return array(
    		array('\lthibes@lidercap.com.br'),
    		array('\lthi"bes@lidercap.com.br'),
    	);
    }
    
    /**
     * Testando o sanitize.
     */
    public function testSanitize()
    {
        $rs = Util_Format_Email::Sanitize('\lthibes@lidercap.com.br');
        $this->assertType('string', $rs);
        $this->assertEquals('lthibes@lidercap.com.br', $rs);
        
        $rs = Util_Format_Email::Sanitize('\lthi"bes@lidercap.com.br');
        $this->assertType('string', $rs);
        $this->assertEquals('lthibes@lidercap.com.br', $rs);
    }
}
