<?php

namespace App\Models;

use CodeIgniter\Model;

class TemaModel extends Model
{
    protected $table         = 'tema';
    protected $allowedFields = [
        'id_student', 'id_mentor', 'status', 'deleted_at'
    ];
    protected $returnType    = 'array';
}