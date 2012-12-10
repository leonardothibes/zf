<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: File.php 22/12/2010 11:40:16 leonardo $
 */

/**
 * @see Zend_Auth_Storage_Interface
 */
require_once 'Zend/Auth/Storage/Interface.php';

/**
 * @see Util_File
 */
require_once 'Util/File.php';

/**
 * Storage de sessão em arquivo em disco compatível com Zend_Auth.
 *
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Auth_Storage_File implements Zend_Auth_Storage_Interface
{
	/**
	 * location for the directory of session's write.
	 * @var string
	 */
	protected $_location = '/tmp/Zend_Auth';
	
	/**
	 * Storage file.
	 * @var string
	 */
	protected $_storage = null;
	
	/**
     * Session namespace
     *
     * @var mixed
     */
    protected $_namespace = null;

    /**
     * Session object member
     *
     * @var mixed
     */
    protected $_member = null;
	
	/**
	 * Sets file storage options.
	 *
	 * @param string $location
	 * @return void
	 */
	public function __construct($namespace = 'Zend_Auth', $member = 'storage')
	{
		$this->_namespace = (string)$namespace;
        $this->_member    = (string)$member;
		$this->_createStorage();
	}
	
	/**
	 * Create the directory of session's write.
	 * @return void
	 */
	private function _createStorage()
	{
		if(!is_dir($this->_location)) {
			mkdir($this->_location, 0700);
		}
		
		if(!Zend_Registry::isRegistered('Util_Auth_Storage_File')) {
			$storage = $this->_member . '_' . md5(rand(1000,2000));
			Zend_Registry::set('Util_Auth_Storage_File', $storage);
		}
		
		$this->_storage = $this->_location . '/' . Zend_Registry::get('Util_Auth_Storage_File');
	}
	
	/**
     * Returns true if and only if storage is empty
     *
     * @throws Zend_Auth_Storage_Exception If it is impossible to determine whether storage is empty
     * @return boolean
     */
    public function isEmpty()
    {
    	if(!file_exists($this->_storage)) {
    		return true;
    	}
    	
    	return (filesize($this->_storage) === 0);
    }

    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws Zend_Auth_Storage_Exception If reading contents from storage is impossible
     * @return mixed
     */
    public function read()
    {
    	return Util_File::Read($this->_storage);
    }

    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     * @throws Zend_Auth_Storage_Exception If writing $contents to storage is impossible
     * @return void
     */
    public function write($contents)
    {
    	Util_File::Write($contents, $this->_storage, true);
    }

    /**
     * Clears contents from storage
     *
     * @throws Zend_Auth_Storage_Exception If clearing contents from storage is impossible
     * @return void
     */
    public function clear()
    {
    	unlink($this->_storage);
    }
}
