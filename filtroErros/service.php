<?php

namespace Capture;

use Capture\Server;
require_once ("src\Server.php");
$server = new Server();

$server->exec();