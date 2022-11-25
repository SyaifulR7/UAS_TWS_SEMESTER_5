<?php

namespace App\Models;

use CodeIgniter\Model;

class MotivasiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_motivasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','isi_motivasi','iduser','tanggal_input','tanggal_update'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function total_motivasi()
	{	
		$builder = $this->db->table($this->table);
		$query = $builder->select('id')->countAllResults();
		return $query;
	}

    public function update_motivasi($data, $id)
    {
        $builder = $this->db->table($this->table);
        $query = $builder->where('id', $id);
        return $query->update($data);
    }

    public function hapus_motivasi($id)
    {
        $builder = $this->db->table($this->table);
        return $builder->delete(['id' => $id]);
    }
}