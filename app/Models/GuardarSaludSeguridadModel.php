<?php
namespace App\Models;

use CodeIgniter\Model;


class GuardarSaludSeguridadModel extends Model{
    
    protected $table      = 'tbl_guardar_salud_y_seguridad';
    protected $primaryKey = 'idGuardar';

    protected $returnType     = 'object';
    protected $allowedFields = ['idSaludSeguridad','idServicio'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;


}