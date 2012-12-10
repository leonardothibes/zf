<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: StringTest.php 16/11/2010 10:05:26 leonardo $
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
class Util_Format_StringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_String
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_String;
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
     * Provider de strings válidas.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('a'),
    		array('e'),
    		array('i'),
    		array('o'),
    		array('u'),
    		array('abc'),
    		array('áéíóú')
    	);
    }
    
    /**
     * Provider de strings inválidas.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('0'),
    		array('1'),
    		array(true),
    		array(false),
    		array(new stdClass),
    	);
    }
    
    /**
     * Provider de strings para sanitize.
     * @return array
     */
    public function providerSanitize()
    {
    	return array(
    		array('string', '', 'string'),
    		array('á é í ó ú', '', 'á é í ó ú'),
    		array('<b>string</b>', '', 'string'),
    		array('<b>string</b>', '<b>', '<b>string</b>'),
    		array('<b>string</b>', '*', '<b>string</b>'),
    		array('<a href="/path/to/the/lick">link</a>', '', 'link'),
    		array('<a href="/path/to/the/lick">link</a>', '*', '<a href=\"/path/to/the/lick\">link</a>'),
    		array('--INSERT INTO injection_table VALUES(value1, value2)', '*', 'INSERT INTO injection_table VALUES(value1, value2)'),
    		array('--INSERT INTO injection_table VALUES(value1, value2)', '', 'INSERT INTO injection_table VALUES(value1, value2)')
    	);
    }
    
    /**
     * Provider de string acentuadas.
     * @return array
     */
    public function providerAcentuadas()
    {
    	return array(
    		
    		/** Bloco do A **/
			array('á', 'a'),
			array('Á', 'A'),
			array('à', 'a'),
			array('À', 'A'),
			array('â', 'a'),
			array('Â', 'A'),
			array('ã', 'a'),
			array('Ã', 'A'),
			array('ä', 'a'),
			array('Ä', 'A'),
			/** Bloco do A **/
			
			/** Bloco do E **/
			array('é', 'e'),
			array('É', 'E'),
			array('è', 'e'),
			array('È', 'E'),
			array('ê', 'e'),
			array('Ê', 'E'),
			array('ë', 'e'),
			array('Ë', 'E'),
			/** Bloco do E **/
			
			/** Bloco do I **/
			array('í', 'i'),
			array('Í', 'I'),
			array('ì', 'i'),
			array('Ì', 'I'),
			array('î', 'i'),
			array('Î', 'I'),
			array('ĩ', 'i'),
			array('Ĩ', 'I'),
			array('ï', 'i'),
			array('Ï', 'I'),
			/** Bloco do I **/
			
			/** Bloco do O **/
			array('ó', 'o'),
			array('Ó', 'O'),
			array('ò', 'o'),
			array('Ò', 'O'),
			array('ô', 'o'),
			array('Ô', 'O'),
			array('õ', 'o'),
			array('Õ', 'O'),
			array('ö', 'o'),
			array('Ö', 'O'),
			/** Bloco do O **/
			
			/** Bloco do U **/
			array('ú', 'u'),
			array('Ú', 'U'),
			array('ù', 'u'),
			array('Ù', 'U'),
			array('û', 'u'),
			array('Û', 'U'),
			array('ũ', 'u'),
			array('Ũ', 'U'),
			array('ü', 'u'),
			array('Ü', 'U'),
			/** Bloco do U **/
			
			/** Bloco do Ç **/
			array('ç', 'c'),
			array('Ç', 'C'),
			/** Bloco do Ç **/
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
    public function testIsValid($string)
    {
        $rs = Util_Format_String::isValid($string);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
    /**
     * Testa o sanitize de string.
     * @dataProvider providerSanitize
     */
    public function testSanitize($string, $tags, $esperado)
    {
    	$rs = Util_Format_String::Sanitize($string, $tags);
    	$this->assertType('string', $rs);
    	$this->assertGreaterThan(0, strlen($rs));
    	$this->assertEquals($esperado, $rs);
    }
    
	/**
     * Testa a veirficação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($string)
    {
        $rs = Util_Format_String::isValid($string);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }
	
    /**
     * Testa a conversão de codificação.
     * @dataProvider providerAcentuadas
     */
    public function testEncode($acentuada, $naoAcentuada)
    {
        $rs1 = iconv('utf-8', 'cp850', $naoAcentuada);
        $rs2 = Util_Format_String::Encode($naoAcentuada);
        
        $this->assertType('string', $rs2);
        $this->assertEquals($rs1, $rs2);
    }

    /**
     * Testa a conversão de codificação.
     * @dataProvider providerAcentuadas
     */
    public function testDecode($acentuada, $naoAcentuada)
    {
        $rs1 = iconv('cp850', 'utf-8', $naoAcentuada);
        $rs2 = Util_Format_String::Decode($naoAcentuada);
        
        $this->assertType('string', $rs2);
        $this->assertEquals($rs1, $rs2);
    }

    /**
     * Testa a concatenação de strings.
     */
    public function testAddStr()
    {
        $string = null;
        
        Util_Format_String::AddStr($string, 'a');
        Util_Format_String::AddStr($string, 'b');
        Util_Format_String::AddStr($string, 'c');
        
        $string = str_replace(' ', '', $string);
        $this->assertEquals('a,b,c', $string);
    }
	
    /**
     * Testa a adição de aspas em string.
     */
    public function testAddQuotes()
    {
    	$rs = Util_Format_String::AddQuotes('string');
    	$this->assertType('string', $rs);
    	$this->assertEquals("'string'", $rs);
    }
    
    /**
     * Testa a adição de barra no início da string.
     */
    public function testFirstSlash()
    {
    	$string = 'string';
    	$rs     = Util_Format_String::FirstSlash($string);
    	$this->assertSame('/' . $string, $rs);
    	
    	$string = '/string';
    	$rs     = Util_Format_String::FirstSlash($string);
    	$this->assertSame($string, $rs);
    }
    
	/**
     * Testa a adição de barra no final da string.
     */
    public function testLastSlash()
    {
    	$string = 'string';
    	$rs     = Util_Format_String::LastSlash($string);
    	$this->assertSame($string . '/', $rs);
    	
    	$string = 'string/';
    	$rs     = Util_Format_String::LastSlash($string);
    	$this->assertSame($string, $rs);
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

    /**
     * Testa a conversão para minúsculas.
     */
    public function testLowerTrim()
    {
        $rs = Util_Format_String::LowerTrim('   MAIUSCULA    ');
        $this->assertEquals('maiuscula', $rs);
    }

    /**
     * Testa a conversão para maiúsculas.
     */
    public function testUpperTrim()
    {
        $rs = Util_Format_String::UpperTrim('   maiuscula    ');
        $this->assertEquals('MAIUSCULA', $rs);
    }

    /**
     * Testa a conversão da primeira letra para maiúscula.
     */
    public function testCapitalize()
    {
        $rs = Util_Format_String::Capitalize('paRAleLEPIPedo');
        $this->assertEquals('Paralelepipedo', $rs);
    }

    /**
     * Testa a redução de espaços na string.
     */
    public function testOneSpaceOnly()
    {
        $rs = Util_Format_String::OneSpaceOnly('isto    eh    um    teste');
        $this->assertEquals('isto eh um teste', $rs);
    }

    /**
     * Testa a remoção de espaços da string.
     */
    public function testStripSpaces()
    {
        $rs = Util_Format_String::StripSpaces('isto eh um teste');
        $this->assertEquals('isto_eh_um_teste', $rs);
    }
    
    /**
     * Testa a remoção de quebras de linha da string.
     */
    public function testStripBreak()
    {
    	$string = '
primeira linha
segunda linha
    	';
    	
    	$rs = Util_Format_String::StripBreak($string);
    	$this->assertType('string', $rs);
    	$this->assertEquals('primeira linhasegunda linha', trim($rs));
    }

    /**
     * Testa a conversão para nomes de classe no padrão do Zend Framework.
     */
    public function testZendName()
    {
        $rs = Util_Format_String::ZendName('isto_eh_um_teste');
        $this->assertEquals('Isto_Eh_Um_Teste', $rs);
    }

    /**
     * Testa a remoção de acentos.
     * @dataProvider providerAcentuadas
     */
    public function testStripAccents($acentuada, $naoAcentuada)
    {
    	$this->assertEquals($naoAcentuada, Util_Format_String::StripAccents($acentuada));
    }
}
