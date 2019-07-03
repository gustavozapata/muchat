<?php

session_start();

require_once "../model/DataAccess.php";

if(isset($_SESSION["username"])){
    header('Content-Type: application/json');
    $chat = DataAccess::getInstance()->fetchNewMessages();
    echo json_encode($chat);
}