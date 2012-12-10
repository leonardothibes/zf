<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: IpTest.php 16/11/2010 14:45:10 leonardo $
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
class Util_Format_IpTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Ip
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Ip;
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
     * Provider de IPs válidos.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('10.100.0.206'),
    		array('192.168.0.100'),
    		array('200.200.200.200'),
    	);
    }
    
    /**
     * Provider de IPs inválidos.
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
    public function testIsValid($ip)
    {
        $rs = Util_Format_Ip::isValid($ip);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a veirficação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($ip)
    {
        $rs = Util_Format_Ip::isValid($ip);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }
}
