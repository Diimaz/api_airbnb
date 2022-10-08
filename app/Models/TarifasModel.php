<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class TarifasModel extends Model
{

    protected $table = 'tbl_tarifas';
    protected $primaryKey = 'idTarifa';
    protected $allowedFields = ['precio','descuento'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}