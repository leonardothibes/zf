<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ProcTest.php 05/12/2011 08:05:28 leonardo $
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
class Util_Db_ProcTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Db_Proc
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Db_Proc;
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
     * Testando uma chamada de procedure sem parâmetro.
     */
    public function test__callSemParametro()
    {
        $proc  = Zend_Registry::get('tests')->db->proc->name;
        $count = Zend_Registry::get('tests')->db->proc->count;
        $field = Zend_Registry::get('tests')->db->proc->field;
        $value = Zend_Registry::get('tests')->db->proc->value;
        
        if(!strlen($proc)) {
        	$this->markTestSkipped('Informe uma procedure.');
        }
        
        $rs = $this->object->{$proc}();
        
        $this->assertType('array', $rs);
        $this->assertEquals($count, count($rs));
        $this->assertTrue(isset($rs[0][$field]));
        $this->assertEquals($value, $rs[0][$field]);
    }
    
	/**
     * Testando uma chamada de procedure sem parâmetro.
     */
    public function test__callComParametro()
    {
        $proc  = Zend_Registry::get('tests')->db->proc->name;
        $param = Zend_Registry::get('tests')->db->proc->param;
        $count = Zend_Registry::get('tests')->db->proc->count;
        $field = Zend_Registry::get('tests')->db->proc->field;
        $value = Zend_Registry::get('tests')->db->proc->value;
        
    	if(!strlen($proc)) {
        	$this->markTestSkipped('Informe uma procedure.');
        }
        
        $rs = $this->object->{$proc}($param);
        
        $this->assertType('array', $rs);
        $this->assertEquals($count, count($rs));
        $this->assertTrue(isset($rs[0][$field]));
        $this->assertEquals($value, $rs[0][$field]);
    }
    
    /**
     * Testando uma procedure de entrada de dados.
     */
	public function test__callProcEntrada()
    {
        $proc  = Zend_Registry::get('tests')->db->input->proc;
        $param = @explode(',', Zend_Registry::get('tests')->db->input->params);
        $count = Zend_Registry::get('tests')->db->input->count;
        $field = Zend_Registry::get('tests')->db->input->field;
        $value = Zend_Registry::get('tests')->db->input->value;
        
    	if(!strlen($proc)) {
        	$this->markTestSkipped('Informe uma procedure.');
        }
        
        $rs = $this->object->{$proc}($param[0], $param[1]);
        
        $this->assertType('array', $rs);
        $this->assertEquals($count, count($rs));
        $this->assertTrue(isset($rs[0][$field]));
        $this->assertEquals($value, $rs[0][$field]);
    }
}
