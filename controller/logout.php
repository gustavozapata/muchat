<?php

session_start();

require_once "../model/DataAccess.php";

DataAccess::getInstance()->userOffline($_SESSION["id"]);

session_destroy();

header('Location: ../index.html');
exit;