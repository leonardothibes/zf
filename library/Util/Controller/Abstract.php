<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Default
 * @subpackage Controllers
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ControllerAbstract.php 01/06/2012 17:31:22 leonardo $
 */

/**
 * @see Zend_Controller_Action
 */
require_once 'Zend/Controller/Action.php';

/**
 * Controller base para as páginas públicas.
 *
 * @category Application
 * @package Default
 * @subpackage Controllers
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Controller_Abstract extends Zend_Controller_Action
{
	/**
	 * URL completa que está sendo usada no momento.
	 * @var string
	 */
	protected $url = null;
	
	/**
	 * Instância da classe de log.
	 * @var Zend_Log
	 */
	protected $log = null;
	
	/**
	 * Configurações primárias dos controllers.
	 *
	 * Este método é executado DEPOIS do init
	 * dos controllers.
	 *
	 * @see Zend/Controller/Zend_Controller_Action::preDispatch()
	 */
	public function preDispatch()
	{
		//Iniciando URL.
		$this->url = sprintf(
			'%s://%s%s',
			$this->_request->getScheme(),
			$this->_request->getHttpHost(),
			$this->_request->getRequestUri()
		);
		
		//iniciando classe de log.
		$this->log = Zend_Registry::get('log');
		
		//Dados da página atual.
		$this->view->module     = $this->_request->getModuleName();
		$this->view->controller = $this->_request->getControllerName();
		$this->view->action     = $this->_request->getActionName();
	}
	
	/**
	 * Recupera um parâmetro de rota com valor default
	 * caso esteja em branco ou não seja informado
	 *
	 * @param string $name    Nome do prâmetro de rota.
	 * @param mixed  $default Valor default do parâmetro.
	 *
	 * @return mixed
	 */
	protected function getParam($name, $default = null)
	{
		$value = $this->_getParam($name);
		return (strpos($value, ':') === 0) ? $default : $value;
	}
	
	/**
	 * Altera o header do site para XML.
	 *
	 * @param string $charset
	 * @return Zend_Controller_Action_Interface
	 */
	protected function setHeaderAsXml($charset = null)
	{
		$this->setHeader('text/xml', $charset);
		return $this;
	}
	
	/**
	 * Altera o header do site para HTML.
	 *
	 * @param string $charset
	 * @return Zend_Controller_Action_Interface
	 */
	protected function setHeaderAsHtml($charset = null)
	{
		$this->setHeader('text/html', $charset);
		return $this;
	}
	
	/**
	 * Altera o header da página.
	 *
	 * @param string $header
	 * @param string $charset
	 *
	 * @return Zend_Controller_Action_Interface
	 */
	protected function setHeader($type, $charset = null)
	{
		$charset = strlen($charset) ? (string)$charset : Bootstrap::$charset;
		header(sprintf('Content-Type: %s; charset=%s', $type, $charset));
		return $this;
	}
	
	/**
	 * Desativa a renderização do layout para uma action.
	 * @return Zend_Controller_Action_Interface
	 */
	protected function setNoLayout()
	{
		$this->_helper->layout()->disableLayout();
		return $this;
	}
	
	/**
	 * Desativa a renderização da view para uma action.
	 * @return Zend_Controller_Action_Interface
	 */
	protected function setNoView()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		return $this;
	}
}
