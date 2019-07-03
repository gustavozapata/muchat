<?php

session_start();

require_once "DataAccess.php";

if(isset($_SESSION["username"])){
    header('Content-Type: application/json');
    $chat = DataAccess::getInstance()->logMessage($_SESSION["id"], $_POST["message"]);
    echo json_encode($chat);
}