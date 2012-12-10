<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 27/06/2012 14:45:01 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Authorization_Interface
 */
require_once 'Util/Payment/Adapter/Authorization/Interface.php';

/**
 * @see Util_Payment_Adapter_Capture_Interface
 */
require_once 'Util/Payment/Adapter/Capture/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Payment_Adapter_Sale_Abstract
implements
	Util_Payment_Adapter_Authorization_Interface,
	Util_Payment_Adapter_Capture_Interface
{
	
}
