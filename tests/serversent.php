<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require_once "../model/DataAccess.php";

//THE TIME
// $time = DataAccess::getInstance()->theTime();
// echo "data: the server time is: {$time}\n\n";

$chat = DataAccess::getInstance()->serverData();
echo "data: {$chat}\n";

flush();