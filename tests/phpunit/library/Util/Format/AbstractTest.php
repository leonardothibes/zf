<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ArrayTest.php 16/11/2010 10:05:26 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

class Format_Extends_Test extends Util_Format_Abstract
{
	static public function isValid($data = null)
	{
		return true;
	}
}

/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Abstract
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Format_Extends_Test;
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
     * Provider de valores.
     * @return array
     */
    public function providerValores()
    {
    	return array(
    		array(1),
    		array('1'),
    		array('a'),
    		array(true),
    		array(false),
    		array(null),
    		array(new stdClass),
    	);
    }
    
    /**
     * Testa o Sanitize.
     * @dataProvider providerValores
     */
    public function testSanitize($valor)
    {
        $rs = Util_Format_Abstract::Sanitize($valor);
        $this->assertSame($valor, $rs);
    }

    /**
     * Testa o Mask.
     * @dataProvider providerValores
     */
    public function testMask($valor)
    {
        $rs = Util_Format_Abstract::Mask($valor);
        $this->assertSame($valor, $rs);
    }

    /**
     * Testa o UnMask.
     * @dataProvider providerValores
     */
    public function testUnMask($valor)
    {
        $rs = Util_Format_Abstract::UnMask($valor);
        $this->assertSame($valor, $rs);
    }
}
