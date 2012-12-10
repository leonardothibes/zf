<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ExceptionTest.php 02/12/2011 18:48:45 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Db_ExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Db_Exception
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Db_Exception;
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
     * Testando se extende as classes certas.
     */
    public function testExtends()
    {
    	$this->assertType('Util_Model_Exception', $this->object);
    	$this->assertType('Zend_Exception'      , $this->object);
    	$this->assertType('Exception'           , $this->object);
    }
    
    /**
     * Testando a presença de métodos na classe.
     */
    public function testMethods()
    {
    	$class      = get_class($this->object);
    	$reflection = new ReflectionClass($class);
    	$methods     = $reflection->getMethods();
    	$this->assertEquals(12, count($methods));
    }
}
