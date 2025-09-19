<?php

namespace Src\DB;

use PDO;

class Database{
    protected static $pdo;

    public function __construct(){
        loadEnv(dirname(__DIR__, 2).'/.env');
        
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        
        try {
            self::$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->exec('SET NAMES utf8');
        }catch(\PDOException $e){
            echo json_encode([
                "success" => "false",
                "error" => "Erro no banco de dados",
                "message" => $e->getMessage()
            ]);
            die();
        }
    }

    public static function conn(){
        if(!self::$pdo){
            new Database();
        }
        return self::$pdo;
    }

    private function query($sql, $params = []){
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function findById(string $sql, array $params = []){
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAll(string $sql, array $params = []){
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $sql, array $params = []){
        $stmt = $this->query($sql, $params);
        return $this->conn()->lastInsertId();
    }

    public function update(string $sql, array $params = []){
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    public function delete(string $sql, array $params = []){
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
}