<?php

namespace App\Models;

use CodeIgniter\Model;

class MunicipioModel extends Model
{
    /*protected $table = 'client';
    protected $allowedFields = [
        'name', 'email', 'retainer_fee'
    ];*/

    protected $table = 'tbl_municipios';
    protected $primaryKey = 'idMunicipio';
    protected $allowedFields = ['municipio'];


    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';

    public function municipio($id)
    {
        $client = $this->asArray()->where(['idDepartamento' => $id]);

        if (!$client) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $client;
    }
}