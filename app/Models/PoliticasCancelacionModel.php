<?php
namespace App\Models;

use CodeIgniter\Model;


class PoliticasCancelacionModel extends Model{
    
    protected $table      = 'tbl_politicas_de_cancelacion';
    protected $primaryKey = 'idPoliticaCancelacion';

    protected $returnType     = 'object';
    protected $allowedFields = ['politicaCancelacion'];

    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $useTimestamps =true;

    public function politicaCancelacion($id){
        //$politicaCancelacion = $this->db()->table('tbl_politicas_de_cancelacion')->whereIn('idPoliticaCancelacion',$id)->get();
        $politicaCancelacion = $this->asArray()->where(['idPoliticaCancelacion' => $id]);

        if (!$politicaCancelacion) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $politicaCancelacion;
    }


}