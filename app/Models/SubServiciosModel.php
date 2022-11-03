<?php
namespace App\Models;

use CodeIgniter\Model;


class SubServiciosModel extends Model{
    
    protected $table      = 'tbl_sub_servicios';
    protected $primaryKey = 'idSubServicio';

    protected $returnType     = 'object';
    protected $allowedFields = ['subServicio'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;


}