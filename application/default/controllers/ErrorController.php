<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Default
 * @subpackage Controllers
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ErrorController.php 01/06/2012 17:20:52 leonardo $
 */

/**
 * Controller de tratamento de erros.
 *
 * @category Application
 * @package Default
 * @subpackage Controllers
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class ErrorController extends Zend_Controller_Action
{
	/**
	 * Tela de erro.
	 */
	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');
		
		if(!$errors or !$errors instanceof ArrayObject) {
			$this->view->message = 'You have reached the error page';
			return;
		}
		
		switch($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				// 404 error -- controller or action not found.
				$this->getResponse()->setHttpResponseCode(404);
				$priority = 'notice';
				$this->view->message = 'Página não encontrada.';
			break;
			default:
				//Application error.
				$this->getResponse()->setHttpResponseCode(500);
				$priority = 'crit';
				$this->view->message = 'Erro interno do site.';
			break;
		}
		
		//Log exception, if logger available.
		Util_Debug::Log($this->view->message, $priority);
		Util_Debug::Log(
			array(
				'Message'            => $errors->exception->getMessage(),
				'Request Parameters' => $errors->request->getParams(),
				'Stack trace'        => $errors->exception->getTraceAsString()
			), $priority
		);
		
		//LOG original do framework(desabilitado).
		if($log = $this->getLog()) {
			//$log->log($this->view->message, $priority, $errors->exception);
			//$log->log('Request Parameters', $priority, $errors->request->getParams());
		}
		
		//Conditionally display exceptions.
		if($this->getInvokeArg('displayExceptions') == true) {
			$this->view->exception = $errors->exception;
		}
		
		$this->view->request = $errors->request;
	}
	
	/**
	 * Função de LOG original do ZF.
	 * Não estamos utilizando no momento.
	 */
	public function getLog()
	{
		$bootstrap = $this->getInvokeArg('bootstrap');
		if (!$bootstrap->hasResource('Log')) {
			return false;
		}
		$log = $bootstrap->getResource('Log');
		return $log;
	}
}
