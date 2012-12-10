<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Helper
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Helper.php 19/10/2010 13:33:56 leonardo $
 */

/**
 * @see Zend_Controller_Action_Helper_Abstract
 */
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * Helpers de uso geral.
 *
 * @category Library
 * @package Util
 * @subpackage Helpers
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Helper extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Faz um redirecionamento de página.
	 * @param string $url Url para onde será feito o redirecionamento.
	 */
	static public function Redirect($url)
	{
		header(sprintf('Location: %s', $url));
		exit;
	}
	
	/**
	 * Exibe um alert em JavaScript e logo em seguida redireciona o usuário.
	 *
	 * O redirecionamento é feito via JavaScript devido a limitação da manipulação
	 * de cabeçalhos do PHP, que não redireciona o usuário após algo ter sido impresso
	 * na tela.
	 *
	 * @param string $msg Mensagem que irá aparecer no alert.
	 * @param string $url URL para ondo o usuário será redirecionado.
	 */
	static public function Alert($msg, $url = '/')
	{
		$tag = '
			<script type="text/JavaScript">
				alert("%s");
				window.document.location.href = "%s";
			</script>
		';
		
		$msg = strtr($msg, array(
			'"' => '',
			"'" => ''
		));
		
		echo sprintf($tag, addslashes($msg), $url);
		if(isset($_SERVER['HTTP_USER_AGENT'])) { exit; }
	}
	
	/**
	 * Exibe um alert em JavaScript e logo em seguida fecha o navegador.
	 * @param string $msg Mensagem que irá aparecer no alert.
	 */
	static public function AlertClose($msg)
	{
		$tag = '
			<script type="text/JavaScript">
				alert("%s");
				window.close();
			</script>
		';
		
		$msg = strtr($msg, array(
			'"' => '',
			"'" => ''
		));
		
		echo sprintf($tag, addslashes($msg));
		if(isset($_SERVER['HTTP_USER_AGENT'])) { exit; }
	}
	
	/**
	 * Fecha a janela do navegador.
	 *
	 * Este método normalmente é usado dentro um POST. Caso o
	 * método seja chamado em linha de comando nada acontece.
	 *
	 * @param bool $force_exit
	 */
	static public function WindowClose($force_exit = false)
	{
		if(isset($_SERVER['HTTP_USER_AGENT'])) {
			echo '
				<script type="text/javascript">
					window.close();
				</script>
			';
		} else if($force_exit === true) {
			exit;
		}
	}
	
	/**
	 * Converte caminho relativo em caminho absoluto.
	 *
	 * @param string $file  Caminho relativo para o arquivo.
	 * @param bool   $force Força a utilização da conversão.
	 *
	 * @return string Caminho absoluto.
	 */
	static public function BasePath($file, $force = false)
	{
		$static = Zend_Registry::get('config')->static;
		if($static->enable or $force) {
			
			//Retirando a barra do final da URL.
			if(substr($static->folder, -1, 1) == '/') {
				$static->folder = substr($static->folder, 0, strlen($static->folder) - 1);
			}
			
			//Concatenando URL com o caminho para o arquivo.
			return $static->folder . Util_Format_String::FirstSlash($file);
		}
		
		return $file;
	}
	
	/**
	 * Retorna uma lista com os estados do Brasil.
	 *
	 * @param bool $nomes Se ativado então retorna os nomes completos dos estados.
	 * @return array
	 */
	static public function Estados($nomes = false)
	{
		if($nomes === true) {
			return array(
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
		} else {
			return array(
				'AC' => 'AC',
				'AL' => 'AL',
				'AM' => 'AM',
				'AP' => 'AP',
				'BA' => 'BA',
				'CE' => 'CE',
				'DF' => 'DF',
				'ES' => 'ES',
				'GO' => 'GO',
				'MA' => 'MA',
				'MG' => 'MG',
				'MS' => 'MS',
				'MT' => 'MT',
				'PA' => 'PA',
				'PB' => 'PB',
				'PE' => 'PE',
				'PI' => 'PI',
				'PR' => 'PR',
				'RJ' => 'RJ',
				'RN' => 'RN',
				'RO' => 'RO',
				'RR' => 'RR',
				'RS' => 'RS',
				'SC' => 'SC',
				'SE' => 'SE',
				'SP' => 'SP',
				'TO' => 'TO'
			);
		}
	}
}
