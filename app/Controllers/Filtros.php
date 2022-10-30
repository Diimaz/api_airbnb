<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Filtros extends BaseController
{
    public function filtros(){
        $input = $this->getRequestInput($this->request);
        if(!isset($input['nombre'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($input['precioInicio'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($input['precioFinal'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($input['idAnfitrion'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($input['idMunicipio'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($input['idTipoHospedaje'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        $rules = service('validation');
        $rules->setRules([
            'precioInicio'=>'numeric',
            'precioFinal'=>'numeric',
        ],[
            'precioInicio' => [
                    'numeric' => 'Solo numeros',
            ],
            'precioFinal' => [
                'numeric' => 'Solo numeros',
        ],
        ]);

        if(!$rules->withRequest($this->request)->run()){
            return $this->getResponse($rules->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $tarifaModel = model('TarifasModel');
        $servicioModel = model('ServiciosModel');
        $anfitrionModel = model('AnfitrionesModel');
        $municipioModel = model('MunicipioModel');
        $tipoHospedajeModel = model('TiposHospedajesModel');

        if($input['idAnfitrion'] == 'all' || $input['idAnfitrion'] == null){
            $arrayAnfitriones = $anfitrionModel->findColumn('idAnfitrion');
        }else{
            $arrayAnfitriones = $anfitrionModel->Where('idAnfitrion',$input['idAnfitrion'])->findColumn('idAnfitrion');
            if($arrayAnfitriones == null){
                return $this->getResponse([
                    'message' => 'Este anfitrion no existe',
                ]);
            }
            $arrayAnfitriones[] = $input['idAnfitrion'];
        }


        if($input['idMunicipio'] == 'all' || $input['idMunicipio'] == null){
            $arrayMunicipios = $municipioModel->findColumn('idMunicipio');
        }else{
            $arrayMunicipios = $municipioModel->where('idMunicipio',$input['idMunicipio'])->findColumn('idMunicipio');
            if($arrayMunicipios == null){
                return $this->getResponse([
                    'message' => 'Este municipio no existe',
                ]);
            }
            $arrayMunicipios[] = $input['idMunicipio'];
        }


        if($input['idTipoHospedaje'] == 'all' || $input['idTipoHospedaje'] == null){
            $arrayHospedajes = $tipoHospedajeModel->findColumn('idTipoHospedaje');
        }else{
            $arrayHospedajes = $tipoHospedajeModel->where('idTipoHospedaje',$input['idTipoHospedaje'])->findColumn('idTipoHospedaje');
            if($arrayHospedajes == null){
                return $this->getResponse([
                    'message' => 'Este tipo de hospedaje no existe',
                ]);
            }
            $arrayHospedajes[] = $input['idTipoHospedaje'];
        }

        $arrayNombres = $servicioModel->findColumn('nombre');

        $arrayTarifas = $tarifaModel->where('precio >=', $input['precioInicio'])->where('precio <=', $input['precioFinal'])->findColumn('idTarifa');
        if($arrayTarifas == null){
            $arrayTarifas[] = 0;
        }
        $idUsuario = $input['idUsuario'];

        $idAnfitrion = $anfitrionModel->where('idUsuario',$idUsuario)->findColumn('idAnfitrion');
        $arrayAnfitriones = $servicioModel->findColumn('idAnfitrion');
        if($arrayAnfitriones == null){
            $arrayAnfitriones[] = '';
        }
        if($idAnfitrion != null){
            $arrayAnfitriones = array_diff($arrayAnfitriones,array($idAnfitrion[0]));
        }
        $servicios = $servicioModel->whereIn('idAnfitrion',$arrayAnfitriones)->whereIn('nombre', $arrayNombres)->whereIn('idAnfitrion', $arrayAnfitriones)->whereIn('idTarifa',$arrayTarifas)->whereIn('idMunicipio',$arrayMunicipios)->whereIn('idTipoHospedaje',$arrayHospedajes)->findAll();
        
        if($servicios == null){
            return $this->getResponse([
                'message' => 'No se encontraron resultados'
            ]);
        }
        return $this->getResponse([
            'message' => 'Filtro realizado',
            'servicios' => $servicios
        ]);
    }
}