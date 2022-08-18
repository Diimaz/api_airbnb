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
    protected $allowedFields = ['pais'];


    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';

    public function findClientById($id)
    {
        $client = $this->asArray()->where(['idUsuario' => $id])->first();

        if (!$client) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $client;
    }
}