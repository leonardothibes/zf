<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Farm
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ServerTest.php 27/08/2012 11:45:36 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage Farm
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Farm_ServerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Farm_Server
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Farm_Server;
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
     * Provider de nodes do webfarm.
     * @return array
     */
    public function providerNodes()
    {
    	$nodes = Zend_Registry::get('config')->farm;
    	$lista = array();
    	
    	foreach($nodes as $node) {
			$lista[] = array($node->addr, $node->name);
    	}
    	
    	return $lista;
    }
    
    /**
     * Testando a consulta de nome de servidor.
     * @dataProvider providerNodes
     */
    public function testWhoAmi($addr, $name)
    {
    	$_SERVER['SERVER_ADDR'] = $addr;
        $rs = Util_Farm_Server::WhoAmi();
        $this->assertType('string', $rs);
        $this->assertEquals($name, $rs);
    }
    
    /**
     * Testando a consulta de nome de servidor em ambiente terminal.
     */
	public function testWhoAmiInConsole()
    {
    	unset($_SERVER['SERVER_ADDR']);
        $rs = Util_Farm_Server::WhoAmi();
        $this->assertType('string', $rs);
        $this->assertEquals('localhost', $rs);
    } 

    /**
     * Testando a consulta de nome por IP.
     * @dataProvider providerNodes
     */
    public function testWhoIs($addr, $name)
    {
        $rs = Util_Farm_Server::WhoIs($addr);
        $this->assertType('string', $rs);
        $this->assertEquals($name, $rs);
    }
    
    /**
     * Testando a falha na consulta de nome.
     * @dataProvider providerNodes
     */
    public function testWhoIsNotExists($addr, $name)
    {
    	$rs = Util_Farm_Server::WhoIs($addr . rand(1,5));
    	$this->assertFalse($rs);
    }
	
    /**
     * Testando a listagem indexada pelo nome.
     */
    public function testListNodesKeyName()
    {
        $rs = Util_Farm_Server::ListNodes();
        
        if(!Util_Format_Array::isValid($rs)) {
        	$this->markTestSkipped();
        }
        
        foreach($rs as $name => $ip) {
        	$this->assertTrue(Util_Format_Ip::isValid($ip));
        	$this->assertEquals(Util_Farm_Server::WhoIs($ip), $name);
        }
    }
    
	/**
     * Testando a listagem indexada pelo IP.
     */
    public function testListNodesKeyIp()
    {
        $rs = Util_Farm_Server::ListNodes(true);
        
        if(!Util_Format_Array::isValid($rs)) {
        	$this->markTestSkipped();
        }
        
        foreach($rs as $ip => $name) {
        	$this->assertTrue(Util_Format_Ip::isValid($ip));
        	$this->assertEquals(Util_Farm_Server::WhoIs($ip), $name);
        }
    }
}
