<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: AbstractTest.php 02/12/2011 19:04:48 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/** Classe de teste **/
class Util_Db_Extends extends Util_Db_Abstract {}

/**
 * @category Tests
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Db_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Db_Abstract
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Db_Extends;
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
     * Provider de nomes de classes pai.
     * @return array
     */
    public function providerParents()
    {
    	return array(
    		array('Util_Db_Abstract'),
	    	array('Util_Db_Interface')
    	);
    }
    
    /**
     * Provider de strings para conversão.
     * @return array
     */
    public function providerInput()
    {
    	return array(
    		array(array('á', 'é', 'í', 'ó', 'ú'))
    	);
    }
    
	/**
     * Testando se extende as classes certas.
     * @dataProvider providerParents
     */
    public function testExtends($parentName)
    {
    	$this->assertType($parentName , $this->object);
    }
    
    /**
     * Testando se a classe é abstrata.
     */
    public function testIsAbstract()
    {
    	$class      = get_class($this->object);
    	$reflection = new ReflectionClass($class);
    	$parent     = $reflection->getParentClass()->name;
    	
    	$reflection = new ReflectionClass($parent);
    	$this->assertTrue($reflection->isAbstract());
    }
    
    /**
     * Testando a conversão de caracteres que vão para o banco.
     * @dataProvider providerInput
     */
    public function testCharsetEncode($referencia)
    {
        $antes = $this->object->charsetEncode($referencia);
        $rs    = $this->object->charsetDecode($antes);
        
        $this->assertType('array', $rs);
        $this->assertEquals(count($referencia), count($rs));
        
        foreach($rs as $id => $row) {
        	$this->assertEquals($referencia[$id], $row);
        }
    }

    /**
     * Testando a conversão de caracteres que vem do banco.
     */
    public function testCharsetDecode()
    {
    	$name  = Zend_Registry::get('tests')->db->proc->name;
    	$param = Zend_Registry::get('tests')->db->proc->param;
        $field = Zend_Registry::get('tests')->db->encoding->input->field;
    	$value = Zend_Registry::get('tests')->db->encoding->input->value;
        
        $proc = new Util_Db_Proc();
        $rs   = $proc->{$name}($param);
        $rs   = $this->object->charsetDecode($rs[0]);
        
        $this->assertEquals(trim($value), trim($rs[$field]));
    }
}
