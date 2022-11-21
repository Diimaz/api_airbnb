<?php
namespace App\Models;

use CodeIgniter\Model;


class GuardarPoliticasCancelacionModel extends Model{
    
    protected $table      = 'tbl_guardar_politicas_cancelacion';
    protected $primaryKey = 'idGuardar';

    protected $returnType     = 'object';
    protected $allowedFields = ['idPoliticaCancelacion','idServicio'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;


}