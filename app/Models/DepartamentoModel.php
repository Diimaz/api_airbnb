<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartamentoModel extends Model
{
    /*protected $table = 'client';
    protected $allowedFields = [
        'name', 'email', 'retainer_fee'
    ];*/

    protected $table = 'tbl_departamentos';
    protected $primaryKey = 'idDepartamento';
    protected $allowedFields = ['departamento'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';

    public function departamentoID($id){
        $departamento = $this->asArray()->where(['idDepartamento' => $id]);

        if (!$departamento) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $departamento;
    }

    public function departamento($id){
        $departamentos = $this->asArray()->where(['idPais' => $id]);

        if (!$departamentos) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $departamentos;
    }
}