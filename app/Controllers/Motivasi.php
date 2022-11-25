<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MotivasiModel;
use App\Models\UserModel;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Motivasi extends BaseController
{
    use ResponseTrait;

    public function list_motivasi()
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
            $MotivasiModel = new MotivasiModel();
            $data = [
                'total_motivasi' => $MotivasiModel->total_motivasi(),
                'list_motivasi' => $MotivasiModel->findAll(),
            ];
            return $this->respond([
                'motivasi' => $data,
            ], 200);
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function motivasi($id)
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
            $MotivasiModel = new MotivasiModel();
            $getDataMotivasi = $MotivasiModel->where([
                'id' => $id,
            ])->first();
            if($getDataMotivasi) {
                $data = [
                    'id' => $getDataMotivasi['id'],
                    'isi_motivasi' => $getDataMotivasi['isi_motivasi'],
                    'iduser' => $getDataMotivasi['iduser'],
                    'tanggal_input' => $getDataMotivasi['tanggal_input'],
                    'tanggal_update' => $getDataMotivasi['tanggal_update'],
                ];
                return $this->respond([
                    'motivasi' => $data,
                ], 200);
            } else {
                return $this->respond([
                    'error' => 'Data Motivasi Tidak Ditemukan.'
                ], 401);
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function tambah_motivasi()
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
            if ($getDataUser['role_id'] == 2) {
                $rules = [
                    'isi_motivasi' => [
                        'rules'=>'required'
                    ],
                ];
                if($this->validate($rules)){
                    $MotivasiModel = new MotivasiModel();
                    $hari_ini = date('Y-m-d'); // mengambil data hari ini
                    $isi_motivasi = $this->request->getVar('isi_motivasi');
                    $iduser = $getDataUser['iduser'];
                    $data = [
                        'iduser' => $iduser,
                        'isi_motivasi' => $isi_motivasi,
                        'tanggal_input' => $hari_ini,
                        'tanggal_update' => $hari_ini,
                    ];
                    $MotivasiModel->save($data);
                    return $this->respond([
                        'message' => 'Berhasil Menambahkan Motivasi',
                        'motivasi' => $data,
                    ], 200);
                } else {
                    $response = [
                        'errors' => $this->validator->getErrors(),
                        'message' => 'Salah Input'
                    ];
                    return $this->fail($response , 409);
                }
            } else {
                return $this->respond([
                    'error' => 'Anda Bukan Admin.'
                ], 401);
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function ubah_motivasi($id)
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
            $iduser = $getDataUser['iduser'];
            $hari_ini = date('Y-m-d'); // mengambil data hari ini
            $isi_motivasi = $this->request->getVar('isi_motivasi');
            $MotivasiModel = new MotivasiModel();
            $getDataMotivasi = $MotivasiModel->where([
                'id' => $id,
            ])->first();
            if($getDataMotivasi) {
                $data = [
                    'id' => $getDataMotivasi['id'],
                    'isi_motivasi' => $isi_motivasi,
                    'iduser' => $iduser,
                    'tanggal_input' => $getDataMotivasi['tanggal_input'],
                    'tanggal_update' => $hari_ini,
                ];
                $MotivasiModel->update_motivasi($data, $id);
                return $this->respond([
                    'message' => 'Berhasil Mengubah Motivasi',
                    'motivasi' => $data,
                ], 200);
            } else {
                return $this->respond([
                    'error' => 'Data Motivasi Tidak Ditemukan.'
                ], 401);
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }

    public function hapus_motivasi($id)
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
            $MotivasiModel = new MotivasiModel();
            $getDataMotivasi = $MotivasiModel->where([
                'id' => $id,
            ])->first();
            if($getDataMotivasi) {
                $MotivasiModel->hapus_motivasi($id);
                return $this->respond([
                    'message' => 'Berhasil Menghapus Motivasi',
                ], 200);
            } else {
                return $this->respond([
                    'error' => 'Data Motivasi Tidak Ditemukan.'
                ], 401);
            }
        } else {
            return $this->respond([
                'error' => 'Harus Login Terlebih Dahulu.'
            ], 401);
        }
    }
}