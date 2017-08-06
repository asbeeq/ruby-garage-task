<?php

// Paths
define('BASE_PATH', dirname(__DIR__));
define('LAYOUT_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR);
define('TEMPLATE_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR);
define('CONFIG_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR);

// Local DB
define('DB_HOST', 'localhost');
define('DB_NAME', 'task_list');
define('DB_USER', 'root');
define('DB_PASS', '');

// Messages
define('MSG_ERROR', 'danger');
define('MSG_INFO', 'info');
define('MSG_SUCCESS', 'success');