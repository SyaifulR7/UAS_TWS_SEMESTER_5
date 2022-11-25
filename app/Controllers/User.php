<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class User extends BaseController
{
    use ResponseTrait;

    public function masuk()
    {
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $userModel->where('email', $email)->first();
        if(is_null($user)) {
            return $this->respond(['error' => 'Username Salah.'], 401);
        }
        $pwd_verify = password_verify($password, $user['password']);
        if(!$pwd_verify) {
            return $this->respond(['error' => 'Password Salah.'], 401);
        }
        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600;
        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat,
            "exp" => $exp,
            "email" => $user['email'],
        );
        $token = JWT::encode($payload, $key, 'HS256');
        $response = [
            'message' => 'Masuk Berhasil',
            'user' => $user,
            'token' => $token
        ];
        return $this->respond($response, 200);
    }

    public function daftar()
    {
        $rules = [
            'email' => [
                'rules' => 'required|min_length[4]|max_length[128]|valid_email|is_unique[tb_user.email]'
            ],
            'nama' => [
                'rules' => 'required|min_length[4]|max_length[128]'
            ],
            'profesi' => [
                'rules' => 'required|min_length[4]|max_length[50]'
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]'
            ],
            'konfirmasi_password'  => [
                'label' => 'confirm password', 'rules' => 'matches[password]'
            ,]
        ];
        if($this->validate($rules)){
            $model = new UserModel();
            $hari_ini = date('Y-m-d'); // mengambil data hari ini
            $nama = $this->request->getVar('nama');
            $profesi = $this->request->getVar('profesi');
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $data = [
                'nama' => $nama,
                'profesi' => $profesi,
                'email' => $email,
                'password' => password_hash($password,PASSWORD_BCRYPT),
                'role_id' => 1,
                'is_active' => 1,
                'tanggal_input' => $hari_ini,
                'tanggal_update' => $hari_ini,
            ];
            $model->save($data);
            return $this->respond([
                'message' => 'Berhasil Mendaftar',
                'user' => $data,
            ], 200);
        }else{
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Salah Input'
            ];
            return $this->fail($response , 409);
        }
    }

    public function user()
    {
        $userModel = new UserModel();
        return $this->respond([
            'users' => $userModel->findAll()
        ], 200);
    }
}