<?php

namespace Src\core;

use Src\DB\Database;

abstract class Model{
    protected static $table;
    protected $attributes = [];
    private static $conn;

    public function __construct(array $attr = []){
        self::$conn = new Database();
        if($attr){
            $this->fill($attr);
        }
    }

    public function __get($key){
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value){
        return $this->attributes[$key] = $value;
    }

    private function fill(array $data){
        foreach ($data as $key => $value) {
            return $this->attributes[$key] = $value;
        }
    }

    private static function getConn(){
        if(!self::$conn){
            self::$conn = new Database();
            return self::$conn;
        }
        return self::$conn;
    }

    public static function all(){
        self::getConn();
        $table = static::$table;
        $sql = "SELECT * FROM {$table}";
        return self::$conn->findAll($sql);
    }

    public static function find($id){
        self::getConn();
        $table = static::$table;
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return self::$conn->findByKey($sql, ['id' => $id]);
    }

    public static function where($key, $value){
        return new static(['_where' => [$key, $value]]);
    }

    public function first(){
        self::getConn();
        $table = static::$table;
        [$col, $value] = $this->attributes['_where'];
        $sql = "SELECT * FROM {$table} WHERE {$col} = :value LIMIT 1";
        return self::$conn->findByKey($sql, ['value' => $value]);
    }
}