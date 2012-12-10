<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Status.php 26/06/2012 10:22:30 leonardo $
 */

/**
 * Códigos de status da Braspag.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Payment_Adapter_Braspag_Status
{
	/**
	 * O pedido foi AUTORIZADO e confirmado.
	 */
	const Confirmed = 0;
	
	/**
	 * O pedido foi AUTORIZADO e será CONFIRMADO dentro de alguns instantes.
	 */
	const Authorized = 1;
	
	/**
	 * O pedido foi NEGADO por algum motivo.
	 */
	const Denied = 2;
	
	/**
	 * Tranzação EM CURSO.
	 *
	 * Indica que um pedido com o mesmo número está em andamento, já foi iniciado
	 * pela loja junto à Braspag mas ainda não foi finalizado junto à Operadora.
	 */
	const OnGoing = 12;
	
	/**
	 * Tranzação DUPLICADA.
	 *
	 * Indica que um pedido com o mesmo número já foi feito
	 * anteriormente e o mesmo encontra-se com status de Pago.
	 */
	const Duplicated = 13;
}
