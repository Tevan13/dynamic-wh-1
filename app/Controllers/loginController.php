<?php

namespace App\Controllers;

use App\Models\userModel;

class loginController extends BaseController
{
    public function __construct()
    {
        $this->uModel = new userModel();
    }
    public function index()
    {
        if (session()->get('tb_user') != null) {
            return redirect()->to('/dashboard');
        }
        return view('/auth/login');
    }
    public function action()
    {
        $uname = $this->request->getPost("username");
        $pass = $this->request->getPost("password");
        $user = $this->uModel->getUserByUnamePassword($uname, $pass);

        // // Debugging
        // d("Username: " . $uname);
        // d("Password: " . $pass);
        // // Debugging
        // d("User from Database: ", $user);
        // d("Last Query: ", $this->uModel->db->getLastQuery());

        if ($user) {
            // Login successful
            session()->set([
                'tb_user' => [
                    'uname' => $user["username"],
                    'level' => $user["hak_akses"],
                    'id' => $user["idUser"]
                ]
            ]);
            // Check if "remember" checkbox is checked
            if ($this->request->getPost("remember")) {
                // Set a remember me cookie with the user's email
                setcookie("remember_uname", $uname, time() + (86400 * 30), "/"); // Cookie expires in 30 days
            } else {
                // Remove the remember me cookie if present
                if (isset($_COOKIE["remember_uname"])) {
                    unset($_COOKIE["remember_uname"]);
                    setcookie("remember_uname", null, -1, "/");
                }
            }
            return redirect()->to('/dashboard');
        } else {
            // Login failed
            session()->setFlashdata('error', "Login gagal, Data tidak ditemukan!");
            return redirect()->back()->withInput();
        }
    }
}
