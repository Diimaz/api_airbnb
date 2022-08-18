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
    protected $allowedFields = ['departamento'];


    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';

    public function departamento($id)
    {
        $departamentos = $this->asArray()->where(['idPais' => $id]);

        if (!$departamentos) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $departamentos;
    }
}