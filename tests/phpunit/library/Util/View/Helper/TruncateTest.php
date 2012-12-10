<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: TruncateTest.php 02/01/2012 17:36:28 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_TruncateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_View_Helper_Truncate
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_View_Helper_Truncate;
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
     * Testando se extende a classe abstract certa.
     */
    public function testExtends()
    {
    	$this->assertType('Zend_Controller_Action_Helper_Abstract', $this->object);
    }
    
    /**
     * Testa a truncagem de string.
     */
    public function testTruncate()
    {
        $string = 'Isto é uma frase muito muito, mas muito longa, mesmo';
        $rs = Util_Format_String::Truncate($string, 30, '...');
        
        $this->assertType('string', $rs);
        $this->assertEquals('Isto é uma frase muito muito...', $rs);
    }
}
