<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ImagenesModel extends Model
{

    protected $table = 'tbl_imagenes';
    protected $primaryKey = 'idImagen';
    protected $allowedFields = ['url','idServicio'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';

    public function imagenes($id)
    {
        $imagenes = $this->asArray()->where(['idServicio' => $id]);

        if (!$imagenes) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $imagenes;
    }
}