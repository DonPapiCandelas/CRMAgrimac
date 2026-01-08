<?php

    set_time_limit(0);
    ob_start();

    spl_autoload_register(function ($class) {
        switch (substr($class, 0, 1)) {
            case 'a':
                require_once ROOT . '/includes/classes/' . $class . '.php';
                break;
            case 'c':
                require_once ROOT . '/includes/controllers/' . $class . '.php';
                break;
            case 'm':
                require_once ROOT . '/includes/models/' . $class . '.php';
                break;
            case 'r':
                require_once ROOT . '/includes/routes/' . $class . '.php';
                break;
        }
    });

    require_once './includes/init.php';

    ob_end_flush();