<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'name', 'role'];

    public function validateUser($username, $password) {
        $user = $this->where('username', $username)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
