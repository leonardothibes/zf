<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Bootstrap
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Bootstrap.php 01/06/2012 18:13:29 leonardo $
 */

//Definindo caminho para a aplicação.
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

//Definindo ambiente onde está rodando.
define('APPLICATION_ENV', 'testing');

//Definindo o "include_path".
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../library/Pear'),
    get_include_path(),
)));

/** @see Zend_Application **/
require_once 'Zend/Application.php';

//Rodando o Booststrap da aplicação.
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();

//Registrando configuração dos testes.
$config = new Zend_Config_Ini(sprintf('%s/../tests/phpunit/config.ini', APPLICATION_PATH), APPLICATION_ENV);
Zend_Registry::set('tests', $config);