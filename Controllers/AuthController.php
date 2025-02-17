<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class AuthController extends Controller
{
    protected $user;

    function __construct()
    {
        helper(['form']);
        $this->user = new UserModel();
    }

    public function register()
    {
        $text = [
            'title' => "Register | Perpus Digital",
            'header' => "Perpus Digital",
            'message' => "Please sign up first"
        ];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]|is_unique[user.username]',
                'password' => 'required|min_length[6]|max_length[200]',
                'password_confirm' => 'matches[password]',
                'name' => 'required|min_length[3]|max_length[100]',
                'role' => 'required|in_list[admin,petugas,peminjam]',
            ];
    
            if (!$this->validate($rules)) {
                $data = [
                    'validation' => $this->validator,
                    'page' => view('auth/v_register', array_merge($text, ['validation' => $this->validator])),
                ];
            } else {
                $data = [
                    'username' => $this->request->getVar('username'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'name' => $this->request->getVar('name'),
                    'role' => $this->request->getVar('role'),
                ];
                $this->user->save($data);
    
                return redirect()->to('register')->with('success', 'Registration successful! Please login.');
            }
        } else {
            $data = [
                'page' => view('auth/v_register', $text),
            ];
        }
    
        echo view("auth/v_authpage", $data);
    }
    

    public function login()
    {
        $text = [
            'title' => "Login | Perpus Digital",
            'header' => "Perpus Digital",
            'message' => "Sign in to start your session"
        ];

        if ($this->request->getMethod() == 'post') {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
    
            $user = $this->user->where('username', $username)->first();
    
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $sessionData = [
                        'id'        => $user['id'],
                        'username'  => $user['username'],
                        'name'      => $user['name'],
                        'role'      => $user['role'],
                        'isLoggedIn'=> true,
                    ];
    
                    session()->set($sessionData);
                    return redirect()->to('books'); // Redirect to the books page
                } else {
                    session()->setFlashdata('error', 'Password is incorrect.');
                }
            } else {
                session()->setFlashdata('error', 'Username not found.');
            }
            return redirect()->to('login');
        }
    
        $data['page'] = view('auth/v_login', $text);
        echo view('auth/v_authpage', $data);
    }
    

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login?status=succes');
    }
}
