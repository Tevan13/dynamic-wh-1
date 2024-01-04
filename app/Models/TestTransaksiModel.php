<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'tb_transaksi';
    protected $primaryKey = 'idTransaksi'; // Sesuaikan dengan nama primary key yang benar
    protected $allowedFields = ['idTransaksi', 'idPartno', 'idRak', 'unique_scanid', 'lot', 'quantity', 'status', 'pic', 'tgl_co'];

    public function getTransaksi()
    {
        $builder = $this->db->table('tb_transaksi');
        $builder->select('tb_transaksi.*, tb_rak.kode_rak, tb_partno.part_number');
        $builder->join('tb_rak', 'tb_rak.idRak = tb_transaksi.idRak'); // Sesuaikan dengan nama kolom yang benar
        $builder->join('tb_partno', 'tb_partno.id = tb_transaksi.idPartno'); // Sesuaikan dengan nama kolom yang benar
        return $builder->get()->getResultArray();
    }
}
