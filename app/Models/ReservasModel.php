<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ReservasModel extends Model
{

    protected $table = 'tbl_reservas';
    protected $primaryKey = 'idReserva';
    protected $allowedFields = ['idPago'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}