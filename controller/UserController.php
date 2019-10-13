<?php
require $_SERVER['DOCUMENT_ROOT'].'/skripsi/model/UserModel.php';
require "vendor/autoload.php";

class UserController
{
    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function login($request)
    {
        $user = $this->user->get_row([
            "email"  => $request['email'],
            "password"  => md5($request['password']),
        ]);

        # jika user tidak ada atau gagal login
        if ($user == null) {
            //pesan error gagal login
            return header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

        # proses login
        if ($user) {
            session_start();
            $_SESSION["admin"] = $user;
            header("Location: admin_home.php");
        }
    }

    public function logout($request)
    {
        session_start();
        session_destroy();
        return header("Location: login.php");
    }
}
