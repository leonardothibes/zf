<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Bootstrap
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Bootstrap.php 01/06/2012 16:53:08 leonardo $
 */

/**
 * @see Zend_Application_Bootstrap_Bootstrap
 */
require_once 'Zend/Application/Bootstrap/Bootstrap.php';

/**
 * @category Application
 * @package Bootstrap
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * Codificação de caracteres.
	 * @var string
	 */
	static public $charset = 'UTF-8';
	
	/**
	 * Nome do módulo acessado no momento.
	 * @var string
	 */
	static public $module = 'default';
	
	/**
	 * Inicia o Class Autoloader.
	 */
	static public function _initClassLoader()
	{
		/** @see Zend_Loader_Autoloader **/
		require_once 'Zend/Loader/Autoloader.php';
		Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
	}
	
	/**
	 * Carregando módulos no Front Controller.
	 */
	static public function _initControllerFront()
	{
		$frontController = Zend_Controller_Front::getInstance();
		$frontController->setDefaultModule(self::$module);
		
		$directoryiterator = new DirectoryIterator(APPLICATION_PATH);
		$request           = new Zend_Controller_Request_Http();
		
		foreach($directoryiterator as $directory) {
			$name = $directory->getBaseName();
			if($directory->isDir() and substr($name, 0, 1) != '.' and $name != 'configs') {
				
				//Adicionando os diretórios de controllers.
				$controllers = sprintf(APPLICATION_PATH . '/%s/controllers', $name);
				$frontController->addControllerDirectory($controllers, $name);
				
				//Definindo o módulo atual.
				$route = new Zend_Controller_Router_Route_Regex(sprintf('/%s/*', $name));
				if(is_array($route->match($request->getRequestUri(), true))) {
					self::$module = $name;
				}
			}
		}
	}
	
	/**
	 * Adicionando diretórios no include_path.
	 */
	static public function _initIncludePath()
	{
		set_include_path(implode(PATH_SEPARATOR, array(
			get_include_path(),
			sprintf('%s/%s/models'     , APPLICATION_PATH, self::$module),
			sprintf('%s/%s/forms'      , APPLICATION_PATH, self::$module),
			sprintf('%s/%s/controllers', APPLICATION_PATH, self::$module)
		)));
	}
	
	/**
	 * Configurações regionais.
	 */
	static public function _initLocale()
	{
		setlocale(LC_ALL, 'pt_BR');
		setlocale(LC_NUMERIC, 'en_US');
		date_default_timezone_set('America/Sao_Paulo');
	}
	
	/**
	 * Configurações de log.
	 */
	static public function _initLog()
	{
		try {
			$dir = APPLICATION_PATH . '/../data/logs';
			if(!is_dir($dir) or !is_writable($dir)) {
				throw new Zend_Application_Bootstrap_Exception(sprintf(
					'O diretório de logs "%s" não existe ou não possui permissão de escrita.',
					$dir
				));
			}
			
			//Data corrente.
			$date = date("Y-m-d");
			
			//Log da applicação
			$file = sprintf('%s/application_%s.log', $dir, $date);
			Zend_Registry::set('log_file', $file);
			
			//Log de erros do próprio PHP.
			ini_set('log_errors', 'On');
			ini_set('error_log' , sprintf('%s/php_%s.log', $dir, $date));
			
			//Log em disco.
			$log = new Zend_Log(new Zend_Log_Writer_Stream($file));
			Zend_Registry::set('log', $log);
			
			//Log no console do Firebug.
			$fb = new Zend_Log(new Zend_Log_Writer_Firebug());
			Zend_Registry::set('fb', $fb);
		} catch(Exception $e) {
			die($e->getMessage());
		}
	}
	
	/**
	 * Obtendo o número da versão.
	 */
	static public function _initVersion()
	{
		$file    = sprintf('%s/../.version', APPLICATION_PATH);
		$version = @file_get_contents($file);
		Zend_Registry::set('version', $version);
	}
	
	/**
	 * Carregando rotas.
	 */
	static public function _initRoutes()
	{
		try {
			$file   = APPLICATION_PATH . '/configs/routes.ini';
			$router = Zend_Controller_Front::getInstance()->getRouter();
			$router->addConfig(new Zend_Config_Ini($file), 'routes');
		} catch(Exception $e) {
			//Nada a fazer.
		}
	}
	
	/**
	 * Carregando arquivo de configuração.
	 */
	static public function _initConfigFile()
	{
		$file    = sprintf('%s/configs/config.ini', APPLICATION_PATH);
		$options = (APPLICATION_ENV === 'testing') ? array('allowModifications' => true) : array();
		$config  = new Zend_Config_Ini($file, APPLICATION_ENV, $options);
		Zend_Registry::set('config', $config);
	}
	
	/**
	 * Conectando com o banco de dados.
	 */
	static public function _initDb()
	{
		if(Zend_Registry::isRegistered('config')) {
			$config = Zend_Registry::get('config')->db;
			$db     = Zend_Db::factory($config->adapter, array(
				'host'     => $config->hostname,
				'username' => $config->username,
				'password' => $config->password,
				'dbname'   => $config->dbname,
				'pdoType'  => (strtoupper($config->adapter) == 'PDO_MSSQL') ? 'dblib' : null
			));
			Zend_Registry::set('db', $db);
			Zend_Db_Table_Abstract::setDefaultAdapter($db);
		}
	}
	
	/**
	 * Configurando os cabeçalhos da requisição http.
	 */
	static public function _initHeaders()
	{
		header(sprintf('Content-Type: text/html; charset=%s', self::$charset));
	}
	
	/**
	 * Configurando views e helpers.
	 */
	public function _initViewHelpers()
	{
		$view = new Zend_View();
		$view->setEncoding(strtolower(self::$charset))
		     ->addHelperPath('Util/View/Helper', 'Util_View_Helper')
		     ->addHelperPath('ZendX/jQuery/View/Helper', 'ZendX_jQuery_View_Helper');
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		Zend_Registry::set('view', $view);
	}
	
	/**
	 * Iniciando Zend_Layout.
	 */
	static public function _initLayout()
	{
		if(!isset($_GET['ajax'])) {
			$path = sprintf('%s/%s/views/layouts', APPLICATION_PATH, self::$module);
			if(file_exists($path . '/main.phtml')) {
				Zend_Layout::startMvc(array(
					'layoutPath' => $path,
					'layout'     => 'main'
				));
			}
		}
	}
	
	/**
	 * Configura o namespace da sessão de acordo com o módulo.
	 */
	static public function _initSession()
	{
		try {
			$save_path = sprintf('%s/../data/sessions', APPLICATION_PATH);
			if(!is_dir($save_path) or !is_writable($save_path)) {
				throw new Zend_Application_Bootstrap_Exception(sprintf(
					'O diretório de sessions "%s" não existe ou não possui permissão de escrita.',
					$save_path
				));
			}
			
			//Alterando o save_path da sessão.
			$options              = Zend_Session::getOptions();
			$options['save_path'] = $save_path;
			unset($options['auto_start']);
			Zend_Session::start($options);
				
			//Registrando o namespace na sessão.
			$namespace = strtoupper(self::$module);
			Zend_Registry::set('session_namespace', new Zend_Session_Namespace($namespace));
				
			//Registrando o namespace na Zend_Auth.
			$auth = Zend_Auth::getInstance();
			$auth->setStorage(new Zend_Auth_Storage_Session($namespace));
		} catch(Exception $e) {
			die($e->getMessage());
		}
	}
	
	/**
	 * Configura o bootstrap específico do módulo solicitado.
	 */
	static public function _initModule()
	{
		$file  = sprintf('%s/%s/Bootstrap.php', APPLICATION_PATH, self::$module);
		$class = ucfirst(strtolower(self::$module)) . '_Bootstrap';
		
		if(file_exists($file) and is_readable($file)) {
			
			require_once $file;
			$reflection = new ReflectionClass($class);
			$methods    = $reflection->getMethods(ReflectionMethod::IS_STATIC);
			
			foreach($methods as $method) {
				$method = (string)$method->name;
				if(strlen($method) > 5 and substr($method, 0, 5) === '_init') {
					$reflection->getMethod($method)->invoke($reflection->newInstance());
				}
			}
		}
	}
}
