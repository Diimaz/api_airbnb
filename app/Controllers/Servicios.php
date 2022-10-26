<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Servicios extends BaseController
{
    public function index(){
        $model = model('UserModel');
        return $this->getResponse([
            'message' => 'Clients retrieved successfully',
            'usuarios' => $model->findAll()
        ]);
    }

    public function servicios(){
        $modelServicio = model('ServiciosModel');
        $modelImagen = model('ImagenesModel');
        $modelUsuario = model('UserModel');
        $modelAnfitrion = model('AnfitrionesModel');
        $modelMunicio = model('MunicipioModel');
        $modelTarifa = model('TarifasModel');
        $modelTipoHospedaje = model('TiposHospedajesModel');
        return $this->getResponse([
            'message' => 'Servicios',
            'servicios' => $modelServicio->where('estatus', 1)->findAll(),
            'usuarios' => $modelUsuario->findAll(),
            'anfitriones' => $modelAnfitrion->findAll(),
            'municipios' => $modelMunicio->findAll(),
            'tarifas' => $modelTarifa->findAll(),
            'tipoHospedaje' => $modelTipoHospedaje->findAll(),
            'imagenes' => $modelImagen->findAll(),
        ]);
    }
    
        public function usuarios($id){
        $modelUsuario = model('UserModel');
        $modelAnfitrion = model('AnfitrionesModel');
       
        return $this->getResponse([
            'message' => 'Usuarios',
            'usuario' => $modelUsuario->where('idUsuario', $id)->findAll(),
            'anfitrion' => $modelAnfitrion->where('idUsuario', $id)->findAll(),
           
        ]);
    }
    public function servicio($id){
        $modelServicio = model('ServiciosModel');
        $modelImagen = model('ImagenesModel');
        $modelAnfitrion = model('AnfitrionesModel');
        $modelUsuario = model('UserModel');
        $modelGuardarSubServicios = model('GuardarSubServiciosModel');
        $modelGuardarPoliticaCancelacion = model('GuardarPoliticasCancelacionModel');
        $modelGuardarReglaServicio = model('GuardarReglasServiciosModel');
        $modelGuardarSaludSeguridad = model('GuardarSaludSeguridadModel');
        $modelMunicio = model('MunicipioModel');
        $modelDepartamento = model('DepartamentoModel');
        $modelPais = model('PaisesModel');
        $modelPoliticaCancelacion = model('PoliticasCancelacionModel');
        $modelReglaServicio = model('ReglasServiciosModel');
        $modelSubServicio = model('SubServiciosModel');
        $modelSaludSeguridad = model('SaludSeguridadModel');
        $modelHuesped = model('HuespedesModel');
        $modelTarifa = model('TarifasModel');
        $modelIdioma = model('IdiomasModel');
        $modelTipoHospedaje = model('TiposHospedajesModel');

        $idAnfitrion = $modelServicio->where('idServicio',$id)->findColumn('idAnfitrion');
        $idUsuario = $modelAnfitrion->where('idAnfitrion',$idAnfitrion)->findColumn('idUsuario');
        $idTarifa = $modelServicio->where('idServicio',$id)->findcolumn('idTarifa');
        $arrayPoliticaCancelacion = $modelGuardarPoliticaCancelacion->where('idServicio',$id)->findColumn('idPoliticaCancelacion');
        $arrayReglaServicio = $modelGuardarReglaServicio->where('idServicio',$id)->findColumn('idReglaServicio');
        $arraySubServicios = $modelGuardarSubServicios->where('idServicio',$id)->findColumn('idSubServicio');
        $arraySaludSeguridad = $modelGuardarSaludSeguridad->where('idServicio',$id)->findColumn('idSaludSeguridad');
        $idiomaPrimario = $modelAnfitrion->where('idAnfitrion',$idAnfitrion)->findColumn('idiomaPrimario');
        $idiomaSecundario = $modelAnfitrion->where('idAnfitrion',$idAnfitrion)->findColumn('idiomaSecundario');
        $idiomaExtra = $modelAnfitrion->where('idAnfitrion',$idAnfitrion)->findColumn('idiomaExtra');
        $idTipoHospedaje = $modelServicio->where('idServicio',$id)->findColumn('idTipoHospedaje');
        $idMunicipio = $modelServicio->where('idServicio',$id)->findColumn('idMunicipio');
        $idDepartamento = $modelMunicio->where('idMunicipio',$idMunicipio)->findColumn('idDepartamento');
        $idPais = $modelDepartamento->where('idDepartamento',$idDepartamento)->findColumn('idPais');
        if($arrayPoliticaCancelacion == null){
            $arrayPoliticaCancelacion[] = '';
        }
        if($arrayReglaServicio == null){
            $arrayReglaServicio[] = '';
        }
        if($arraySubServicios == null){
            $arraySubServicios[] = '';
        }
        if($arraySaludSeguridad == null){
            $arraySaludSeguridad[] = '';
        }
        $modelServicio->servicio($id);
        $modelImagen->imagenes($id);
        $modelUsuario->usuario($idUsuario);
        $modelHuesped->huesped($id);
        $modelTarifa->tarifa($idTarifa);
        $modelAnfitrion->anfitrion($idAnfitrion);
        $modelTipoHospedaje->tipoHospedaje($idTipoHospedaje);
        $modelPais->pais($idPais);
        $modelDepartamento->departamentoID($idDepartamento);
        $modelMunicio->municipioID($idMunicipio);
        
        return $this->getResponse([
            'message' => 'Servicios',
            'servicio' => $modelServicio->findAll(),
            'imagenes' => $modelImagen->findAll(),
            'usuario' => $modelUsuario->findAll(),
            'politicaCancelacion' => $modelPoliticaCancelacion->whereIn('idPoliticaCancelacion',$arrayPoliticaCancelacion)->findAll(),
            'reglaServicio' => $modelReglaServicio->whereIn('idReglaServicio',$arrayReglaServicio)->findAll(),
            'saludSeguridad' => $modelSaludSeguridad->whereIn('idSaludSeguridad',$arraySaludSeguridad)->findAll(),
            'subServicio' => $modelSubServicio->whereIn('idSubServicio',$arraySubServicios)->findAll(),
            'huespedes'=> $modelHuesped->findAll(),
            'tarifa' => $modelTarifa->findAll(),
            'anfitrion' => $modelAnfitrion->findAll(),
            'idiomaPrimario' => $modelIdioma->idioma($idiomaPrimario)->findAll(),
            'idiomaSecundario' => $modelIdioma->idioma($idiomaSecundario)->findAll(),
            'idiomaExtra' => $modelIdioma->idioma($idiomaExtra)->findAll(),
            'tipoHospedaje' => $modelTipoHospedaje->findAll(),
            'pais' => $modelPais->findAll(),
            'departamento' => $modelDepartamento->findAll(),
            'municipio' => $modelMunicio->findAll(),
        ]);
    }

    public function servicioReserva($id){
        $modelServicio = model('ServiciosModel');
        $modelTarifa = model('TarifasModel');

        $idTarifa = $modelServicio->where('idServicio',$id)->findColumn('idTarifa');
        return $this->getResponse([
            'message' => 'Servicios',
            'servicio' => $modelServicio->where('idServicio',$id)->findAll(),
            'tarifa' => $modelTarifa->where('idTarifa',$idTarifa)->findAll(),
        ]);
    }

    public function paises(){
        $modelPais = model('PaisesModel');
        return $this->getResponse([
            'paises' => $modelPais->findAll()
        ]);
    }

    public function departamentos($id){
        $modelDepartamento = model('DepartamentoModel');
        $modelDepartamento->departamento($id);
        return $this->getResponse([
            'departamentos' => $modelDepartamento->findAll()
        ]);
    }

    public function municipios($id){
        $modelMunicipio = model('MunicipioModel');
        $modelMunicipio->municipio($id);
        return $this->getResponse([
            'municipios' => $modelMunicipio->findAll()
        ]);
    }
}