<?php

require_once get_template_directory() . '/bootstrap.php';
require_once get_template_directory() . '/app/Support/Autoloader.php';

$autoloader = new \IdealBoresh\Support\Autoloader();
$autoloader->register();

$container = new \IdealBoresh\Core\Container();
\IdealBoresh\Core\ContainerResolver::boot($container);

$kernel = new \IdealBoresh\App\Kernel($container);
$kernel->boot();
