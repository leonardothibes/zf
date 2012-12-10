<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CapitalizeTest.php 02/01/2012 17:24:09 leonardo $
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
class Util_View_Helper_CapitalizeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_View_Helper_Capitalize
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_View_Helper_Capitalize;
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
     * Testa a conversão da primeira letra para maiúscula.
     */
    public function testCapitalize()
    {
        $rs = Util_Format_String::Capitalize('paRAleLEPIPedo');
        $this->assertEquals('Paralelepipedo', $rs);
    }
}
