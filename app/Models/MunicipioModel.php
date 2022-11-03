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
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';

    public function municipioID($id){
        $municipio = $this->asArray()->where(['idMunicipio' => $id]);

        if (!$municipio) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $municipio;
    }

    public function municipio($id)
    {
        $municipios = $this->asArray()->where(['idDepartamento' => $id]);

        if (!$municipios) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $municipios;
    }
}