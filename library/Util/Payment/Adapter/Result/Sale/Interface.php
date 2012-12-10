<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 27/06/2012 14:39:24 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Result_Interface
 */
require_once 'Util/Payment/Adapter/Result/Interface.php';

/**
 * Interface para o processo de venda direta dos gateways de pagamento.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Payment_Adapter_Sale_Interface extends Util_Payment_Adapter_Result_Interface
{
	
}
