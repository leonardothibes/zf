<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 21/11/2011 08:47:29 leonardo $
 */

/** @see Zend_Exception **/
require_once 'Zend/Exception.php';

/** @see Zend_Cache **/
require_once 'Zend/Cache.php';

/** @see Util_Model_Interface **/
require_once 'Util/Model/Interface.php';

/** @see Util_Model_Exception **/
require_once 'Util/Model/Exception.php';

/** @see Util_Model_Filter **/
require_once 'Util/Model/Filter.php';

/** @see Util_Db_Proc **/
require_once 'Util/Db/Proc.php';

/** @see Util_Db_Table **/
//require_once 'Util/Db/Table.php';

/**
 * Classe de abstração de acesso a dados e básica para todas as models.
 *
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Model_Abstract extends Zend_Cache implements Util_Model_Interface
{
	/**
	 * Flag que informa e o driver de cache está ativado.
	 * @var bool
	 */
	protected $_cacheEnabled = false;
	
	/**
	 * Driver de cache.
	 * @var Zend_Cache_Backend_ExtendedInterface
	 */
	protected $_cache = null;
	
	/**
	 * Nome do driver de cache usado no momento.
	 * @var string
	 */
	protected $_driver = 'apc';
	
	/**
	 * Front-end de procedures.
	 * @var Util_Db_Proc
	 */
	protected $procedure = null;
	
	/**
	 * Front-end para os filtros do ZF.
	 * @var Util_Model_Filter
	 */
	protected $filter = null;
	
	/**
	 * Código de sucesso de retorno.
	 * @var int
	 */
	const RETURN_CODE_SUCCESS = 0;
	
	/**
	 * Código de erro de retorno.
	 * @var int
	 */
	const RETURN_CODE_ERROR = -1;
	
	/**
	 * Constantes para tempo de cache em minutos.
	 */
	const HOUR_1  = 60;
	const HOUR_2  = 120;
	const HOUR_3  = 180;
	const HOUR_4  = 240;
	const HOUR_5  = 300;
	const HOUR_10 = 600;
	const HOUR_12 = 720;
	const HOUR_24 = 1440;
	const HOUR_48 = 2880;
	const HOUR_72 = 4320;
	const WEEK    = 10080;
	
	/**
	 * Construtor.
	 */
	public function __construct()
	{
		//Configurando driver de cache.
		$cache = Zend_Registry::get('config')->cache;
		
		if($cache->enable and extension_loaded($cache->driver) and APPLICATION_ENV != 'testing') {
			$this->_cacheEnabled = true;
			$this->_driver       = $cache->driver;
		}
		$this->setCacheDriver($this->_driver);
		//Configurando driver de cache.
		
		//Front-end de procedures.
		$this->procedure = new Util_Db_Proc();
		
		//Front-end para os flitros do ZF.
		$this->filter = new Util_Model_Filter();
		
		//Configurando as classes filhas.
		$this->init();
	}
	
	/**
	 * Método para atuar como construtor nas classes filhas.
	 * @return Util_Model_Interface
	 */
	protected function init()
	{
		//Não faz nada.
	}
	
	/**
	 * Altera o driver de cache em uso.
	 *
	 * @param string $driver  Driver de cache a ser usado(opcional).
	 * @param array  $options Opções do driver(opcional).
	 */
	public function setCacheDriver($driver = 'apc', array $options = array())
	{
		$core_opts = array(
			'caching'                 => $this->_cacheEnabled,
			'automatic_serialization' => true
		);
		$this->_cache  = $this->factory('Core', $driver, $core_opts, $options);
		$this->_driver = $driver;
		return $this;
	}
	
	/**
	 * Retorna o nome do driver de cache em uso.
	 * @return string
	 */
	public function getCacheDriver()
	{
		return (string)$this->_driver;
	}
	
	/**
	 * Testa se um retorno á válido.
	 *
	 * @param mixed  $rs Retorno a ser testado.
	 * @return bool
	 * @throws Model_Exception Caso o retorno não seja válido.
	 */
	public function isValid($rs)
	{
		$default = 'Tipo de retorno inválido';
		if(Util_Format_Array::isValid($rs)) {
			
			$rs = isset($rs[0])      ? $rs[0]      : $rs;
			$rs = isset($rs['row1']) ? $rs['row1'] : $rs;
			
			if(isset($rs['codigo']) and $rs['codigo'] == self::RETURN_CODE_SUCCESS) {
				if((isset($rs['descricao']) and strlen($rs['descricao']))) {
					return true;
				}
			}
			$messagem = (isset($rs['descricao']) and strlen($rs['descricao'])) ? $rs['descricao'] : $default;
			throw new Util_Model_Exception($messagem, $rs['codigo']);
		}
		throw new Util_Model_Exception($default, self::RETURN_CODE_ERROR);
	}
	
	/**
	 * Desabilita completamente o uso de cache.
	 *
	 * Recomenda-se o uso deste recurso somente
	 * para testes ou propósitos bem específicos.
	 *
	 * @return Util_Model_Interface
	 */
	public function disableAllCache()
	{
		$this->_cacheEnabled = false;
		return $this;
	}
	
	/**
	 * Lista todos os IDs de cache salvos.
	 * @return array
	 */
	public function getIds()
    {
    	return $this->_cacheEnabled ? $this->_cache->getIds() : array();
    }
	
    /**
     * Teste se um item de cache está disponível.
     *
     * @param string $id ID do item de cache.
     * @return bool|int Timestamp da última modificação ou FALSE caso indisponível.
     */
	public function test($id)
	{
		return ($this->_cacheEnabled and strlen($id)) ? $this->_cache->test($id) : false;
	}
	
	/**
	 * Recupera um item de cache.
	 *
	 * @param string $id ID do item de cache.
	 * @return mixed Conteúdo do cache ou FALSE caso não esteja mais disponível.
	 */
	public function load($id)
	{
		return $this->_cacheEnabled ? $this->_cache->load($id) : false;
	}
	
	/**
	 * Salva um item no cache.
	 *
	 * @param mixed  $data Conteúdo a ser salvo na cache.
	 * @param string $id   ID do item de cache.
	 * @param int    $ttl  Tempo de vida do cache em minutos(FALSE desativa o cache; NULL deixa infinito).
	 *
	 * @return bool
	 */
	public function save($data, $id, $ttl = false)
    {
    	if($ttl !== false) { $ttl = (int)$ttl * 60; }
    	return $this->_cacheEnabled ? $this->_cache->save($data, $id, array(), $ttl) : false;
    }
	
	/**
	 * Limpa o cache.
	 *
	 * @param string $id ID do cache.
	 * @return bool
	 */
	public function clear($id = null)
	{
		if(!strlen($id)) { return $this->clearAll(); }
    	return $this->_cacheEnabled ? $this->_cache->remove($id) : false;
	}
	
	/**
     * Limpa todo o cache.
     * @return bool
     */
    public function clearAll()
    {
    	return $this->_cacheEnabled ? $this->_cache->clean(Zend_Cache::CLEANING_MODE_ALL) : false;
    }
}
