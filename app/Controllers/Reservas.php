<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
class Reservas extends BaseController{
    public function misReservas(){
        $this->eliminarFechasReservadas();
        $input = $this->getRequestInput($this->request);
        $modelPagos = model('PagosModel');
        $modelServicio = model('ServiciosModel');
        $modelTipoHospedaje = model('TiposHospedajesModel');
        $modelAnfitrion = model('AnfitrionesModel');
        $modelUsuario = model('UserModel');
        $modelMunicipio = model('MunicipioModel');
        $modelDepartamento = model('DepartamentoModel');
        $modelPais = model('PaisesModel');
        $idUsuario = $input['idUsuario'];
        $date = date('Y-m-d');
        $arrayIdServicio = $modelPagos->where('idUsuario',$idUsuario)->findColumn('idServicio'); 
        if($arrayIdServicio == null){
            $arrayIdServicio[] = '';
        }
        return $this->getResponse([
            'message' => 'Servicios',
            'misReservas' => $modelPagos->where('fechaSalida >=',$date)->where('idUsuario',$idUsuario)->orderBy('fechaSalida','asc')->findAll(),
            'servicios' => $modelServicio->whereIn('idServicio',$arrayIdServicio)->findAll(),
            'tiposHospedajes' => $modelTipoHospedaje->findAll(),
            'anfitriones' => $modelAnfitrion->findAll(),
            'usuarios' => $modelUsuario->findAll(),
            'historial' => $modelPagos->where('fechaSalida <',$date)->where('idUsuario',$idUsuario)->orderBy('fechaSalida','asc')->findAll(),
            'municipios' => $modelMunicipio->findAll(),
            'departamentos' => $modelDepartamento->findAll(),
            'paises' => $modelPais->findAll(),
        ]);
    }

    private function eliminarFechasReservadas(){
        $modelFechasReservadas = model('FechasReservasModel');
        $date = date('Y-m-d 00:00:00');

        $arrayEliminar = $modelFechasReservadas->where('fechaSalida <', $date)->findColumn('idFecha');

        if($arrayEliminar == null){
            $arrayEliminar[] = '';
        }

        $modelFechasReservadas->delete($arrayEliminar);
    }
}