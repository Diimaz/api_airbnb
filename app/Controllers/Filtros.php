<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Filtros extends BaseController
{
    public function filtros(){
      /*  $input = $this->getRequestInput($this->request);
        if(!isset($_POST['nombre'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['precioInicio'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['precioFinal'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['idAnfitrion'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['idMunicipio'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['idTipoHospedaje'])){
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
        }*/

        $rules = [  
            'precioInicio' => 'required|numeric',
            'precioFinal' => 'required|numeric',
            'idAnfitrion' => 'required',
            'idMunicipio' => 'required',
            'idTipoHospedaje' => 'required',
            

        ];

        $errors = [
            'precioInicio' => [
                'required' => 'Digite el precio de inicio',
                'numeric' => 'Solo digite numeros',
               
            ],
            'precioFinal' => [
                'required' => 'Digite el precio final',
                'numeric' => 'Solo digite numeros',
               
            ],
            'idAnfitrion' => [
                'required' => 'Digite un ID del Anfitrion',
               
               
            ],
            'idMunicipio' => [
                'required' => 'Digite un ID del Municipio',
               
            ],
            'idTipoHospedaje' => [
                'required' => 'Digite un ID del Hospedaje',
               
            ],

        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $tarifaModel = model('TarifasModel');
        $servicioModel = model('ServiciosModel');
        $anfitrionModel = model('AnfitrionesModel');
        $municipioModel = model('MunicipioModel');
        $tipoHospedajeModel = model('TiposHospedajesModel');

        if($input['idAnfitrion'] == 'all'){
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

        if($input['idMunicipio'] == 'all'){
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


        if($input['idTipoHospedaje'] == 'all'){
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
        $servicios = $servicioModel->whereIn('nombre', $arrayNombres)->whereIn('idAnfitrion', $arrayAnfitriones)->whereIn('idTarifa',$arrayTarifas)->whereIn('idMunicipio',$arrayMunicipios)->whereIn('idTipoHospedaje',$arrayHospedajes)->findAll();
        
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