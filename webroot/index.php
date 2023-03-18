<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/path.php';

use Restfull\Http\Server;

$server = new Server();
$server->execute();
echo $server->send();
