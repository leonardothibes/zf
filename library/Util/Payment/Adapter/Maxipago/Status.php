<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Status.php 26/06/2012 10:31:48 leonardo $
 */

/**
 * Códigos de status da Maxipago.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Payment_Adapter_Maxipago_Status
{
	/**
	 * AUTORIZADO.
	 */
	const Authorized = 0;
	
	/**
	 * O pedido foi NEGADO por algum motivo.
	 */
	const Denied = 1;
	
	/**
	 * Erro na operadora do cartão.
	 */
	const ProcessorError = 1022;
	
	/**
	 * Erro nos parâmetros enviados.
	 */
	const ParamError = 1024;
	
	/**
	 * Erro nas credenciais.
	 */
	const CredentialError = 1025;
	
	/**
	 * Erro interno na Maxipago.
	 */
	const GatewayError = 2048;
}
