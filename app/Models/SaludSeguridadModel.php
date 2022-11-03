<?php
namespace App\Models;

use CodeIgniter\Model;


class SaludSeguridadModel extends Model{
    
    protected $table      = 'tbl_salud_y_seguridad';
    protected $primaryKey = 'idSaludSeguridad';

    protected $returnType     = 'object';
    protected $allowedFields = ['saludSeguridad'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;


}