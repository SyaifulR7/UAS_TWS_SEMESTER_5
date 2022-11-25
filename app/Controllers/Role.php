<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RoleModel;
use App\Models\UserModel;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Role extends BaseController
{
    use ResponseTrait;

    public function tambah_role()
    {
        // untuk mengambil email di header // start
        $key        = getenv('JWT_SECRET');
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token      = $authHeader;
        if(!empty($authHeader)) {
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        // untuk mengambil email di header // end

        $UserModel = new UserModel();
        $getDataUser = $UserModel->where([
            'email' => $decoded->email,
        ])->first();

        if($getDataUser) {
            if($getDataUser['role_id'] == 1) {
                return $this->respond([
                    'email' => $decoded->email,
                    'role' => $getDataUser['role_id'],
                    'message' => 'Tidak Bisa Menambahkan Role, Role Anda Mahasiswa',
                ], 200);
            } else {
                $rules = [
                    'role' => ['rules'=>'required|is_unique[tb_role.role]'],
                ];
                if($this->validate($rules)){
                    $model = new RoleModel();
                    $role = $this->request->getVar('role');
                    $data = [
                        'role' => $role,
                    ];
                    $model->save($data);
                    return $this->respond([
                        'message' => 'Berhasil Menambahkan Role',
                        'role' => $data,
                    ], 200);
                } else {
                    $response = [
                        'errors' => $this->validator->getErrors(),
                        'message' => 'Salah Input'
                    ];
                    return $this->fail($response , 409);
                }
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function list_role()
    {
        // untuk mengambil email di header // start
        $key        = getenv('JWT_SECRET');
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token      = $authHeader;
        if(!empty($authHeader)) {
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        // untuk mengambil email di header // end

        $UserModel = new UserModel();
        $getDataUser = $UserModel->where([
            'email' => $decoded->email,
        ])->first();
        if($getDataUser) {
            $RoleModel = new RoleModel();
            $data = [
                'total_role' => $RoleModel->total_role(),
                'list_role' => $RoleModel->findAll(),
            ];
            return $this->respond([
                'role' => $data,
            ], 200);
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function role($id)
    {
        // untuk mengambil email di header // start
        $key        = getenv('JWT_SECRET');
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token      = $authHeader;
        if(!empty($authHeader)) {
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        // untuk mengambil email di header // end

        $UserModel = new UserModel();
        $getDataUser = $UserModel->where([
            'email' => $decoded->email,
        ])->first();
        if($getDataUser) {
            $RoleModel = new RoleModel();
            $getDataRole = $RoleModel->where([
                'id' => $id,
            ])->first();
            if($getDataRole) {
                $data = [
                    'id' => $getDataRole['id'],
                    'role' => $getDataRole['role'],
                ];
                return $this->respond([
                    'role' => $data,
                ], 200);
            } else {
                return $this->respond([
                    'error' => 'Data Role Tidak Ditemukan.'
                ], 401);
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function ubah_role($id)
    {
        // untuk mengambil email di header // start
        $key        = getenv('JWT_SECRET');
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token      = $authHeader;
        if(!empty($authHeader)) {
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        // untuk mengambil email di header // end

        $UserModel = new UserModel();
        $getDataUser = $UserModel->where([
            'email' => $decoded->email,
        ])->first();
        if($getDataUser) {
            $RoleModel = new RoleModel();
            $role = $this->request->getVar('role');
            $getDataRole = $RoleModel->where([
                'id' => $id,
            ])->first();
            if($getDataRole) {
                $data = [
                    'id' => $getDataRole['id'],
                    'role' => $role,
                ];
                $RoleModel->update_role($data, $id);
                return $this->respond([
                    'message' => 'Berhasil Mengubah Role',
                    'role' => $data,
                ], 200);
            } else {
                return $this->respond([
                    'error' => 'Data Role Tidak Ditemukan.'
                ], 401);
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function hapus_role($id)
    {
        // untuk mengambil email di header // start
        $key        = getenv('JWT_SECRET');
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token      = $authHeader;
        if(!empty($authHeader)) {
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        // untuk mengambil email di header // end

        $UserModel = new UserModel();
        $getDataUser = $UserModel->where([
            'email' => $decoded->email,
        ])->first();
        if($getDataUser) {
            $RoleModel = new RoleModel();
            $getDataRole = $RoleModel->where([
                'id' => $id,
            ])->first();
            if($getDataRole) {
                $RoleModel->hapus_role($id);
                return $this->respond([
                    'message' => 'Berhasil Menghapus Role',
                ], 200);
            } else {
                return $this->respond([
                    'error' => 'Data Role Tidak Ditemukan.'
                ], 401);
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }
}