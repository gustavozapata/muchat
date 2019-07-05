<?php

class DataAccess {
    private static $instance = null;
    private $connection;

    private function __construct(){
        require_once "database.php";
        $this->connection = new PDO("mysql:host=$host; dbname=$database", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance() {
        if(!self::$instance){
            self::$instance = new DataAccess();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    function checkLogin($username, $password){
        $connection = $this->getConnection();
        $statement = $connection->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $statement->bindValue(":username", $username);
        $statement->bindValue(":password", $password);
        $statement->execute();
        if($statement->rowCount() > 0){
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $_SESSION["id"] = $result["id"];
            $this->userOnline($_SESSION["id"]);
            return true;
        }
        return false;
    }

    function userOnline($id){
        $connection = $this->getConnection();
        $statement = $connection->prepare("UPDATE users SET online = true WHERE id = ?");
        $statement->execute([$id]);
    }
    function userOffline($id){
        $connection = $this->getConnection();
        $statement = $connection->prepare("UPDATE users SET online = false WHERE id = ?");
        $statement->execute([$id]);
    }
    function isTyping($id, $v){
        $connection = $this->getConnection();
        $statement = $connection->prepare("UPDATE users SET typing = ? WHERE id = ?");
        $statement->execute([$v, $id]);
    }

    function loadChatHistory(){
        $connection = $this->getConnection();
        $statement = $connection->prepare("SELECT * FROM users INNER JOIN log ON users.id = log.user ORDER BY log.id");
        $statement->execute();
        $_SESSION["lastInsertedId"] = $this->getLastMessageId();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    function loadUsers() {
        $connection = $this->getConnection();
        $statement = $connection->prepare("SELECT * FROM users");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    function getLastMessageId(){
        $connection = $this->getConnection();
        $statement = $connection->prepare("SELECT id FROM log ORDER BY id DESC LIMIT 1");
        $statement->execute();
        return $statement->fetchColumn();
    }

    function logMessage($id, $message){
        $connection = $this->getConnection();
        $statement = $connection->prepare("INSERT INTO log (user, message) VALUES (?, ?)");
        $statement->execute([$id, $message]);
        $_SESSION['lastInsertedId'] = $connection->lastInsertId();
        return $this->loadNewMessage();
    }

    function fetchNewMessages(){
        if($_SESSION['lastInsertedId'] != $this->getLastMessageId()){
            $connection = $this->getConnection();
            $statement = $connection->prepare("SELECT * FROM users INNER JOIN log ON users.id = log.user WHERE log.id > {$_SESSION['lastInsertedId']}");
            $statement->execute();
            $_SESSION["lastInsertedId"] = $this->getLastMessageId();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        }
        return null;
    }

    function loadNewMessage(){
        $connection = $this->getConnection();
        $statement = $connection->prepare("SELECT * FROM users INNER JOIN log ON users.id = log.user WHERE log.id = {$_SESSION['lastInsertedId']}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    //EVENT SOURCE 
    function serverData(){
        $connection = $this->getConnection();
        $statement = $connection->prepare("SELECT message FROM log LIMIT 1");
        $statement->execute();
        // return $statement->fetchColumn();
        $statement->fetchColumn();
        return "ola pues";
    }
    function theTime(){
        $time = date('r');
        return "yeah!";
    }
}