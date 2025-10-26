<?php

namespace Src\core;

use Src\DB\Database;

abstract class Model{
    protected static $table;
    protected $attributes = [];
    private static $conn;

    public function __construct(){
        static::$conn = new Database();
    }

    public function __get($key){
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value){
        return $this->attributes[$key] = $value;
    }

    private static function getTable(){
        return static::$table;
    }

    private static function getConn(){
        if(!static::$conn){
            static::$conn = new Database();
            return static::$conn;
        }
        return static::$conn;
    }

    public static function all(){
        self::getConn();
        $table = self::getTable();
        $sql = "SELECT * FROM {$table}";
        return static::$conn->findAll($sql);
    }

    public static function find($id){
        $table = static::getTable();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return static::$conn->findById($sql, ['id' => $id]);
    }
}