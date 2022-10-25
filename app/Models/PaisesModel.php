<?php

namespace App\Models;

use CodeIgniter\Model;

class PaisesModel extends Model
{
    /*protected $table = 'client';
    protected $allowedFields = [
        'name', 'email', 'retainer_fee'
    ];*/

    protected $table = 'tbl_paises';
    protected $primaryKey = 'idPais';
    protected $allowedFields = ['pais'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';

    public function pais($id){
        $pais = $this->asArray()->where(['idPais' => $id]);

        if (!$pais) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $pais;
    }
}