<?php

session_start();

require_once "../model/DataAccess.php";

if(isset($_REQUEST["message"])){
    header('Content-Type: application/json');
    $chat = DataAccess::getInstance()->fetchNewMessages();
    DataAccess::getInstance()->isTyping($_SESSION["id"], false);
    echo json_encode($chat);
}

if(isset($_REQUEST["status"])){
    header('Content-Type: application/json');
    $status = DataAccess::getInstance()->loadUsers();
    echo json_encode($status);
}

if(isset($_REQUEST["typing"])){
    DataAccess::getInstance()->isTyping($_SESSION["id"], true);
}