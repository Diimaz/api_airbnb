<?php
namespace App\Models;

use CodeIgniter\Model;


class GuardarReglasServiciosModel extends Model{
    
    protected $table      = 'tbl_guardar_reglas_servicios';
    protected $primaryKey = 'idGuardar';

    protected $returnType     = 'object';
    protected $allowedFields = ['idReglaServicio','idServicio'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;


}