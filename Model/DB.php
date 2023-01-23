<?php

namespace Model;

if(!isset($_SESSION)) { 
    session_start(); 
} 
class DB {
    private static $conn; 
    
    public static function conn(){
        try {
        if (is_null(self::$conn)){
            ini_set('display_errors', 1);
            self::$conn = new \PDO('mysql:host=localhost;dbname=newos;charset=utf8', 'root', 'com123');
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }catch(\PDOException $e) {
        echo 'ERROR: Error connecting to database';
    }
    }        
}