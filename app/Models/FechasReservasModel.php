<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class FechasReservasModel extends Model
{

    protected $table = 'tbl_fechas_reservas';
    protected $primaryKey = 'idFecha';
    protected $allowedFields = ['fechaEntrada','fechaSalida','idServicio'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}