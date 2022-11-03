<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class TarifasModel extends Model
{

    protected $table = 'tbl_tarifas';
    protected $primaryKey = 'idTarifa';
    protected $allowedFields = ['precio','descuento'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';

    public function tarifa($id){
        $tarifa = $this->asArray()->where(['idTarifa' => $id]);

        if (!$tarifa) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $tarifa;
    }
}