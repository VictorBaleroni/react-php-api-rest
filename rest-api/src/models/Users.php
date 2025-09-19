<?php

namespace Src\Model;

use Src\DB\Database;

class Users{
    private $conn;

    public function __construct(){
        $this->conn = new Database();
    }

    public function getAllUsers(){
        $sql = "SELECT * FROM users";
        return $this->conn->findAll($sql);
    }

    public function getUserById($id){
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->conn->findById($sql, ['id' => $id]);
    }

    public function insertUser($data = []){
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        return $this->conn->insert($sql, $data);
    }

    public function updateUser($data = []){
        $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        return $this->conn->update($sql, $data);
    }

    public function deleteUser($id){
        $sql = "DELETE FROM users WHERE id = :id";
        return $this->conn->delete($sql, ['id' => $id]);
    }
}