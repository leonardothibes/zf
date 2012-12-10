<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * Email validation rule
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license that
 * is available through the world-wide-web at the following URI: http://www.php.
 * net/license/3_01.txt If you did not receive a copy of the PHP License and are
 * unable to obtain it through the web, please send a note to license@php.net so
 * we can mail you a copy immediately.
 *
 * @category    HTML
 * @package     HTML_QuickForm
 * @author      Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright   2001-2007 The PHP Group
 * @license     http://www.php.net/license/3_01.txt PHP License 3.01
 * @version     $Id: Cep.php 17/03/2009 14:12:45 leonardo_thibes $
 * @link        http://pear.php.net/package/HTML_QuickForm
 */

/**
 * Abstract base class for QuickForm validation rules
 */
require_once 'HTML/QuickForm/Rule.php';

/**
 * Date validation rule
 *
 * @category    HTML
 * @package     HTML_QuickForm
 * @author      Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @version     Release: 3.2.9
 * @since       3.2
 */
class HTML_QuickForm_Rule_Phone extends HTML_QuickForm_Rule
{
	
	/**
	 * Validate an Fone code.
	 *
	 * @param string $fone Fone.
	 * @return bool
	 */
	public function validate($fone, $options = null)
	{
		return preg_match(Util_Format_Phone::Regex . 'D', $fone) ? true : false;
	}
	
	/**
     * Generate JavaScript Code.
     */
    public function getValidationScript($options = null)
    {
        return array("  var regex = " . Util_Format_Phone::Regex . ";\n", "{jsVar} != '' && !regex.test({jsVar})");
    }
	
}
