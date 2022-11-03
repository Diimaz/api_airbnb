<?php
namespace App\Models;

use CodeIgniter\Model;


class GuardarSubServiciosModel extends Model{
    
    protected $table      = 'tbl_guardar_sub_servicios';
    protected $primaryKey = 'idGuardar';

    protected $returnType     = 'object';
    protected $allowedFields = ['idSubServicio','idServicio'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;


}