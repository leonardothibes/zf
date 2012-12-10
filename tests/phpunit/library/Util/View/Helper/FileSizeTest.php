<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: FileSizeTest.php 02/01/2012 17:29:25 leonardo $
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
class Util_View_Helper_FileSizeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_View_Helper_FileSize
     */
    protected $object;
    
	/**
     * Diretório raiz para os testes.
     * @var string
     */
    protected $_path = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_View_Helper_FileSize;
    	$this->_path  = $root = str_replace('/application', '', APPLICATION_PATH) . '/';
        
        $files = $this->providerFiles();
        foreach($files as $row) {
        	
        	$dir  = @explode('/', $row[0]);
        	$last = count($dir) - 1;
        	$name = $dir[$last];
        	unset($dir[$last]);
        	$dir = @implode('/', $dir);
        	
        	@mkdir($this->_path . $dir);
        	$file = $this->_path . $row[0];
        	
        	$rs = file_put_contents($file, $row[1]);
        }
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    	$files = $this->providerFiles();
        foreach($files as $row) {
        	
        	$dir  = @explode('/', $row[0]);
        	$last = count($dir) - 1;
        	$name = $dir[$last];
        	unset($dir[$last]);
        	$dir = @implode('/', $dir);
        	
        	$file = $this->_path . $row[0];
        	unlink($file);
        }
        @rmdir($this->_path . $dir);
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
     * Provider de caminhos de arquivo e conteúdos.
     * @return array
     */
    public function providerFiles()
    {
    	return array(
    		array('tests/_files/file1.txt', 'Conteudo do primeiro arquivo.', '29 Bytes', '29,00 Bytes'),
    		array('tests/_files/file2.txt', 'Conteudo do segundo arquivo.', '28 Bytes', '28,00 Bytes'),
    		array('tests/_files/file3.txt', 'Conteudo do terceiro arquivo.', '29 Bytes', '29,00 Bytes'),
    	);
    }
    
    /**
     * Testando a contagem de tamanho de arquivo.
     * @dataProvider providerFiles
     */
    public function testSize($file, $content, $rounded, $size)
    {
    	if(substr(PHP_OS,0,3) == 'WIN') {
    		$this->markTestSkipped($this->_skipMessage);
    	}
    	
    	$rs = Util_File::Size($file);
    	$this->assertType('string', $rs);
    	$this->assertEquals($size, $rs);
    	
    	$rs = Util_File::Size($file, false);
    	$this->assertType('string', $rs);
    	$this->assertEquals($size, $rs);
    	
        $rs = Util_File::Size($file, true);
        $this->assertType('string', $rs);
        $this->assertEquals($rounded, $rs);
    }
}
