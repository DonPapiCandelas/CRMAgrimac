<?php

    //Evitar lectura cache
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

    define('ROOT', dirname(__FILE__, 2));

    // Incluyendo librerias principales
    require_once ROOT . '/includes/database/Cache.php';
    require_once ROOT . '/includes/database/DatabaseInterface.php';
    require_once ROOT . '/includes/database/Database.php';
    require_once ROOT . '/includes/database-sql/MyPDO.php';
    require_once ROOT . '/includes/database-sql/SQLDatabase.php';

    // Definicion de conexion con la base de Datos
    $config = [
        'host'		=> 'localhost',
        'driver'	=> 'mysql',
        'database'	=> 'agrimac',
        'username'	=> 'root',
        'password'	=> '',
        'charset'	=> 'utf8',
        'collation'	=> 'utf8_general_ci',
        'prefix'	 => 'amac_'
    ];

    $db = new Database($config);
    $sql = new SQLDatabase();

    // Cargar variables de sistema
    $input = (new aCore)->loadAll();
    $settings = (new aCore)->get_settings();
    $cookies = (new aCore)->get_cookies();
    $user = (new cUser)->get_user_session();
    $perms = ($user instanceof stdClass) ? (array) (new cUser)->get_user_permissions($user->id) : array();
    $router = new router($settings['directory']);

    if(!$user instanceof stdClass && $router->path() != '/login') {
        $router->redirect('/.*', '/login');
    } else if($user instanceof stdClass && $router->path() == '/login') {
        $router->redirect('/login', '/');        
    }

    (new cUser)->updateTime();

    require_once ROOT . '/includes/routes/routes.php';
    