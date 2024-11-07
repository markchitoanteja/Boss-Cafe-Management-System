<?php
$routes = [
    // Normal Pages
    '' => '../app/views/auth/login.php',
    'login' => '../app/views/auth/login.php',
    'dashboard' => '../app/views/pages/dashboard.php',
    'menu_management' => '../app/views/pages/menu_management.php',
    'inventory' => '../app/views/pages/inventory.php',
    'orders' => '../app/views/pages/orders.php',
    'backup_and_restore' => '../app/views/pages/backup_and_restore.php',
    'sales_report' => '../app/views/pages/sales_report.php',
    'customer_reports' => '../app/views/pages/customer_reports.php',

    // Server
    'server' => '../app/controllers/Controller.php',

    // Error Pages
    '403' => '../app/views/errors/403.php',
    '404' => '../app/views/errors/404.php',
    '500' => '../app/views/errors/500.php',
];
