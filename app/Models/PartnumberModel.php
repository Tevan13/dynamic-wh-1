<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnumberModel extends Model
{
    protected $table            = 'tb_partno';
    protected $primaryKey       = 'idPartNo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
