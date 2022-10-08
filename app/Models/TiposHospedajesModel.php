<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class TiposHospedajesModel extends Model
{

    protected $table = 'tbl_tipo_hospedajes';
    protected $primaryKey = 'idTipoHospedaje';
    protected $allowedFields = ['tipoHospedaje'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}