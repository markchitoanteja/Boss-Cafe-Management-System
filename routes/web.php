<?php
$routes = [
    // Normal Pages
    '' => '../app/views/auth/login.php',
    'login' => '../app/views/auth/login.php',
    'dashboard' => '../app/views/pages/dashboard.php',
    'menu_management' => '../app/views/pages/menu_management.php',

    // Server
    'server' => '../app/controllers/Controller.php',

    // Error Pages
    '403' => '../app/views/errors/403.php',
    '404' => '../app/views/errors/404.php',
    '500' => '../app/views/errors/500.php',
];
