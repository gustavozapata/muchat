<?php

session_start();

require_once "./model/DataAccess.php";

if(isset($_POST["username"])){
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    if(DataAccess::getInstance()->checkLogin($username, $password)){
        $_SESSION["username"] = $username;
        $chat = DataAccess::getInstance()->loadChatHistory();
        require_once "chat.php";
    } else {
        require_once "index.html";
    }
}