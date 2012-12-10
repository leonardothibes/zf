<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: XmlTest.php 16/11/2010 10:05:26 leonardo $
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
class Util_Format_XmlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Xml
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Xml;
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
     * Testa a veirficação de validade.
     */
    public function testIsValid()
    {
        $xml = '<root>
        	<row>val1</row>
        	<row attrib="value">val1</row>
        	<row>val1</row>
        </root>';
        
        $rs = Util_Format_Xml::isValid($xml);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a veirficação de validade.
     */
    public function testIsInvalid()
    {
        $xml = '<root>
        	<row>val1</row>
        	<row attrib="value">val2</row>
        	<row>val3</row
        </root>';
        
        $rs = Util_Format_Xml::isValid($xml);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }

    /**
     * Testa a conversão de XML para Array.
     */
    public function testToArray()
    {
        $xml = '<root>
        	<row>val1</row>
        	<row attrib="value">val2</row>
        	<row>val3</row>
        </root>';
        
        $rs = Util_Format_Xml::toArray($xml);
        $this->assertType('array', $rs);
        
        $this->assertArrayHasKey('row1', $rs);
        $this->assertArrayHasKey('row2', $rs);
        $this->assertArrayHasKey('row3', $rs);
        
        $this->assertEquals('val1', $rs['row1']);
        $this->assertEquals('val2', $rs['row2']);
        $this->assertEquals('val3', $rs['row3']);
    }
}
