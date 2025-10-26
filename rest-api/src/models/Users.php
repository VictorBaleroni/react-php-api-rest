<?php

namespace Src\models;

use Src\core\Model;

class Users extends Model{
    protected static $table = 'users';

    // public function insertUser($data = []){
    //     $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    //     return $this->conn->insert($sql, $data);
    // }

    // public function updateUser($data = []){
    //     $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
    //     return $this->conn->update($sql, $data);
    // }

    // public function deleteUser($id){
    //     $sql = "DELETE FROM users WHERE id = :id";
    //     return $this->conn->delete($sql, ['id' => $id]);
    // }
}