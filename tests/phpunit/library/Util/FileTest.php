<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: FileTest.php 16/11/2010 10:05:26 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_FileTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_File
     */
    protected $object;
    
    /**
     * Mensagem em caso de Windows.
     * @var string
     */
    protected $_skipMessage = 'Teste com arquivos não é realizado em sistemas Windows.';
    
    /**
     * Diretório raiz para os testes.
     * @var string
     */
    protected $_path = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @dataProvider providerFiles
     */
    protected function setUp()
    {
        $this->object = new Util_File;
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
     * Provider de nomes e extensões de arquivos.
     * @return array
     */
    public function providerFileNames()
    {
    	return array(
    		array('file.txt'   , 'txt' , 'text/plain'),
    		array('file.htm'   , 'htm' , 'text/html'),
    		array('file.html'  , 'html', 'text/html'),
    		array('file.jpg'   , 'jpg' , 'image/jpeg'),
    		array('file.jpeg'  , 'jpeg', 'image/jpeg'),
    		array('file.gif'   , 'gif' , 'image/gif'),
    		array('file.png'   , 'png' , 'image/png'),
    		array('file.tiff'  , 'tiff', 'image/tiff'),
    		array('file.doc'   , 'doc' , 'application/msword'),
    		array('file.xls'   , 'xls' , 'application/vnd.ms-excel'),
    		array('file.ppt'   , 'ppt' , 'application/vnd.ms-powerpoint'),
    		array('file.pps'   , 'pps' , 'application/vnd.ms-powerpoint'),
    		array('file.zip'   , 'zip' , 'application/zip'),
    		array('file.rar'   , 'rar' , 'application/x-rar-compressed'),
    		array('file.tar.gz', 'gz'  , 'application/x-gzip'),
    	);
    }
    
    /**
     * Provider de caminhos de arquivo e conteúdos.
     * @return array
     */
    public function providerFiles()
    {
    	return array(
    		array('tests/_files/file1.txt', 'Conteudo do primeiro arquivo.', '29 Bytes', '29,00 Bytes'),
    		array('tests/_files/file2.txt', 'Conteudo do segundo arquivo.' , '28 Bytes', '28,00 Bytes'),
    		array('tests/_files/file3.txt', 'Conteudo do terceiro arquivo.', '29 Bytes', '29,00 Bytes'),
    	);
    }
    
    /**
     * Testando a busca por extensão de arquivo.
     * @dataProvider providerFileNames
     */
    public function testExt($file, $ext)
    {
    	$rs = Util_File::Ext($file);
    	$this->assertType('string', $rs);
    	$this->assertEquals($ext, $rs);
    }
    
    /**
     * Testando a busca por extensão de arquivo sem extensão.
     * @dataProvider providerFileNames
     */
    public function testExtIsEmpty($file, $ext)
    {
    	list($name, $ext) = @explode('.', $file);
    	$rs = Util_File::Ext($name);
    	$this->assertFalse($rs);
    }
    
    /**
     * Testando a descoberta de mime em nomes de arquivo.
     * @dataProvider providerFileNames
     */
    public function testMimeInName($file, $ext, $mime)
    {
    	$rs = Util_File::Mime($file);
    	$this->assertType('string', $rs);
    	$this->assertEquals($mime, $rs);
    }
    
    /**
     * Testando a descoberta de mime em caminhos de arquivo.
     * @dataProvider providerFiles
     */
    public function testMimeInPath($file)
    {
    	$rs = Util_File::Mime($file);
    	$this->assertType('string', $rs);
    	$this->assertEquals('text/plain', $rs);
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
	
    /**
     * Testando a escrita em arquivo.
     * @dataProvider providerFiles
     */
    public function testWrite($file, $content)
    {
    	if(substr(PHP_OS,0,3) == 'WIN') {
    		$this->markTestSkipped($this->_skipMessage);
    	}
    	
    	$file = $this->_path . $file;
        Util_File::Write($content, $file, true);
        $rs = file_get_contents($file);
        
        $this->assertType('string', $rs);
        $this->assertEquals($content, $rs);
    }

    /**
     * Testando a leitura de arquivo.
     * @dataProvider providerFiles
     */
    public function testRead($file, $content)
    {
    	if(substr(PHP_OS,0,3) == 'WIN') {
    		$this->markTestSkipped($this->_skipMessage);
    	}
    	
        $file = $this->_path . $file;
        $rs   = Util_File::Read($file);
        $this->assertType('string', $rs);
        $this->assertEquals($content, $rs);
    }
}
