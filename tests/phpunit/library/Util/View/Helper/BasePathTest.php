<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: BasePathTest.php 02/01/2012 17:11:52 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_BasePathTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_View_Helper_BasePath
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_View_Helper_BasePath;
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
     * Provider de lista de arquivos.
     * @return array
     */
    public function providerFilesList()
    {
    	return array(
    		array('/img/telesena/favicon.gif'),
    		array('/css/jquery/jquery.css'),
    		array('/css/jquery/fancybox/fancybox-ie.css'),
    		array('/css/telesena/telesena.css'),
    		array('/css/telesena/telesena-provisorio.css'),
    		array('/css/telesena/titulos.css'),
    		array('/css/telesena/formularios.css'),
    		array('/js/jquery/jquery.js'),
    		array('/js/telesena/telesena.js'),
    	);
    }
    
    /**
     * Testa a conversão de caminho.
     * @dataProvider providerFilesList
     */
    public function testBasePath($file)
    {
        $config = Zend_Registry::get('config');
    	
    	//Ativando recurso, caso esteja desativado.
    	if(!$config->static->enable) {
    		$config->static->enable = true;
    		Zend_Registry::set('config', $config);
    	}
    	
    	//Retirando a barra do final da URL.
    	if(substr($config->static->folder, -1, 1) == '/') {
			$config->static->folder = substr($config->static->folder, 0, strlen($config->static->folder) - 1);
		}
    	
    	$rs = Util_Helper::BasePath($file);
    	$this->assertType('string', $rs);
    	$this->assertEquals($config->static->folder . $file, $rs);
    }
}
