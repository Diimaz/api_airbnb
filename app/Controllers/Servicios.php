<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Servicios extends BaseController
{
    public function index(){
        $this->eliminarFechasReservadas();
        $model = model('UserModel');
        return $this->getResponse([
            'message' => 'Clients retrieved successfully',
            'usuarios' => $model->findAll()
        ]);
    }

    public function filtroFechas(){
        $this->eliminarFechasReservadas();
        $input = $this->getRequestInput($this->request);
        
        if(!isset($input['fechaEntrada'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe fechaEntrada'
                ]
            ]);
        }
        if(!isset($input['fechaSalida'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe fechaSalida'
                ]
            ]);
        }

        $fechaReservaModel = model('FechasReservasModel');
        $serviciosModel = model('ServiciosModel');
        $modelImagen = model('ImagenesModel');
        $modelUsuario = model('UserModel');
        $modelAnfitrion = model('AnfitrionesModel');
        $modelMunicio = model('MunicipioModel');
        $modelTarifa = model('TarifasModel');
        $modelTipoHospedaje = model('TiposHospedajesModel');

        $fechaEntrada = $input['fechaEntrada'].' 00:00:00';
        $fechaSalida = $input['fechaSalida'].' 00:00:00';
        
        $diasReserva = $fechaReservaModel
        ->where('fechaSalida >=', $fechaEntrada)
        ->where('fechaEntrada <=', $fechaSalida)
        ->findColumn('idServicio');

        $arrayServicios = $serviciosModel->findColumn('idServicio');

        if($diasReserva != null){
            $arrayServicios = array_diff($arrayServicios,$diasReserva);
        }

        if($arrayServicios == null){
            $arrayServicios[] ='';
        }

        $idUsuario = $input['idUsuario'];

        $idAnfitrion = $modelAnfitrion->where('idUsuario',$idUsuario)->findColumn('idAnfitrion');
        $arrayAnfitriones = $serviciosModel->findColumn('idAnfitrion');
        if($arrayAnfitriones == null){
            $arrayAnfitriones[] = '';
        }
        if($idAnfitrion != null){
            $arrayAnfitriones = array_diff($arrayAnfitriones,array($idAnfitrion[0]));
        }

        $servicios = $serviciosModel->whereIn('idServicio',$arrayServicios)->whereIn('idAnfitrion',$arrayAnfitriones)->findAll();

        return $this->getResponse([
            'message' => 'Servicios',
            'servicios' => $serviciosModel->where('estatus',1)->whereIn('idServicio',$arrayServicios)->whereIn('idAnfitrion',$arrayAnfitriones)->findAll(),
            'usuarios' => $modelUsuario->findAll(),
            'anfitriones' => $modelAnfitrion->findAll(),
            'municipios' => $modelMunicio->findAll(),
            'tarifas' => $modelTarifa->findAll(),
            'tipoHospedaje' => $modelTipoHospedaje->findAll(),
            'imagenes' => $modelImagen->findAll(),
        ]);
    }

    /*public function servicios(){
        $this->eliminarFechasReservadas();
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
    }*/

    public function serviciosPost(){
        $this->eliminarFechasReservadas();
        $input = $this->getRequestInput($this->request);
        
        $modelServicio = model('ServiciosModel');
        $modelImagen = model('ImagenesModel');
        $modelUsuario = model('UserModel');
        $modelAnfitrion = model('AnfitrionesModel');
        $modelMunicio = model('MunicipioModel');
        $modelTarifa = model('TarifasModel');
        $modelTipoHospedaje = model('TiposHospedajesModel');

        $idUsuario = $input['idUsuario'];

        $idAnfitrion = $modelAnfitrion->where('idUsuario',$idUsuario)->findColumn('idAnfitrion');
        $arrayAnfitriones = $modelServicio->findColumn('idAnfitrion');
        if($arrayAnfitriones == null){
            $arrayAnfitriones[] = '';
        }
        if($idAnfitrion != null){
            $arrayAnfitriones = array_diff($arrayAnfitriones,array($idAnfitrion[0]));
        }
        return $this->getResponse([
            'message' => 'Servicios',
            'servicios' => $modelServicio->where('estatus',1)->whereIn('idAnfitrion',$arrayAnfitriones)->where('estatus', 1)->findAll(),
            'usuarios' => $modelUsuario->findAll(),
            'anfitriones' => $modelAnfitrion->findAll(),
            'municipios' => $modelMunicio->findAll(),
            'tarifas' => $modelTarifa->findAll(),
            'tipoHospedaje' => $modelTipoHospedaje->findAll(),
            'imagenes' => $modelImagen->findAll(),
        ]);
    }

    public function verServicio(){
        $this->eliminarFechasReservadas();
        $input = $this->getRequestInput($this->request);
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
        $idUsuarioComprobar = $input['idUsuario'];
        $id = $input['id'];

        $comprobar = $modelServicio->where('estatus',1)->where('idServicio',$id)->findAll();

        if($comprobar == null){
            return $this->getResponse([
                'message' => 'Error servicio no disponible'
            ]);
        }

        $idAnfitrionComprobar = $modelAnfitrion->where('idUsuario',$idUsuarioComprobar)->findColumn('idAnfitrion');
        $comprobarAnfitrion = $modelServicio->where('idServicio',$id)->where('idAnfitrion',$idAnfitrionComprobar)->findAll();

        if($comprobarAnfitrion != null){
            return $this->getResponse([
                'message' => 'Error servicio no disponible'
            ]);
        }

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

    public function usuario($id){
        $this->eliminarFechasReservadas();
        $modelUsuario = model ('UserModel');
        $modelAnfitrion = model('AnfitrionesModel');

        return $this->getResponse([
            'message' => 'Servicios',
            'usuario' => $modelUsuario->where('idUsuario',$id)->findAll(),
            'anfitrion' => $modelAnfitrion->where('idUsuario',$id)->findAll()
        ]);
    }

    public function servicioReserva($id){
        $this->eliminarFechasReservadas();
        $modelServicio = model('ServiciosModel');
        $modelTarifa = model('TarifasModel');
        $modelFechasReservas = model('FechasReservasModel');

        $idTarifa = $modelServicio->where('idServicio',$id)->findColumn('idTarifa');
        return $this->getResponse([
            'message' => 'Servicios',
            'servicio' => $modelServicio->where('idServicio',$id)->findAll(),
            'tarifa' => $modelTarifa->where('idTarifa',$idTarifa)->findAll(),
            'fechasReserva' => $modelFechasReservas->where('idServicio',$id)->findAll()
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