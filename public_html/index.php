<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Bootstrap
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: index.php 01/06/2012 16:48:52 leonardo $
 */

//Definindo caminho absoluto para a aplicação.
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

//Definindo o ambiente onde a aplicação está rodando.
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

//Configurando o include_path.
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../library/Pear'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

//Executando o Bootstrap e rodando a aplicação.
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();