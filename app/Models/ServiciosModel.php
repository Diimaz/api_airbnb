<?php
namespace App\Models;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;
//use App\Entities\Servicio;

class ServiciosModel extends Model{
    protected $table      = 'tbl_servicios';
    protected $primaryKey = 'idServicio';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;
    protected $returnType     = 'object';

    protected $allowedFields = ['nombre','foto','descripcion', 'disponibilidad','direccion','idAnfitrion','idTipoHospedaje','idTarifa','idMunicipio','idHuesped'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $deletedField  = 'date_delete';

    public function servicio($id){
        $servicio = $this->asArray()->where(['idServicio' => $id]);

        if (!$servicio) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $servicio;
    }
  
}