<?php
namespace App\Models;

use CodeIgniter\Model;


class ReglasServiciosModel extends Model{
    
    protected $table      = 'tbl_reglas_servicios';
    protected $primaryKey = 'idReglaServicio';

    protected $returnType     = 'object';
    protected $allowedFields = ['reglaServicio'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;


}