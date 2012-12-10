<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: HelperTest.php 16/11/2010 10:05:26 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_HelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Helper
     */
    protected $object;
	
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Helper;
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
     * Provider para o Alert.
     * @return array
     */
    public function providerAlert()
    {
    	return array(
    		array('mensagem', '/module/controller/action'),
    		array('msg', '/controller/action'),
    	);
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
     * Testando o redirecionamento por JavaScript.
     * @dataProvider providerAlert
     */
    public function testAlert($msg, $url)
    {
    	ob_start();
    	Util_Helper::Alert($msg, $url);
    	$rs = ob_get_contents();
    	$rs = (string)preg_replace('/\n+/', '', trim($rs));
    	$rs = (string)preg_replace('/\s+/', '', trim($rs));
    	$string = sprintf('<scripttype="text/JavaScript">alert("%s");window.document.location.href="%s";</script>', $msg, $url);
    	ob_end_clean();
    	$this->assertEquals($string, $rs);
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
    
	/**
     * Testa a conversão de caminho desabilitada.
     * @dataProvider providerFilesList
     */
    public function testBasePathDisable($file)
    {
    	$config = Zend_Registry::get('config');
    	
    	//Inativando recurso, caso esteja ativado.
    	if($config->static->enable) {
    		$config->static->enable = false;
    		Zend_Registry::set('config', $config);
    	}
    	
    	$rs = Util_Helper::BasePath($file);
    	$this->assertType('string', $rs);
    	$this->assertEquals($file, $rs);
    }
    
	/**
     * Testa a conversão de caminho com a opção "force".
     * @dataProvider providerFilesList
     */
    public function testBasePathForce($file)
    {
    	$config = Zend_Registry::get('config');
    	
    	//Inativando recurso, caso esteja ativado.
    	if($config->static->enable) {
    		$config->static->enable = false;
    		Zend_Registry::set('config', $config);
    	}
    	
    	$rs = Util_Helper::BasePath($file, true);
    	$this->assertType('string', $rs);
    	$this->assertEquals($config->static->folder . $file, $rs);
    }
    
    /**
     * Testa a listagem de estados.
     */
    public function testEstadosCompleto()
    {
    	$rs = Util_Helper::Estados(true);
    	
    	$this->assertType('array', $rs);
    	$this->assertEquals(27, count($rs));
    	
    	$estados = array(
			'AC' => 'Acre',
			'AL' => 'Alagoas',
			'AP' => 'Amapá',
			'AM' => 'Amazonas',
			'BA' => 'Bahia',
			'CE' => 'Ceará',
			'DF' => 'Distrito Federal',
			'ES' => 'Espírito Santo',
			'GO' => 'Goiás',
			'MA' => 'Maranhão',
			'MT' => 'Mato Grosso',
			'MS' => 'Mato Grosso do Sul',
			'MG' => 'Minas Gerais',
			'PA' => 'Pará',
			'PB' => 'Paraíba',
			'PR' => 'Paraná',
			'PE' => 'Pernambuco',
			'PI' => 'Piauí',
			'RJ' => 'Rio de Janeiro',
			'RN' => 'Rio Grande do Norte',
			'RS' => 'Rio Grande do Sul',
			'RO' => 'Rondônia',
			'RR' => 'Roraima',
			'SC' => 'Santa Catarina',
			'SP' => 'São Paulo',
			'SE' => 'Sergipe',
			'TO' => 'Tocantins'
		);
    	
    	foreach($rs as $sigla => $nome) {
    		
    		$this->assertType('string', $sigla);
    		$this->assertEquals(2, strlen($sigla));
    		$this->assertRegExp('/^[A-Z]{2}$/', $sigla);
    		
    		$this->assertType('string', $nome);
    		$this->assertEquals($estados[$sigla], $nome);
    	}
    }
    
    /**
     * Testa a listagem de estados somente a sigla.
     */
    public function testEstadosSiglas()
    {
    	$rs = Util_Helper::Estados();
    	
    	$this->assertType('array', $rs);
    	$this->assertEquals(27, count($rs));
    	
    	$estados = array('AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO');
		foreach($rs as $i => $sigla) {
    		$this->assertType('string', $i);
    		$this->assertTrue(in_array($sigla, $estados));
    	}
    }
}
