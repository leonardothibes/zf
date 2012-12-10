<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Maxipago.php 20/06/2012 16:33:35 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Abstract
 */
require_once 'Util/Payment/Adapter/Abstract.php';

/**
 * Comunicação com gateway de pagamento Maxipago.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Payment_Adapter_Maxipago extends Util_Payment_Adapter_Abstract
{
	/**
	 * Versão da API do gateway.
	 * @var string
	 */
	protected $_apiVersion = '3.1.1.15';
}




























