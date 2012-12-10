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

/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_ArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Array
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Array;
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
     * Provider de arrays válidos.
     * @return array
     */
    public function providerValidArrays()
    {
    	return array(
    		array(array(0,1,2,3,4,5,6,7,8,9)),
    		array(array('a', 'e', 'i', 'o', 'u')),
    		array(array(0, 'a', 1, 'e', 2, '3', 'i'))
    	);
    }
    
    /**
     * Provider de arrays inválidos.
     * @return array
     */
    public function providerInvalidArrays()
    {
    	return array(
    		array(array()),
    		array(true),
    		array(false),
    		array('abc'),
    		array(123),
    		array(new stdClass())
    	);
    }
    
    /**
     * Provider de arrays para sanitize.
     * @return array
     */
    public function providerSanitize()
    {
    	return array(
    		array(array('nome'     => 'á é í ó ú'    , 'idade'    => 20, 'salario' => 123.45)          , 's'),
    		array(array('nome1'    => '<b>Nome 1</b>', 'nome2'    => '<script>alert(Nome 3);</script>'), 's'),
    		array(array('salario1' => 123.45         , 'salario2' => '123.45', 'salario3' => '1000')   , 'f'),
    		array(array('salario1' => 123.45         , 'salario2' => '123.45', 'salario3' => '1000')   , 'i'),
    	);
    }
    
    /**
     * Provider de arrays para sanitize com filtros inválidos.
     * @return array
     */
    public function providerSanitizeInvalidFilters()
    {
    	return array(
    		array(array(), 'a'),
    		array(array(), true),
    		array(array(), false),
    		array(array(), null),
    		array('a', 's'),
    		array('a', 'i'),
    		array('a', 'f'),
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
     * Testa a verificaçaão de validade.
     * @dataProvider providerValidArrays
     */
    public function testIsValid($array)
    {
    	$rs = Util_Format_Array::isValid($array);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a verificaçaão de validade.
     * @dataProvider providerInvalidArrays
     */
    public function testIsInvalid($array)
    {
        $rs = Util_Format_Array::isValid($array);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }

    /**
     * Testa o sanitize.
     * @dataProvider providerSanitize
     */
    public function testSanitize($array, $filter)
    {
        $rs = Util_Format_Array::Sanitize($array, $filter);
        
        $this->assertType('array', $rs);
        $this->assertEquals(count($array), count($rs));
        
        foreach($rs as $field => $value) {
	        switch($filter) {
				case 's':
					$this->assertType('string', $value);
					$this->assertEquals(Util_Format_String::Sanitize($array[$field]), $value);
				break;
				case 'i':
					$this->assertType('int', $value);
					$this->assertEquals(intval($array[$field]), $value);
				break;
				case 'f':
					$this->assertType('float', $value);
					$this->assertEquals(floatval($array[$field]), $value);
				break;
			}
        }
    }
    
    /**
     * Testa a adição de aspas.
     */
    public function testAddQuotes()
    {
    	$ar = array('param1', 'param2', 'param3');
    	$rs = Util_Format_Array::AddQuotes($ar);
    	
    	$this->assertType('array', $rs);
    	$this->assertEquals(3, count($rs));
    	
    	$this->assertType('string', $rs[0]);
    	$this->assertEquals("'" . $ar[0] . "'", $rs[0]);
    	
    	$this->assertType('string', $rs[1]);
    	$this->assertEquals("'" . $ar[1] . "'", $rs[1]);
    	
    	$this->assertType('string', $rs[2]);
    	$this->assertEquals("'" . $ar[2] . "'", $rs[2]);
    }
    
    /**
     * Testa a transformação de array em lista de parâmetros.
     */
    public function testToParamList()
    {
    	$ar = array('param1', 'param2', 'param3');
    	$rs = Util_Format_Array::toParamList($ar);
    	
    	$this->assertType('string', $rs);
    	$this->assertEquals("'param1','param2','param3'", $rs);
    }
    
    /**
     * Testa os filtros do sanitize.
     * @dataProvider providerSanitizeInvalidFilters
     * @expectedException Util_Format_Exception
     */
    public function testSanitizeInvalidFilters($array, $filter)
    {
    	Util_Format_Array::Sanitize($array, $filter);
    }
    
    /**
     * Testa a exception do sanitize.
     */
    public function testSanitizeInvalidArray()
    {
    	try {
    		Util_Format_Array::Sanitize('string');
    	} catch(Exception $e) {
    		$this->assertType('Util_Format_Exception', $e);
    		$this->assertEquals('Array inválido.', $e->getMessage());
    		$this->assertEquals(-1, $e->getCode());
    	}
    }
    
	/**
     * Testa a exception de filtro do sanitize.
     * @dataProvider providerSanitize
     */
    public function testSanitizeInvalidFilter($array, $filter)
    {
    	try {
    		Util_Format_Array::Sanitize($array, 'outro qualquer');
    	} catch(Exception $e) {
    		$this->assertType('Util_Format_Exception', $e);
    		$this->assertEquals('Tipo de filtro inválido.', $e->getMessage());
    		$this->assertEquals(-2, $e->getCode());
    	}
    }

    /**
     * Testa a conversão para XML.
     */
    public function testToXml()
    {
    	$array = array(
    		'row1' => 'val1',
	    	'row2' => 'val2',
	    	'row3' => 'val3'
    	);
    	$xml = '<?xml version="1.0"?><root><row>val1</row><row>val2</row><row>val3</row></root>';
    	$rs  = Util_Format_Array::toXml($array);
    	$rs  = (string)preg_replace('/\n+/', '', trim($rs));
    	
    	$this->assertType('string', $rs);
    	$this->assertEquals($xml, $rs);
    }

    /**
     * Testa a conversão para Objeto.
     */
    public function testToObject()
    {
        $array = array(
    		'row1' => 'val1',
	    	'row2' => 'val2',
	    	'row3' => 'val3',
    	);
    	$rs = Util_Format_Array::toObject($array);
    	
    	$this->assertType('stdClass', $rs);
    	$this->assertEquals('val1', $rs->row1);
    	$this->assertEquals('val2', $rs->row2);
    	$this->assertEquals('val3', $rs->row3);
    }

    /**
     * Testa a remoção de índices em branco.
     */
    public function testRemoveEmpty()
    {
        $empty = array(
        	'row1' => 'val1',
	    	'row2' => '',
	    	'row3' => 'val3'
        );
        $final = array(
        	'row1' => 'val1',
	    	'row3' => 'val3'
        );
        $rs = Util_Format_Array::RemoveEmpty($empty);
        $this->assertType('array', $rs);
        $this->assertEquals(serialize($final), serialize($rs));
    }

    /**
     * Testa a busca no array.
     */
    public function testSearch()
    {
        $array = array(
        	'argentina',
        	'brasil',
        	'brasilia',
        	'chile'
        );
        $rs = Util_Format_Array::Search($array, 'brasil');
        $rs = (string)preg_replace('/\n+/', '', trim($rs));
        
        $this->assertType('string', $rs);
        $this->assertEquals($rs, '1|brasil2|brasilia');
    }

    /**
     * Testa a ordenação.
     */
    public function testOrderBy()
    {
        $array   = array();
        $array[] = array(
        	'id'   => 2,
        	'nome' => 'Bernardo',
        );
        $array[] = array(
        	'id'   => 1,
        	'nome' => 'Abílio',
        );
        $array[] = array(
        	'id'   => 4,
        	'nome' => 'Daniel',
        );
        $array[] = array(
        	'id'   => 3,
        	'nome' => 'Carlos',
        );
        
        $sorted = array(
        	'0' => array(
        		'id'   => 1,
        		'nome' => 'Abílio',
        	),
        	'1' => array(
        		'id'   => 2,
        		'nome' => 'Bernardo',
        	),
        	'2' => array(
        		'id'   => 3,
        		'nome' => 'Carlos',
        	),
        	'3' => array(
        		'id'   => 4,
        		'nome' => 'Daniel',
        	),
        );
        
        $rs = Util_Format_Array::orderBy($array, 'id');
        $this->assertType('array', $rs);
        $this->assertEquals($sorted, $rs);
        
        $rs = Util_Format_Array::orderBy($array, 'nome');
        $this->assertType('array', $rs);
        $this->assertEquals(serialize($sorted), serialize($rs));
    }
}
