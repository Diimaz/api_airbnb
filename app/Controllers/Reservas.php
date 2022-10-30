<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
class Reservas extends BaseController{
    public function misReservas(){
        $input = $this->getRequestInput($this->request);
        $modelPagos = model('PagosModel');
        $modelServicio = model('ServiciosModel');
        $modelTipoHospedaje = model('TiposHospedajesModel');
        $idUsuario = $input['idUsuario'];
        $arrayIdServicio = $modelPagos->where('idUsuario',$idUsuario)->findColumn('idServicio'); 
        if($arrayIdServicio == null){
            $arrayIdServicio[] = '';
        }
        return $this->getResponse([
            'message' => 'Servicios',
            'misReservas' => $modelPagos->where('idUsuario',$idUsuario)->findAll(),
            'servicios' => $modelServicio->whereIn('idServicio',$arrayIdServicio)->findAll(),
            'tiposHospedajes' => $modelTipoHospedaje->findAll()
        ]);
    }
}