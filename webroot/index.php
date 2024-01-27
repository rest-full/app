<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/path.php';

use Restfull\Http\Server;
use Restfull\Container\Instances;

try {
    $server = new Server(new Instances());
    $server->execute();
    echo $server->send();
} catch (Throwable $throwable) {
    echo $throwable->getMessage() . $throwable->getFile() . $throwable->getLine();
}